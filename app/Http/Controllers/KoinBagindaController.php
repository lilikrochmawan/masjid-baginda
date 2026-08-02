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
                if (str_starts_with($route, 'koin.qr.generate') && !$user->hasAccess('koin.qr.generate')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Generate QR.');
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

    public function inventory(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $search = $request->query('search');

        $query = Kaleng::with('latestPemilik');

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('kode_kaleng', 'like', "%{$search}%")
                  ->orWhere('nama_kaleng', 'like', "%{$search}%")
                  ->orWhereHas('latestPemilik', function($qp) use ($search) {
                      $qp->where('nama', 'like', "%{$search}%")
                        ->orWhere('no_wa', 'like', "%{$search}%")
                        ->orWhere('alamat', 'like', "%{$search}%");
                  });
            });
        }

        $kalengs = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return view('koin.inventory', compact('user', 'hakakses', 'kalengs', 'search'));
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
        $transactions = TransaksiKaleng::with(['kaleng.latestPemilik', 'user'])->orderBy('tanggal_ambil', 'desc')->get();

        return view('koin.scan', compact('user', 'hakakses', 'transactions'));
    }

    public function laporan(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        // Fetch transactions in this period to get the scanning officer
        $transactionsInPeriod = TransaksiKaleng::with('user')
            ->whereYear('tanggal_ambil', $year)
            ->whereMonth('tanggal_ambil', $month)
            ->get()
            ->keyBy('tb_kaleng_id');

        $scannedIds = $transactionsInPeriod->keys()->toArray();

        $kalengSudah = Kaleng::with('latestPemilik')
            ->whereIn('id', $scannedIds)
            ->orderBy('kode_kaleng')
            ->get();

        $kalengBelum = Kaleng::with('latestPemilik')
            ->whereNotIn('id', $scannedIds)
            ->orderBy('kode_kaleng')
            ->get();

        // Gabungkan seluruh kaleng dengan menyematkan status dan petugas
        $allKalengs = [];
        foreach ($kalengBelum as $k) {
            $allKalengs[] = [
                'id' => $k->id,
                'kode_kaleng' => $k->kode_kaleng,
                'nama_kaleng' => $k->nama_kaleng,
                'pemilik' => $k->latestPemilik?->nama ?? '-',
                'alamat' => $k->latestPemilik?->alamat ?? '-',
                'status' => 'Belum Scan',
                'status_code' => 0,
                'petugas' => '-'
            ];
        }
        foreach ($kalengSudah as $k) {
            $t = $transactionsInPeriod->get($k->id);
            $allKalengs[] = [
                'id' => $k->id,
                'kode_kaleng' => $k->kode_kaleng,
                'nama_kaleng' => $k->nama_kaleng,
                'pemilik' => $k->latestPemilik?->nama ?? '-',
                'alamat' => $k->latestPemilik?->alamat ?? '-',
                'status' => 'Sudah Scan',
                'status_code' => 1,
                'petugas' => $t?->user?->name ?? '-'
            ];
        }

        $penerimaan = PenerimaanKaleng::with('user')->orderBy('tanggal_penerimaan', 'desc')->get();
        $totalPenerimaan = $penerimaan->sum('jumlah');

        $penerimaanList = [];
        foreach ($penerimaan as $item) {
            $penerimaanList[] = [
                'id' => $item->id,
                'tanggal_penerimaan' => $item->tanggal_penerimaan,
                'tanggal_formatted' => \Illuminate\Support\Carbon::parse($item->tanggal_penerimaan)->format('d M Y'),
                'jumlah' => $item->jumlah,
                'jumlah_formatted' => 'Rp ' . number_format($item->jumlah, 0, ',', '.'),
                'keterangan' => $item->keterangan ?? '-',
                'user_name' => $item->user?->name ?? '-'
            ];
        }

        return view('koin.laporan', compact(
            'user',
            'hakakses',
            'kalengSudah',
            'kalengBelum',
            'allKalengs',
            'penerimaan',
            'penerimaanList',
            'totalPenerimaan',
            'year',
            'month'
        ));
    }

    public function printLaporan(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if (!$user->hasAccess('koin.laporan')) {
            abort(403, 'Anda tidak memiliki hak akses untuk Laporan.');
        }

        $type = $request->query('type', 'bulanan');
        $month = $request->query('bulan', now()->month);
        $year = $request->query('tahun', now()->year);

        $query = PenerimaanKaleng::with('user');

        if ($type === 'bulanan') {
            $query->whereMonth('tanggal_penerimaan', $month)
                  ->whereYear('tanggal_penerimaan', $year);
        } elseif ($type === 'tahunan') {
            $query->whereYear('tanggal_penerimaan', $year);
        }

        $penerimaan = $query->orderBy('tanggal_penerimaan', 'asc')->get();
        $totalPenerimaan = $penerimaan->sum('jumlah');

        $setting = \App\Models\Setting::first();
        $logoImage = $setting && $setting->logo ? asset('storage/' . $setting->logo) : asset('images/image.png');

        $bulanNama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $periodeText = '';
        if ($type === 'bulanan') {
            $periodeText = $bulanNama[(int)$month] . ' ' . $year;
        } elseif ($type === 'tahunan') {
            $periodeText = 'Tahun ' . $year;
        } else {
            $periodeText = 'Semua Periode';
        }

        return view('koin.laporan_print', compact(
            'penerimaan',
            'totalPenerimaan',
            'logoImage',
            'type',
            'periodeText'
        ));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'kode_kaleng' => 'required|string|exists:tb_kaleng,kode_kaleng',
            'tanggal_ambil' => 'required|date',
            'qr_signature' => 'required|string',
        ]);

        $expected = substr(hash_hmac('sha256', $request->kode_kaleng, config('app.key') ?? 'default_secret'), 0, 16);

        if (!hash_equals($expected, $request->qr_signature)) {
            return redirect()->route('koin.scan')
                ->with('error', 'QR Code tidak valid atau bukan berasal dari aplikasi ini.')
                ->withInput();
        }

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
            'tb_user_id' => Auth::id(),
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
                'template' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Bapak/Ibu *{nama_pemilik}*,\n\nKaleng dengan kode *{kode_kaleng}* ({nama_kaleng}) telah berhasil discan / diambil oleh petugas *{nama_petugas}* pada tanggal *{tanggal_ambil}*.\n\nTerima kasih atas infak dan partisipasi Anda dalam program Koin Baginda. Semoga menjadi amal jariyah dan membawa berkah bagi keluarga.\n\n*_Wassalamu'alaikum wr. wb._*"
            ]
        );

        // Auto-update existing template if it doesn't contain {nama_petugas}
        if (!str_contains($templateObj->template, '{nama_petugas}')) {
            $newTemplate = str_replace(
                'oleh petugas pada tanggal',
                'oleh petugas *{nama_petugas}* pada tanggal',
                $templateObj->template
            );
            if (!str_contains($newTemplate, '{nama_petugas}')) {
                $newTemplate = str_replace(
                    'oleh petugas',
                    'oleh petugas *{nama_petugas}*',
                    $templateObj->template
                );
            }
            $templateObj->update(['template' => $newTemplate]);
            $templateObj->template = $newTemplate;
        }

        $templateText = $templateObj->template;

        // Format variables (Force Indonesian Month)
        $formattedTanggalEn = Carbon::parse($transaksi->tanggal_ambil)->format('d F Y');
        $monthsId = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April',
            'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus',
            'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $formattedTanggal = strtr($formattedTanggalEn, $monthsId);

        $petugasName = Auth::user()?->name ?? 'Petugas';

        $message = strtr($templateText, [
            '{nama_pemilik}' => $pemilik->nama,
            '{kode_kaleng}' => $kaleng->kode_kaleng,
            '{nama_kaleng}' => $kaleng->nama_kaleng,
            '{tanggal_ambil}' => $formattedTanggal,
            '{nama_petugas}' => $petugasName,
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

    public function qrGenerator()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $kalengs = Kaleng::with('latestPemilik')->orderBy('kode_kaleng')->get();

        foreach ($kalengs as $kaleng) {
            $kaleng->signature = substr(hash_hmac('sha256', $kaleng->kode_kaleng, config('app.key') ?? 'default_secret'), 0, 16);
        }

        return view('koin.qr_generator', compact('user', 'hakakses', 'kalengs'));
    }
}
