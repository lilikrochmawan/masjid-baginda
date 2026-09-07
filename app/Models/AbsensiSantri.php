<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiSantri extends Model
{
    use HasFactory;

    protected $table = 'tb_absensi_santri';

    protected $fillable = [
        'tb_santri_id',
        'tb_kelas_id',
        'tb_guru_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    /**
     * Get the student associated with the attendance record.
     */
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'tb_santri_id');
    }

    /**
     * Get the class associated with the attendance record.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'tb_kelas_id');
    }

    /**
     * Get the teacher who took attendance.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'tb_guru_id');
    }
}
