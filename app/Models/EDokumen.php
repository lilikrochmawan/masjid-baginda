<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EDokumen extends Model
{
    use HasFactory;

    protected $table = 'tb_edokumen';

    protected $fillable = [
        'nama_dokumen',
        'deskripsi',
        'file_path',
        'file_type',
        'file_size',
        'tb_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }
}
