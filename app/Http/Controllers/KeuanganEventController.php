<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeuanganEvent;
use App\Models\KeuanganEventTransaksi;
use App\Models\Kas;
use Illuminate\Support\Facades\DB;

class KeuanganEventController extends Controller
{
    public function index()
    {
        $events = KeuanganEvent::orderBy('created_at', 'desc')->get();
        return view('keuangan.event.index', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        KeuanganEvent::create($request->all());

        return redirect()->route('keuangan.event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show($id)
    {
        $event = KeuanganEvent::with(['transaksis' => function($q) {
            $q->orderBy('tanggal_kas', 'asc')->orderBy('id', 'asc');
        }])->findOrFail($id);

        $totalMasuk = $event->transaksis->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $event->transaksis->where('tipe', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('keuangan.event.show', compact('event', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function storeTransaksi(Request $request, $id)
    {
        $event = KeuanganEvent::findOrFail($id);
        
        if ($event->is_transferred) {
            return redirect()->back()->with('error', 'Saldo event sudah ditransfer, data tidak bisa ditambah/diedit.');
        }

        $request->validate([
            'tanggal_kas' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $event->transaksis()->create($request->all());

        return redirect()->route('keuangan.event.show', $id)->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function transferSaldo($id)
    {
        $event = KeuanganEvent::findOrFail($id);
        
        if ($event->is_transferred) {
            return redirect()->back()->with('error', 'Saldo event sudah ditransfer.');
        }

        $saldo = $event->saldo;

        if ($saldo <= 0) {
            return redirect()->back()->with('error', 'Tidak ada sisa saldo (saldo Rp 0 atau minus) untuk ditransfer.');
        }

        DB::beginTransaction();
        try {
            // Masukkan ke Kas utama
            Kas::create([
                'tanggal_kas' => now()->toDateString(),
                'tipe' => 'masuk',
                'jumlah' => $saldo,
                'keterangan' => 'Sisa Saldo Event: ' . $event->nama_event,
                'tb_user_id' => auth()->id() ?? 1,
                'status' => 'confirmed'
            ]);

            // Tandai event sudah ditransfer
            $event->update(['is_transferred' => true]);

            DB::commit();
            return redirect()->route('keuangan.event.show', $id)->with('success', 'Sisa saldo sebesar Rp ' . number_format($saldo, 0, ',', '.') . ' berhasil ditransfer ke kas utama masjid.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
