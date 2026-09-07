<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RencanaKerja extends Model
{
    use HasFactory;

    protected $table = 'tb_rencana_kerja';

    protected $fillable = [
        'tb_takmir_id',
        'nama_program',
        'deskripsi',
        'anggaran',
        'target_selesai',
        'status',
    ];

    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(Takmir::class, 'tb_takmir_id');
    }
}
