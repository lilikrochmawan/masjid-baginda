<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestasiSantri extends Model
{
    use HasFactory;

    protected $table = 'tb_prestasi_santri';

    protected $fillable = [
        'tb_santri_id',
        'tb_guru_id',
        'tb_user_id',
        'tanggal',
        'tipe',
        'materi',
        'iqro_jilid',
        'iqro_halaman',
        'alquran_surah',
        'alquran_ayat',
        'juz_amma_surah',
        'juz_amma_ayat',
        'tb_tpq_master_hafalan_id',
        'keterangan',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'tb_santri_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'tb_guru_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    public function masterHafalan(): BelongsTo
    {
        return $this->belongsTo(TpqMasterHafalan::class, 'tb_tpq_master_hafalan_id');
    }
}
