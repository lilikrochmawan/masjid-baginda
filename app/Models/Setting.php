<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'tb_setting';

    protected $fillable = [
        'fonnte_token',
        'midtrans_client_id',
        'midtrans_server_key',
        'midtrans_environment',
        'foto_masjid',
        'logo',
    ];
}
