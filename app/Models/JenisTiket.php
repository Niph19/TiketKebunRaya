<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama_tiket
 * @property string $lokasi
 * @property string|null $deskripsi
 * @property int $harga_dewasa
 * @property int $harga_anak
 * @property bool $is_active
 */
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

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
