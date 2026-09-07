<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table = 'tb_surat_template';

    protected $fillable = [
        'nama_template',
        'konten',
        'header_title',
        'header_subtitle',
    ];
}
