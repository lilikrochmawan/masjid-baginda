<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\SppPembayaran;
use App\Models\TpqKas;
use App\Models\WaTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TpqKeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('tpq') || !$user->hasAccess('tpq.keuangan')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul Keuangan TPQ.');
            }
            return $next($request);
        });
    }

    /**
     * Helper to get Indonesian month names.
     */
    private function getMonthName($monthNum): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[(int)$monthNum] ?? '';
    }

    /**
     * Display the SPP payment grid.
     */
    public function sppIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $year = $request->input('year', date('Y'));
        $kelasId = $request->input('kelas_id');
        $search = $request->input('search');

        $kelas = Kelas::all();

        $santriQuery = Santri::with('kelas');
        if ($kelasId) {
            $santriQuery->where('tb_kelas_id', $kelasId);
        }
        if ($search) {
            $santriQuery->where(function($q) use ($search) {
                $q->where('nama_santri', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }
        $santris = $santriQuery->get();

        // Fetch payments for selected year
        $payments = SppPembayaran::where('tahun', $year)
            ->get()
            ->groupBy('tb_santri_id');

        return view('tpq.keuangan.spp', compact(
            'user', 'hakakses', 'santris', 'kelas', 'year', 'kelasId', 'payments'
        ));
    }

    /**
     * Store an SPP payment and trigger broadcast.
     */
    public function sppStore(Request $request)
    {
        $validated = $request->validate([
            'tb_santri_id' => 'required|exists:tb_santri,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jumlah' => 'required|integer|min:1',
            'tanggal_bayar' => 'required|date',
        ]);

        $santri = Santri::findOrFail($validated['tb_santri_id']);

        // Check duplicate
        $existing = SppPembayaran::where('tb_santri_id', $validated['tb_santri_id'])
            ->where('bulan', $validated['bulan'])
            ->where('tahun', $validated['tahun'])
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['spp' => 'SPP untuk santri ini pada bulan/tahun tersebut sudah lunas.']);
        }

        DB::beginTransaction();
        try {
            // Save payment
            $pembayaran = SppPembayaran::create([
                'tb_santri_id' => $validated['tb_santri_id'],
                'bulan' => $validated['bulan'],
                'tahun' => $validated['tahun'],
                'jumlah' => $validated['jumlah'],
                'tanggal_bayar' => $validated['tanggal_bayar'],
                'tb_user_id' => Auth::id(),
            ]);

            // Save to TPQ Kas
            $bulanName = $this->getMonthName($validated['bulan']);
            TpqKas::create([
                'tanggal' => $validated['tanggal_bayar'],
                'tipe' => 'masuk',
                'jumlah' => $validated['jumlah'],
                'keterangan' => "Pembayaran SPP Ananda {$santri->nama_santri} untuk bulan {$bulanName} {$validated['tahun']}",
                'tb_spp_pembayaran_id' => $pembayaran->id,
                'tb_user_id' => Auth::id(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['spp' => 'Gagal menyimpan pembayaran: ' . $e->getMessage()]);
        }

        // Send WA Broadcast
        $waStatus = $this->sendWaBroadcast($pembayaran);

        return redirect()->back()->with('success', 'Pembayaran SPP berhasil disimpan. ' . $waStatus);
    }

    /**
     * Send manual WA Broadcast for specific payment.
     */
    public function sppBroadcast($id)
    {
        $pembayaran = SppPembayaran::findOrFail($id);
        $waStatus = $this->sendWaBroadcast($pembayaran);
        return redirect()->back()->with('success', 'Percobaan pengiriman broadcast selesai. ' . $waStatus);
    }

    /**
     * Helper method to send Fonnte WhatsApp broadcast.
     */
    private function sendWaBroadcast(SppPembayaran $pembayaran): string
    {
        $santri = $pembayaran->santri;
        $phone = $santri->no_hp_orang_tua;

        if (empty($phone)) {
            return 'Broadcast WA tidak terkirim karena nomor HP orang tua kosong.';
        }

        $setting = \App\Models\Setting::first();
        if ($setting && !$setting->whatsapp_status) {
            return 'Broadcast WA tidak terkirim karena fitur WhatsApp Gateway dinonaktifkan.';
        }
        $token = ($setting && $setting->fonnte_token) ? $setting->fonnte_token : env('FONNTE_TOKEN');
        if (empty($token)) {
            return 'Broadcast WA tidak terkirim karena token Fonnte belum disetel di pengaturan sistem atau di server.';
        }

        // Fetch template
        $templateObj = WaTemplate::where('key', 'spp_kuitansi')->first();
        $templateText = $templateObj ? $templateObj->template : "Pembayaran SPP Ananda {nama_santri} bulan {bulan} {tahun} sebesar Rp {jumlah} telah diterima pada tanggal {tanggal_bayar}.";

        // Format variables
        $bulanName = $this->getMonthName($pembayaran->bulan);
        $formattedJumlah = number_format($pembayaran->jumlah, 0, ',', '.');
        $formattedTanggal = Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y');

        $message = strtr($templateText, [
            '{nama_santri}' => $santri->nama_santri,
            '{bulan}' => $bulanName,
            '{tahun}' => $pembayaran->tahun,
            '{jumlah}' => $formattedJumlah,
            '{tanggal_bayar}' => $formattedTanggal,
            '{nama_wali}' => $santri->nama_ayah ?: ($santri->nama_ibu ?: '-'),
            '{penerima}' => Auth::user()->name,
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
                return 'Broadcast WA berhasil dikirim ke ' . $santri->no_hp_orang_tua . '.';
            } else {
                $err = $resData['reason'] ?? $response->body();
                return 'Gagal kirim WA via Fonnte: ' . $err;
            }
        } catch (\Exception $e) {
            return 'Gagal menghubungkan ke server Fonnte: ' . $e->getMessage();
        }
    }

    /**
     * Display the SPP payment logs / recap.
     */
    public function rekapIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $month = $request->input('month');
        $year = $request->input('year', date('Y'));
        $kelasId = $request->input('kelas_id');

        $kelas = Kelas::all();

        $query = SppPembayaran::with(['santri.kelas', 'user']);

        if ($month) {
            $query->where('bulan', $month);
        }
        if ($year) {
            $query->where('tahun', $year);
        }
        if ($kelasId) {
            $query->whereHas('santri', function ($q) use ($kelasId) {
                $q->where('tb_kelas_id', $kelasId);
            });
        }

        $payments = $query->orderByDesc('tanggal_bayar')->get();

        return view('tpq.keuangan.rekap', compact(
            'user', 'hakakses', 'kelas', 'month', 'year', 'kelasId', 'payments'
        ));
    }

    /**
     * Display general cashflow ledger.
     */
    public function kasIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $kasEntries = TpqKas::with(['user', 'sppPembayaran.santri'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('tpq.keuangan.kas', compact('user', 'hakakses', 'kasEntries'));
    }

    /**
     * Store general cashflow entry.
     */
    public function kasStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:1000',
        ]);

        TpqKas::create([
            'tanggal' => $validated['tanggal'],
            'tipe' => $validated['tipe'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'tb_spp_pembayaran_id' => null, // Manual entry
            'tb_user_id' => Auth::id(),
        ]);

        return redirect()->route('tpq.keuangan.kas.index')->with('success', 'Transaksi Kas berhasil disimpan.');
    }

    /**
     * Display cashflow reports.
     */
    public function laporanIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Query entries during this period
        $kasEntries = TpqKas::with(['user', 'sppPembayaran.santri'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate aggregates for current period
        $totalMasukSpp = TpqKas::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'masuk')
            ->whereNotNull('tb_spp_pembayaran_id')
            ->sum('jumlah');

        $totalMasukLain = TpqKas::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'masuk')
            ->whereNull('tb_spp_pembayaran_id')
            ->sum('jumlah');

        $totalKeluar = TpqKas::whereBetween('tanggal', [$startDate, $endDate])
            ->where('tipe', 'keluar')
            ->sum('jumlah');

        // Total aggregates overall (up to end date) for total current balance
        $overallMasuk = TpqKas::where('tipe', 'masuk')->where('tanggal', '<=', $endDate)->sum('jumlah');
        $overallKeluar = TpqKas::where('tipe', 'keluar')->where('tanggal', '<=', $endDate)->sum('jumlah');
        $saldoAkhir = $overallMasuk - $overallKeluar;

        return view('tpq.keuangan.laporan', compact(
            'user', 'hakakses', 'startDate', 'endDate', 'kasEntries',
            'totalMasukSpp', 'totalMasukLain', 'totalKeluar', 'saldoAkhir'
        ));
    }
}
