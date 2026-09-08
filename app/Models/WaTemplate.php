<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaTemplate extends Model
{
    protected $table = 'tb_wa_template';
    protected $fillable = [
        'key', 
        'template', 
        'waba_template_name', 
        'waba_template_language', 
        'waba_template_variables'
    ];
}
