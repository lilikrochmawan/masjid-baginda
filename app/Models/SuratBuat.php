<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratBuat extends Model
{
    use HasFactory;

    protected $table = 'tb_surat_buat';

    protected $fillable = [
        'nomor_surat',
        'template_key',
        'header_title',
        'header_subtitle',
        'perihal',
        'tanggal_surat',
        'tujuan_surat',
        'isi_surat',
        
        // TTE fields
        'nama_sekretaris',
        'status_sekretaris',
        'ttd_sekretaris',
        
        'nama_ketua',
        'status_ketua',
        'ttd_ketua',
        
        'nama_penasehat',
        'status_penasehat',
        'ttd_penasehat',
        
        'created_by',
        'is_draft',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'is_draft' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
