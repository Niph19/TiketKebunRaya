<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'pesanan_id',
        'kategori_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
    
    public function kategori()
    {
        return $this->belongsTo(TiketKategori::class, 'kategori_id');
    }
}
