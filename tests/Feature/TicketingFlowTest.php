<?php

use App\Models\JenisTiket;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function createTicketType(): JenisTiket
{
    return JenisTiket::create([
        'nama_tiket' => 'Tiket Reguler',
        'lokasi' => 'Kebun Raya',
        'deskripsi' => 'Kunjungan kebun raya.',
        'harga_dewasa' => 25000,
        'harga_anak' => 12000,
        'is_active' => true,
    ]);
}

function createTicketOrder(User $user, JenisTiket $jenisTiket, string $status = 'pending', ?string $proof = null): Pesanan
{
    return Pesanan::create([
        'kode_invoice' => 'INV-'.uniqid(),
        'user_id' => $user->getKey(),
        'jenis_tiket_id' => $jenisTiket->id,
        'tanggal_kunjungan' => now()->addDays(2)->toDateString(),
        'jumlah_dewasa' => 1,
        'jumlah_anak' => 0,
        'harga_dewasa' => $jenisTiket->harga_dewasa,
        'harga_anak' => $jenisTiket->harga_anak,
        'total_harga' => $jenisTiket->harga_dewasa,
        'status' => $status,
        'bukti_pembayaran' => $proof,
    ]);
}

test('visitor can see active ticket types and open a booking form', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();

    $this->get(route('index'))
        ->assertOk()
        ->assertSee('Tiket Reguler')
        ->assertSee('Rp 25.000');

    $this->actingAs($user)
        ->get(route('pesanan.create', $jenisTiket))
        ->assertOk()
        ->assertSee('Tanggal kunjungan')
        ->assertSee('Tiket dewasa');
});

test('user can create an order with prices calculated from the database', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();

    $response = $this->actingAs($user)->post(route('pesanan.store'), [
        'jenis_tiket_id' => $jenisTiket->id,
        'tanggal_kunjungan' => now()->addDays(3)->toDateString(),
        'jumlah_dewasa' => 2,
        'jumlah_anak' => 1,
        'total_harga' => 1,
    ]);

    $pesanan = Pesanan::firstOrFail();

    $response->assertRedirect(route('pesanan.show', $pesanan));
    $this->assertSame(62000, $pesanan->total_harga);
    $this->assertSame('pending', $pesanan->status);
    $this->assertNotEmpty($pesanan->kode_invoice);
    $this->assertNull($pesanan->kode_tiket);
});

test('order needs at least one ticket', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();

    $this->actingAs($user)
        ->post(route('pesanan.store'), [
            'jenis_tiket_id' => $jenisTiket->id,
            'tanggal_kunjungan' => now()->addDays(2)->toDateString(),
            'jumlah_dewasa' => 0,
            'jumlah_anak' => 0,
        ])
        ->assertSessionHasErrors('jumlah_dewasa');

    $this->assertDatabaseCount('pesanans', 0);
});

test('user uploads a payment proof and order waits for admin confirmation', function () {
    Storage::fake('local');
    $user = User::factory()->create();
    $jenisTiket = createTicketType();
    $pesanan = createTicketOrder($user, $jenisTiket);

    $this->actingAs($user)
        ->post(route('pesanan.bukti', $pesanan), [
            'bukti_pembayaran' => UploadedFile::fake()->image('bukti.png'),
        ])
        ->assertRedirect();

    $pesanan->refresh();
    $this->assertSame('menunggu_konfirmasi', $pesanan->status);
    Storage::disk('local')->assertExists($pesanan->bukti_pembayaran);
});

test('payment proof larger than 2 MB is rejected', function () {
    Storage::fake('local');
    $user = User::factory()->create();
    $pesanan = createTicketOrder($user, createTicketType());

    $this->actingAs($user)
        ->post(route('pesanan.bukti', $pesanan), [
            'bukti_pembayaran' => UploadedFile::fake()->create('bukti.pdf', 2049, 'application/pdf'),
        ])
        ->assertSessionHasErrors('bukti_pembayaran');

    $this->assertSame('pending', $pesanan->fresh()->status);
});

test('user cannot view another users order or download a ticket before payment is approved', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();
    $pesanan = createTicketOrder(User::factory()->create(), $jenisTiket);

    $this->actingAs($user)
        ->get(route('pesanan.show', $pesanan))
        ->assertForbidden();

    $ownOrder = createTicketOrder($user, $jenisTiket);
    $this->get(route('pesanan.tiket', $ownOrder))->assertForbidden();
});

test('admin can approve a payment that has a proof', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();
    $pesanan = createTicketOrder($user, $jenisTiket, 'menunggu_konfirmasi', 'bukti-pembayaran/bukti.png');
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.pesanan.approve', $pesanan))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertSame('lunas', $pesanan->fresh()->status);
    $this->assertNotEmpty($pesanan->fresh()->kode_tiket);
});

test('non-admin cannot approve a payment', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();
    $pesanan = createTicketOrder($user, $jenisTiket, 'menunggu_konfirmasi', 'bukti-pembayaran/bukti.png');

    $this->actingAs($user)
        ->post(route('admin.pesanan.approve', $pesanan))
        ->assertForbidden();

    $this->assertSame('menunggu_konfirmasi', $pesanan->fresh()->status);
});

test('paid order can be downloaded as a PDF with a ticket code', function () {
    $user = User::factory()->create();
    $jenisTiket = createTicketType();
    $pesanan = createTicketOrder($user, $jenisTiket, 'lunas');

    $response = $this->actingAs($user)->get(route('pesanan.tiket', $pesanan));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    $response->assertHeader('content-disposition');
    $this->assertNotEmpty($pesanan->fresh()->kode_tiket);
});

test('admin can add and deactivate a ticket type', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('admin.jenis-tiket.store'), [
            'nama_tiket' => 'Kunjungan Anggrek',
            'lokasi' => 'Rumah Kaca',
            'deskripsi' => 'Koleksi anggrek.',
            'harga_dewasa' => 30000,
            'harga_anak' => 15000,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.jenis-tiket.index'));

    $jenisTiket = JenisTiket::where('nama_tiket', 'Kunjungan Anggrek')->firstOrFail();

    $this->actingAs($admin)
        ->put(route('admin.jenis-tiket.update', $jenisTiket), [
            'nama_tiket' => 'Kunjungan Anggrek',
            'lokasi' => 'Rumah Kaca',
            'harga_dewasa' => 30000,
            'harga_anak' => 15000,
        ])
        ->assertRedirect(route('admin.jenis-tiket.index'));

    $this->assertFalse($jenisTiket->fresh()->is_active);
});
