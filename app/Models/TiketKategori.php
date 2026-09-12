<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketKategori extends Model
{
    //

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
