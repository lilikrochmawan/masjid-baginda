<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'tb_inventaris';

    protected $fillable = [
        'tb_barang_id',
        'kode_inventaris',
        'tanggal_perolehan',
        'asal_usul',
        'kondisi',
        'lokasi',
        'harga_perolehan',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'tb_barang_id');
    }
}
