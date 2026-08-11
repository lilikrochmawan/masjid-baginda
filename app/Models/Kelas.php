<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tb_kelas';

    protected $fillable = [
        'nama_kelas',
        'tb_guru_id',
    ];

    /**
     * Get the teacher (walikelas/pengampu) of this class.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'tb_guru_id');
    }

    /**
     * Get the teachers (walikelas/pengampu) of this class.
     */
    public function gurus(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Guru::class, 'tb_kelas_guru', 'tb_kelas_id', 'tb_guru_id');
    }

    /**
     * Get the students registered in this class.
     */
    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'tb_kelas_id');
    }
}
