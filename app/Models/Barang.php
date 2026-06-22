<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'tb_barang';

    protected $fillable = [
        'tb_jenis_barang_id',
        'nama_barang',
        'satuan',
        'keterangan',
    ];

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisBarang::class, 'tb_jenis_barang_id');
    }

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'tb_barang_id');
    }
}
