<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'tb_santri';

    protected $fillable = [
        'tb_kelas_id',
        'nis',
        'nama_santri',
        'nama_panggilan',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat_rumah',
        'nama_ayah',
        'nama_ibu',
        'no_hp_orang_tua',
    ];

    /**
     * Get the class associated with the student.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'tb_kelas_id');
    }

    /**
     * Get the attendance records of the student.
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(AbsensiSantri::class, 'tb_santri_id');
    }

    /**
     * Get the SPP payments of the student.
     */
    public function sppPembayaran(): HasMany
    {
        return $this->hasMany(SppPembayaran::class, 'tb_santri_id');
    }
}
