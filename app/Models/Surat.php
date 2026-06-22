<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'tb_surat';

    protected $fillable = [
        'tipe',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'penerima',
        'perihal',
        'file_path',
        'status_proposal',
        'keterangan',
    ];
}
