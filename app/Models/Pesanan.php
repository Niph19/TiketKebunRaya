<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'kode_invoice',
        'user_id',
        'tanggal_kunjungan',
        'jumlah_dewasa',
        'jumlah_anak',
        'total_harga',
        'status',
        'bukti_pembayaran',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detail()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
