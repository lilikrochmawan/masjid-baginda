<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kaleng extends Model
{
    use HasFactory;

    protected $table = 'tb_kaleng';

    protected $fillable = [
        'kode_kaleng',
        'nama_kaleng',
        'deskripsi',
    ];

    public function pemilikKaleng(): HasMany
    {
        return $this->hasMany(PemilikKaleng::class, 'tb_kaleng_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiKaleng::class, 'tb_kaleng_id');
    }

    public function latestPemilik(): HasOne
    {
        return $this->hasOne(PemilikKaleng::class, 'tb_kaleng_id')->latestOfMany();
    }
}
