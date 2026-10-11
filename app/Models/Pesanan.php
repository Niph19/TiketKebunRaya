<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $jenis_tiket_id
 * @property string $kode_invoice
 * @property string|null $kode_tiket
 * @property Carbon $tanggal_kunjungan
 * @property int $jumlah_dewasa
 * @property int $jumlah_anak
 * @property int $harga_dewasa
 * @property int $harga_anak
 * @property int $total_harga
 * @property string $status
 * @property string|null $bukti_pembayaran
 */
class Pesanan extends Model
{
    protected $fillable = [
        'kode_invoice',
        'kode_tiket',
        'jenis_tiket_id',
        'user_id',
        'tanggal_kunjungan',
        'jumlah_dewasa',
        'jumlah_anak',
        'harga_dewasa',
        'harga_anak',
        'total_harga',
        'status',
        'bukti_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisTiket()
    {
        return $this->belongsTo(JenisTiket::class);
    }
}
