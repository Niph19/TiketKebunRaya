<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketKategori extends Model
{
    protected $fillable = [
        'nama',
        'harga',
        'deskripsi',
        'is_active',
    ];

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
