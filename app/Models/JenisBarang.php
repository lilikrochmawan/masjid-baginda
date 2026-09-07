<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'tb_jenis_barang';

    protected $fillable = [
        'nama_jenis',
        'keterangan',
    ];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'tb_jenis_barang_id');
    }
}
