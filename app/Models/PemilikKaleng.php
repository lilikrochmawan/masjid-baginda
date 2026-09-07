<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemilikKaleng extends Model
{
    use HasFactory;

    protected $table = 'tb_pemilikkaleng';

    protected $fillable = [
        'tb_kaleng_id',
        'nama',
        'alamat',
        'no_wa',
        'tanggal_diserahkan',
    ];

    protected $casts = [
        'tanggal_diserahkan' => 'date',
    ];

    public function kaleng(): BelongsTo
    {
        return $this->belongsTo(Kaleng::class, 'tb_kaleng_id');
    }
}
