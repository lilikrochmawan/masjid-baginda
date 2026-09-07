<?php

namespace App\Models;

use App\Models\Kas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanKaleng extends Model
{
    use HasFactory;

    protected $table = 'tb_penerimaan_kaleng';

    protected $fillable = [
        'tanggal_penerimaan',
        'jumlah',
        'tb_user_id',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tb_user_id');
    }

    public function kas()
    {
        return $this->hasOne(Kas::class, 'tb_penerimaan_kaleng_id');
    }
}
