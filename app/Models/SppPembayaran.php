<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SppPembayaran extends Model
{
    protected $table = 'tb_spp_pembayaran';
    protected $fillable = [
        'tb_santri_id',
        'bulan',
        'tahun',
        'jumlah',
        'tanggal_bayar',
        'tb_user_id',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'tb_santri_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    public function tpqKas(): HasOne
    {
        return $this->hasOne(TpqKas::class, 'tb_spp_pembayaran_id');
    }
}
