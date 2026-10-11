<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesananTiket;
use App\Models\JenisTiket;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(): View
    {
        $pesanans = auth()->user()
            ->pesanan()
            ->with('jenisTiket')
            ->latest()
            ->paginate(10);

        return view('user.dashboard', compact('pesanans'));
    }

    public function create(JenisTiket $jenisTiket): View
    {
        abort_unless($jenisTiket->is_active, 404);

        return view('user.pesan', compact('jenisTiket'));
    }

    public function store(PesananTiket $request): RedirectResponse
    {
        $jenisTiket = JenisTiket::findOrFail($request->integer('jenis_tiket_id'));
        abort_unless($jenisTiket->is_active, 404);

        $jumlahDewasa = $request->integer('jumlah_dewasa');
        $jumlahAnak = $request->integer('jumlah_anak');

        if ($jumlahDewasa + $jumlahAnak < 1) {
            return back()
                ->withErrors(['jumlah_dewasa' => 'Pilih minimal satu tiket.'])
                ->withInput();
        }

        $pesanan = DB::transaction(function () use ($request, $jenisTiket, $jumlahDewasa, $jumlahAnak) {
            $hargaDewasa = $jenisTiket->harga_dewasa;
            $hargaAnak = $jenisTiket->harga_anak;

            return Pesanan::create([
                'kode_invoice' => 'INV-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
                'jenis_tiket_id' => $jenisTiket->id,
                'user_id' => $request->user()->id,
                'tanggal_kunjungan' => $request->validated('tanggal_kunjungan'),
                'jumlah_dewasa' => $jumlahDewasa,
                'jumlah_anak' => $jumlahAnak,
                'harga_dewasa' => $hargaDewasa,
                'harga_anak' => $hargaAnak,
                'total_harga' => ($jumlahDewasa * $hargaDewasa) + ($jumlahAnak * $hargaAnak),
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('pesanan.show', $pesanan)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(Pesanan $pesanan): View
    {
        $this->ensureOwner($pesanan);
        $pesanan->load('jenisTiket');

        return view('user.show', compact('pesanan'));
    }

    public function uploadBukti(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $this->ensureOwner($pesanan);

        if (! \in_array($pesanan->status, ['pending', 'ditolak'], true)) {
            return back()->with('error', 'Bukti pembayaran tidak dapat diubah pada status pesanan ini.');
        }

        $validated = $request->validate([
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = $validated['bukti_pembayaran']->store('bukti-pembayaran', 'local');

        if (! $path) {
            throw new \RuntimeException('Bukti pembayaran gagal disimpan.');
        }

        if ($pesanan->bukti_pembayaran) {
            Storage::disk('local')->delete($pesanan->bukti_pembayaran);
        }

        $pesanan->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_konfirmasi',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu konfirmasi admin.');
    }

    public function downloadTicket(Pesanan $pesanan)
    {
        $this->ensureOwner($pesanan);
        abort_unless($pesanan->status === 'lunas', 403, 'E-ticket hanya tersedia setelah pembayaran dikonfirmasi.');

        if (! $pesanan->kode_tiket) {
            $pesanan->update(['kode_tiket' => (string) Str::uuid()]);
        }

        $qrCode = Builder::create()
            ->writer(new SvgWriter)
            ->data($pesanan->kode_tiket)
            ->size(240)
            ->margin(10)
            ->build()
            ->getDataUri();

        $pesanan->load(['user', 'jenisTiket']);

        return Pdf::loadView('tiket.pdf', compact('pesanan', 'qrCode'))
            ->download('e-tiket-'.$pesanan->kode_invoice.'.pdf');
    }

    private function ensureOwner(Pesanan $pesanan): void
    {
        abort_unless($pesanan->user_id === auth()->id(), 403);
    }
}
