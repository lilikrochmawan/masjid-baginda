<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganEvent extends Model
{
    use HasFactory;

    protected $fillable = ['nama_event', 'tanggal_mulai', 'tanggal_selesai', 'is_transferred'];

    public function transaksis()
    {
        return $this->hasMany(KeuanganEventTransaksi::class, 'keuangan_event_id');
    }

    public function getSaldoAttribute()
    {
        $masuk = $this->transaksis()->where('tipe', 'masuk')->sum('jumlah');
        $keluar = $this->transaksis()->where('tipe', 'keluar')->sum('jumlah');
        return $masuk - $keluar;
    }
}
