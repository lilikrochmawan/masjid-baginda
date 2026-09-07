<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaTemplate extends Model
{
    protected $table = 'tb_wa_template';
    protected $fillable = ['key', 'template'];
}
