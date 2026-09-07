<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TpqKas extends Model
{
    protected $table = 'tb_tpq_kas';
    protected $fillable = [
        'tanggal',
        'tipe',
        'jumlah',
        'keterangan',
        'tb_spp_pembayaran_id',
        'tb_user_id',
    ];

    public function sppPembayaran(): BelongsTo
    {
        return $this->belongsTo(SppPembayaran::class, 'tb_spp_pembayaran_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }
}
