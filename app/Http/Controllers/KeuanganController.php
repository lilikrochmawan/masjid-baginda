<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\PenerimaanKaleng;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class KeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('keuangan')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul Keuangan.');
            }

            $route = $request->route()->getName();
            if ($route) {
                if (str_starts_with($route, 'keuangan.laporan') && !$user->hasAccess('keuangan.laporan')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Laporan Keuangan.');
                }
                if (str_starts_with($route, 'keuangan.index') && !$user->hasAccess('keuangan.transaksi')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Kas & Transaksi.');
                }
            }

            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $pendingKas = collect();
        $pendingKasCount = 0;

        if ($hakakses->nama_hakakses === 'bendahara') {
            $pendingKas = Kas::with(['user', 'penerimaanKaleng'])
                ->where('tipe', 'masuk')
                ->where('status', 'pending')
                ->orderBy('tanggal_kas', 'asc')
                ->get();

            $pendingKasCount = $pendingKas->count();
        }

        $kasEntries = Kas::with(['user', 'penerimaanKaleng'])
            ->orderByDesc('tanggal_kas')
            ->get();

        $penerimaanOptions = PenerimaanKaleng::with('user')
            ->doesntHave('kas')
            ->orderByDesc('tanggal_penerimaan')
            ->get();

        return view('keuangan.index', compact(
            'user',
            'hakakses',
            'pendingKas',
            'pendingKasCount',
            'kasEntries',
            'penerimaanOptions'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $validated = $request->validate([
            'tanggal_kas' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'tb_penerimaan_kaleng_id' => 'nullable|exists:tb_penerimaan_kaleng,id',
        ]);

        $validated['tb_user_id'] = Auth::id();
        $validated['status'] = 'confirmed';

        if ($validated['tipe'] === 'masuk' && $hakakses->nama_hakakses !== 'bendahara') {
            $validated['status'] = 'pending';
        }

        Kas::create($validated);

        return redirect()->route('keuangan.index')->with('success', 'Data kas berhasil disimpan.');
    }

    public function confirm($id)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if ($hakakses->nama_hakakses !== 'bendahara') {
            abort(403);
        }

        $kas = Kas::findOrFail($id);

        if ($kas->status !== 'pending' || $kas->tipe !== 'masuk') {
            return redirect()->route('keuangan.index')->with('error', 'Konfirmasi tidak dapat dilakukan.');
        }

        $kas->status = 'confirmed';
        $kas->save();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi kas masuk berhasil dikonfirmasi.');
    }

    public function laporan(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $periode = $request->query('periode', 'monthly');
        $selectedDate = Carbon::parse($request->query('date', now()->format('Y-m-d')));

        $kasQuery = Kas::with(['user', 'penerimaanKaleng']);

        if ($periode === 'daily') {
            $kasQuery->whereDate('tanggal_kas', $selectedDate);
            $periodeLabel = 'Harian';
        } elseif ($periode === 'weekly') {
            $start = $selectedDate->copy()->startOfWeek();
            $end = $selectedDate->copy()->endOfWeek();
            $kasQuery->whereBetween('tanggal_kas', [$start, $end]);
            $periodeLabel = 'Mingguan';
        } else {
            $kasQuery->whereYear('tanggal_kas', $selectedDate->year)
                ->whereMonth('tanggal_kas', $selectedDate->month);
            $periodeLabel = 'Bulanan';
        }

        $kasEntries = $kasQuery->orderByDesc('tanggal_kas')->get();
        $totalMasuk = $kasEntries->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $kasEntries->where('tipe', 'keluar')->sum('jumlah');
        $net = $totalMasuk - $totalKeluar;

        $overallMasuk = Kas::where('tipe', 'masuk')->sum('jumlah');
        $overallKeluar = Kas::where('tipe', 'keluar')->sum('jumlah');
        $overallNet = $overallMasuk - $overallKeluar;

        return view('keuangan.laporan', compact(
            'user',
            'hakakses',
            'kasEntries',
            'totalMasuk',
            'totalKeluar',
            'net',
            'overallNet',
            'periode',
            'periodeLabel',
            'selectedDate'
        ));
    }
}
