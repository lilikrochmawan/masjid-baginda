<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappGroup extends Model
{
    use HasFactory;

    protected $table = 'tb_whatsapp_group';

    protected $fillable = [
        'group_name',
        'group_id',
    ];
}
