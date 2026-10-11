<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTiket extends Model
{
    protected $fillable = [
        'nama_tiket',
        'lokasi',
        'deskripsi',
        'harga_dewasa',
        'harga_anak',
        'is_active',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
