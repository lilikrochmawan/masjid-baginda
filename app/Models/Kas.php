<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'tb_kas';

    protected $fillable = [
        'tanggal_kas',
        'tipe',
        'jumlah',
        'keterangan',
        'tb_user_id',
        'tb_penerimaan_kaleng_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    public function penerimaanKaleng()
    {
        return $this->belongsTo(PenerimaanKaleng::class, 'tb_penerimaan_kaleng_id');
    }
}
