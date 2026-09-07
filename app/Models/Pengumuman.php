<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'tb_pengumuman';

    protected $fillable = [
        'image_path',
        'title',
    ];
}
