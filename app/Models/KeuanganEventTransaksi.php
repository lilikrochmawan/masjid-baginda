<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganEventTransaksi extends Model
{
    use HasFactory;

    protected $fillable = ['keuangan_event_id', 'tanggal_kas', 'tipe', 'jumlah', 'keterangan'];

    public function event()
    {
        return $this->belongsTo(KeuanganEvent::class, 'keuangan_event_id');
    }
}
