<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiKaleng extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi_kaleng';

    protected $fillable = [
        'tb_kaleng_id',
        'tanggal_ambil',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_ambil' => 'date',
    ];

    public function kaleng(): BelongsTo
    {
        return $this->belongsTo(Kaleng::class, 'tb_kaleng_id');
    }
}
