<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakmirBroadcastTemplate extends Model
{
    use HasFactory;

    protected $table = 'tb_takmir_broadcast_template';

    protected $fillable = [
        'nama_template',
        'isi_template',
    ];
}
