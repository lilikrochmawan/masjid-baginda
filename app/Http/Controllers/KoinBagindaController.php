<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use App\Models\Kaleng;
use App\Models\PemilikKaleng;
use App\Models\PenerimaanKaleng;
use App\Models\TransaksiKaleng;
use App\Models\Setting;
use App\Models\WaTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class KoinBagindaController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('koin')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul Koin Baginda.');
            }

            $route = $request->route()->getName();
            if ($route) {
                if (str_starts_with($route, 'koin.inventory') && !$user->hasAccess('koin.inventory')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Inventori Kaleng.');
                }
                if (str_starts_with($route, 'koin.pemilik') && !$user->hasAccess('koin.pemilik')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Pemilik Kaleng.');
                }
                if (str_starts_with($route, 'koin.scan') && !$user->hasAccess('koin.scan')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Transaksi Scan.');
                }
                if (str_starts_with($route, 'koin.laporan') && !$user->hasAccess('koin.laporan')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Laporan Koin.');
                }
            }

            return $next($request);
        });
    }

    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $stats = [
            'kaleng' => Kaleng::count(),
            'pemilik' => PemilikKaleng::count(),
            'transaksi' => TransaksiKaleng::count(),
        ];

        return view('koin.index', compact('user', 'hakakses', 'stats'));
    }

    public function inventory()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $kalengs = Kaleng::with('latestPemilik')->orderBy('id', 'desc')->get();

        return view('koin.inventory', compact('user', 'hakakses', 'kalengs'));
    }

    public function storeKaleng(Request $request)
    {
        $request->validate([
            'nama_kaleng' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $last = Kaleng::orderBy('id', 'desc')->first();
        $nextId = $last?->id ? $last->id + 1 : 1;
        $kode = 'BGD' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        Kaleng::create([
            'kode_kaleng' => $kode,
            'nama_kaleng' => $request->nama_kaleng,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('koin.inventory')->with('success', 'Kaleng baru berhasil ditambahkan.');
    }

    public function pemilik()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        // Hanya tampilkan kaleng yang belum memiliki pemilik
        $kalengs = Kaleng::doesntHave('pemilikKaleng')
            ->orderBy('kode_kaleng')
            ->get();

        return view('koin.pemilik', compact('user', 'hakakses', 'kalengs'));
    }

    public function storePemilik(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:1000',
            'no_wa' => 'required|string|max:25',
            'tb_kaleng_id' => 'required|exists:tb_kaleng,id',
            'tanggal_diserahkan' => 'required|date',
        ]);

        PemilikKaleng::create($request->only(['nama', 'alamat', 'no_wa', 'tb_kaleng_id', 'tanggal_diserahkan']));

        return redirect()->route('koin.pemilik')->with('success', 'Data pemilik kaleng berhasil disimpan.');
    }

    public function updatePemilik(Request $request, $id)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'alamat' => 'required|string|max:1000',
            'no_wa' => 'required|string|max:25',
        ]);

        $pemilik = PemilikKaleng::findOrFail($id);
        $pemilik->update($request->only(['nama', 'alamat', 'no_wa']));

        return redirect()->route('koin.inventory')->with('success', 'Data pemilik berhasil diperbarui.');
    }

    public function scan()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $transactions = TransaksiKaleng::with('kaleng.latestPemilik')->orderBy('tanggal_ambil', 'desc')->get();

        return view('koin.scan', compact('user', 'hakakses', 'transactions'));
    }

    public function laporan()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $year = now()->year;
        $month = now()->month;

        $scannedIds = TransaksiKaleng::whereYear('tanggal_ambil', $year)
            ->whereMonth('tanggal_ambil', $month)
            ->pluck('tb_kaleng_id')
            ->unique()
            ->toArray();

        $kalengSudah = Kaleng::with('latestPemilik')
            ->whereIn('id', $scannedIds)
            ->orderBy('kode_kaleng')
            ->get();

        $kalengBelum = Kaleng::with('latestPemilik')
            ->whereNotIn('id', $scannedIds)
            ->orderBy('kode_kaleng')
            ->get();

        $penerimaan = PenerimaanKaleng::with('user')->orderBy('tanggal_penerimaan', 'desc')->get();
        $totalPenerimaan = $penerimaan->sum('jumlah');

        return view('koin.laporan', compact(
            'user',
            'hakakses',
            'kalengSudah',
            'kalengBelum',
            'penerimaan',
            'totalPenerimaan'
        ));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'kode_kaleng' => 'required|string|exists:tb_kaleng,kode_kaleng',
            'tanggal_ambil' => 'required|date',
        ]);

        $kaleng = Kaleng::where('kode_kaleng', $request->kode_kaleng)->firstOrFail();

        // Cek apakah kaleng sudah discan bulan ini
        $sudahScan = TransaksiKaleng::where('tb_kaleng_id', $kaleng->id)
            ->whereYear('tanggal_ambil', now()->year)
            ->whereMonth('tanggal_ambil', now()->month)
            ->exists();

        if ($sudahScan) {
            return redirect()->route('koin.scan')
                ->with('error', "Kaleng {$kaleng->kode_kaleng} sudah discan bulan ini.")
                ->withInput();
        }

        $transaksi = TransaksiKaleng::create([
            'tb_kaleng_id' => $kaleng->id,
            'tanggal_ambil' => $request->tanggal_ambil,
            'keterangan' => 'Pengambilan isi kaleng bulanan',
        ]);

        // Send WA Broadcast
        $waStatus = $this->sendWaBroadcast($transaksi);

        return redirect()->route('koin.scan')->with('success', "Kaleng {$kaleng->kode_kaleng} berhasil dicatat. " . $waStatus);
    }

    /**
     * Send WhatsApp broadcast to the can owner.
     */
    private function sendWaBroadcast(TransaksiKaleng $transaksi): string
    {
        $kaleng = $transaksi->kaleng;
        if (!$kaleng) {
            return 'Pesan WA tidak terkirim karena data kaleng tidak ditemukan.';
        }
        $pemilik = $kaleng->latestPemilik;
        if (!$pemilik) {
            return 'Pesan WA tidak terkirim karena pemilik kaleng tidak ditemukan.';
        }
        $phone = $pemilik->no_wa;
        if (empty($phone)) {
            return 'Pesan WA tidak terkirim karena nomor WA pemilik kosong.';
        }

        $setting = Setting::first();
        $token = ($setting && $setting->fonnte_token) ? $setting->fonnte_token : env('FONNTE_TOKEN');
        if (empty($token)) {
            return 'Pesan WA tidak terkirim karena token Fonnte belum disetel di pengaturan sistem atau di server.';
        }

        // Fetch or create template
        $templateObj = WaTemplate::firstOrCreate(
            ['key' => 'koin_scan'],
            [
                'template' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Bapak/Ibu *{nama_pemilik}*,\n\nKaleng dengan kode *{kode_kaleng}* ({nama_kaleng}) telah berhasil discan / diambil oleh petugas pada tanggal *{tanggal_ambil}*.\n\nTerima kasih atas infak dan partisipasi Anda dalam program Koin Baginda. Semoga menjadi amal jariyah dan membawa berkah bagi keluarga.\n\n*_Wassalamu'alaikum wr. wb._*"
            ]
        );

        $templateText = $templateObj->template;

        // Format variables
        $formattedTanggal = Carbon::parse($transaksi->tanggal_ambil)->translatedFormat('d F Y');

        $message = strtr($templateText, [
            '{nama_pemilik}' => $pemilik->nama,
            '{kode_kaleng}' => $kaleng->kode_kaleng,
            '{nama_kaleng}' => $kaleng->nama_kaleng,
            '{tanggal_ambil}' => $formattedTanggal,
        ]);

        // Normalize phone number to international format
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $phone,
                'message' => $message,
            ]);

            $resData = $response->json();
            if ($response->successful() && isset($resData['status']) && $resData['status'] == true) {
                return 'Pesan WA berhasil dikirim ke ' . $pemilik->no_wa . '.';
            } else {
                $err = $resData['reason'] ?? $response->body();
                return 'Gagal kirim WA via Fonnte: ' . $err;
            }
        } catch (\Exception $e) {
            return 'Gagal menghubungkan ke server Fonnte: ' . $e->getMessage();
        }
    }
}
