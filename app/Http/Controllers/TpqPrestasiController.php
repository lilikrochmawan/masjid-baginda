<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Setting;
use App\Models\WaTemplate;
use App\Models\TpqMasterHafalan;
use App\Models\PrestasiSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class TpqPrestasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Public route doesn't require login
            if ($request->route()->getName() === 'tpq.prestasi.public') {
                return $next($request);
            }

            $user = Auth::user();
            if (!$user->hasAccess('tpq')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul TPQ.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of prestasi records and the creation form.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        // Fetch students based on role
        $isGuru = $hakakses->nama_hakakses !== 'administrator';
        if ($isGuru) {
            $guru = $user->guru;
            if ($guru) {
                $kelasIds = Kelas::whereHas('gurus', function ($q) use ($guru) {
                    $q->where('tb_guru.id', $guru->id);
                })->pluck('id');
                $santris = Santri::with('kelas')->whereIn('tb_kelas_id', $kelasIds)->orderBy('nama_santri')->get();
            } else {
                $santris = collect();
            }
            $riwayat = PrestasiSantri::whereIn('tb_santri_id', $santris->pluck('id'))
                ->with(['santri', 'guru', 'user', 'masterHafalan'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        } else {
            $santris = Santri::with('kelas')->orderBy('nama_santri')->get();
            $riwayat = PrestasiSantri::with(['santri', 'guru', 'user', 'masterHafalan'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        }

        $masterHafalan = TpqMasterHafalan::orderBy('kategori')->orderBy('nama')->get();

        // 114 Surahs of Al-Quran
        $surahs = [
            1 => 'Al-Fatihah', 2 => 'Al-Baqarah', 3 => 'Ali \'Imran', 4 => 'An-Nisa\'', 5 => 'Al-Ma\'idah',
            6 => 'Al-An\'am', 7 => 'Al-A\'raf', 8 => 'Al-Anfal', 9 => 'At-Taubah', 10 => 'Yunus',
            11 => 'Hud', 12 => 'Yusuf', 13 => 'Ar-Ra\'d', 14 => 'Ibrahim', 15 => 'Al-Hijr',
            16 => 'An-Nahl', 17 => 'Al-Isra\'', 18 => 'Al-Kahf', 19 => 'Maryam', 20 => 'Ta Ha',
            21 => 'Al-Anbiya\'', 22 => 'Al-Hajj', 23 => 'Al-Mu\'minun', 24 => 'An-Nur', 25 => 'Al-Furqan',
            26 => 'Ash-Shu\'ara\'', 27 => 'An-Naml', 28 => 'Al-Qasas', 29 => 'Al-\'Ankabut', 30 => 'Ar-Rum',
            31 => 'Luqman', 32 => 'As-Sajdah', 33 => 'Al-Ahzab', 34 => 'Saba\'', 35 => 'Fatir',
            36 => 'Ya Sin', 37 => 'As-Saffat', 38 => 'Sad', 39 => 'Az-Zumar', 40 => 'Ghafir',
            41 => 'Fussilat', 42 => 'Ash-Shura', 43 => 'Az-Zukhruf', 44 => 'Ad-Dukhan', 45 => 'Al-Jathiyah',
            46 => 'Al-Ahqaf', 47 => 'Muhammad', 48 => 'Al-Fath', 49 => 'Al-Hujurat', 50 => 'Qaf',
            51 => 'Adh-Dhariyat', 52 => 'At-Tur', 53 => 'An-Najm', 54 => 'Al-Qamar', 55 => 'Ar-Rahman',
            56 => 'Al-Waqi\'ah', 57 => 'Al-Hadid', 58 => 'Al-Mujadilah', 59 => 'Al-Hashr', 60 => 'Al-Mumtahanah',
            61 => 'As-Saff', 62 => 'Al-Jumu\'ah', 63 => 'Al-Munafiqun', 64 => 'At-Taghabun', 65 => 'At-Talaq',
            66 => 'At-Tahrim', 67 => 'Al-Mulk', 68 => 'Al-Qalam', 69 => 'Al-Haqqah', 70 => 'Al-Ma\'arij',
            71 => 'Nuh', 72 => 'Al-Jinn', 73 => 'Al-Muzzammil', 74 => 'Al-Muddatthir', 75 => 'Al-Qiyamah',
            76 => 'Al-Insan', 77 => 'Al-Mursalat', 78 => 'An-Naba\'', 79 => 'An-Nazi\'at', 80 => '\'Abasa',
            81 => 'At-Takwir', 82 => 'Al-Infitar', 83 => 'Al-Mutaffifin', 84 => 'Al-Inshiqaq', 85 => 'Al-Buruj',
            86 => 'At-Tariq', 87 => 'Al-A\'la', 88 => 'Al-Ghashiyah', 89 => 'Al-Fajr', 90 => 'Al-Balad',
            91 => 'Ash-Shams', 92 => 'Al-Lail', 93 => 'Ad-Duha', 94 => 'Ash-Sharh', 95 => 'At-Tin',
            96 => 'Al-\'Alaq', 97 => 'Al-Qadr', 98 => 'Al-Bayyinah', 99 => 'Az-Zalzalah', 100 => 'Al-\'Adiyat',
            101 => 'Al-Qari\'ah', 102 => 'At-Takathur', 103 => 'Al-\'Asr', 104 => 'Al-Humazah', 105 => 'Al-Fil',
            106 => 'Quraish', 107 => 'Al-Ma\'un', 108 => 'Al-Kautsar', 109 => 'Al-Kafirun', 110 => 'An-Nasr',
            111 => 'Al-Lahab', 112 => 'Al-Ikhlas', 113 => 'Al-Falaq', 114 => 'An-Nas'
        ];

        // Juz 30 Surahs only
        $juz30Surahs = array_slice($surahs, 77, 37, true);

        return view('tpq.prestasi', compact('user', 'hakakses', 'santris', 'riwayat', 'masterHafalan', 'surahs', 'juz30Surahs'));
    }

    /**
     * Store a newly created record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tb_santri_id' => 'required|exists:tb_santri,id',
            'tanggal' => 'required|date',
            'tipe' => 'required|in:sorogan,hafalan',
            'materi' => 'required_if:tipe,sorogan|nullable|in:iqro,alquran,juz_amma',
            'iqro_jilid' => 'required_if:materi,iqro|nullable|integer|min:1|max:6',
            'iqro_halaman' => 'required_if:materi,iqro|nullable|integer|min:1',
            'alquran_surah' => 'required_if:materi,alquran|nullable|string',
            'alquran_ayat' => 'required_if:materi,alquran|nullable|string|max:50',
            'juz_amma_surah' => 'required_if:materi,juz_amma|nullable|string',
            'juz_amma_ayat' => 'required_if:materi,juz_amma|nullable|string|max:50',
            'tb_tpq_master_hafalan_id' => 'required_if:tipe,hafalan|nullable|exists:tb_tpq_master_hafalan,id',
            'keterangan' => 'required|in:lanjut,ulang',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $hakakses = $user->hakakses;
        
        $isGuru = $hakakses->nama_hakakses !== 'administrator';
        if ($isGuru) {
            $guru = $user->guru;
            if (!$guru) {
                abort(403, 'Akun Anda belum terhubung dengan data guru TPQ.');
            }
            $kelasIds = Kelas::whereHas('gurus', function ($q) use ($guru) {
                $q->where('tb_guru.id', $guru->id);
            })->pluck('id');
            $santri = Santri::find($request->tb_santri_id);
            if (!$santri || !$kelasIds->contains($santri->tb_kelas_id)) {
                abort(403, 'Anda tidak memiliki wewenang untuk mencatat prestasi santri ini.');
            }
        }

        $guruId = $user->guru?->id ?? null;

        $prestasi = PrestasiSantri::create(array_merge($request->all(), [
            'tb_guru_id' => $guruId,
            'tb_user_id' => $user->id
        ]));

        // WhatsApp notification
        $waStatus = $this->sendWaBroadcast($prestasi);

        return redirect()->route('tpq.prestasi.index')->with('success', 'Data prestasi santri berhasil disimpan.' . $waStatus);
    }

    /**
     * AJAX Endpoint to fetch the last progress and return auto-recommendation.
     */
    public function getLastProgress(Request $request)
    {
        $santriId = $request->query('santri_id');
        $tipe = $request->query('tipe');
        $materi = $request->query('materi');

        if (!$santriId || !$tipe) {
            return response()->json(['success' => false, 'message' => 'Parameters missing']);
        }

        $user = Auth::user();
        $hakakses = $user->hakakses;
        $isGuru = $hakakses->nama_hakakses !== 'administrator';
        if ($isGuru) {
            $guru = $user->guru;
            if (!$guru) {
                return response()->json(['success' => false, 'message' => 'Akun belum terhubung dengan data guru']);
            }
            $kelasIds = Kelas::whereHas('gurus', function ($q) use ($guru) {
                $q->where('tb_guru.id', $guru->id);
            })->pluck('id');
            $santri = Santri::find($santriId);
            if (!$santri || !$kelasIds->contains($santri->tb_kelas_id)) {
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
        }

        $query = PrestasiSantri::where('tb_santri_id', $santriId)->where('tipe', $tipe);
        if ($tipe === 'sorogan') {
            $query->where('materi', $materi);
        }

        $last = $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->first();

        if (!$last) {
            return response()->json(['success' => true, 'data' => null]);
        }

        $recommendation = [];
        $isLanjut = $last->keterangan === 'lanjut';

        if ($tipe === 'sorogan') {
            if ($materi === 'iqro') {
                $recommendation = [
                    'iqro_jilid' => $last->iqro_jilid,
                    'iqro_halaman' => $isLanjut ? $last->iqro_halaman + 1 : $last->iqro_halaman,
                ];
            } elseif ($materi === 'alquran') {
                $recommendation = [
                    'alquran_surah' => $last->alquran_surah,
                    'alquran_ayat' => $isLanjut ? $this->incrementAyat($last->alquran_ayat) : $last->alquran_ayat,
                ];
            } elseif ($materi === 'juz_amma') {
                $recommendation = [
                    'juz_amma_surah' => $last->juz_amma_surah,
                    'juz_amma_ayat' => $isLanjut ? $this->incrementAyat($last->juz_amma_ayat) : $last->juz_amma_ayat,
                ];
            }
        } elseif ($tipe === 'hafalan') {
            $currentHafalanId = $last->tb_tpq_master_hafalan_id;
            if ($isLanjut && $currentHafalanId) {
                $currentHafalan = TpqMasterHafalan::find($currentHafalanId);
                if ($currentHafalan) {
                    // Find next item in the same category
                    $nextHafalan = TpqMasterHafalan::where('kategori', $currentHafalan->kategori)
                        ->where('id', '>', $currentHafalan->id)
                        ->orderBy('id')
                        ->first();
                    $recommendation = [
                        'tb_tpq_master_hafalan_id' => $nextHafalan ? $nextHafalan->id : $currentHafalanId
                    ];
                }
            } else {
                $recommendation = [
                    'tb_tpq_master_hafalan_id' => $currentHafalanId
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'last_record' => $last,
                'recommendation' => $recommendation
            ]
        ]);
    }

    /**
     * Remove the specified record from database.
     */
    public function destroy($id)
    {
        $record = PrestasiSantri::findOrFail($id);
        $record->delete();

        return redirect()->route('tpq.prestasi.index')->with('success', 'Catatan prestasi santri berhasil dihapus.');
    }

    /**
     * Display student history page publicly for parents.
     */
    public function publicShow($token)
    {
        $santri = Santri::with(['kelas.gurus'])->where('prestasi_token', $token)->firstOrFail();

        $sorogan = PrestasiSantri::where('tb_santri_id', $santri->id)
            ->where('tipe', 'sorogan')
            ->with(['guru', 'user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $hafalan = PrestasiSantri::where('tb_santri_id', $santri->id)
            ->where('tipe', 'hafalan')
            ->with(['guru', 'user', 'masterHafalan'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate latest achievement summary
        $latestSorogan = $sorogan->first();
        $achSummary = 'Belum ada catatan';
        if ($latestSorogan) {
            if ($latestSorogan->materi === 'iqro') {
                $achSummary = "Iqro Jilid {$latestSorogan->iqro_jilid} Halaman {$latestSorogan->iqro_halaman}";
            } elseif ($latestSorogan->materi === 'alquran') {
                $achSummary = "Al-Quran Surah {$latestSorogan->alquran_surah} Ayat {$latestSorogan->alquran_ayat}";
            } elseif ($latestSorogan->materi === 'juz_amma') {
                $achSummary = "Juz Amma Surah {$latestSorogan->juz_amma_surah} Ayat {$latestSorogan->juz_amma_ayat}";
            }
        }

        return view('tpq.prestasi_public', compact('santri', 'sorogan', 'hafalan', 'achSummary'));
    }

    /**
     * Helper to increment single ayat number or range (e.g. 1-5 -> 6).
     */
    private function incrementAyat($ayat)
    {
        if (empty($ayat)) return '';
        if (preg_match('/(\d+)\s*-\s*(\d+)/', $ayat, $matches)) {
            return (int)$matches[2] + 1;
        } elseif (is_numeric($ayat)) {
            return (int)$ayat + 1;
        }
        return $ayat;
    }

    /**
     * Helper to send Fonnte WhatsApp message.
     */
    private function sendWaBroadcast(PrestasiSantri $prestasi): string
    {
        $santri = $prestasi->santri;
        $phone = $santri->no_hp_orang_tua;

        if (empty($phone)) {
            return ' (Notifikasi WA tidak terkirim karena nomor HP orang tua kosong).';
        }

        $setting = Setting::first();
        if ($setting && !$setting->whatsapp_status) {
            return ' (Notifikasi WA tidak terkirim karena WhatsApp Gateway dinonaktifkan di pengaturan sistem).';
        }
        $token = ($setting && $setting->fonnte_token) ? $setting->fonnte_token : env('FONNTE_TOKEN');
        if (empty($token)) {
            return ' (Notifikasi WA tidak terkirim karena token Fonnte belum dikonfigurasi).';
        }

        // Auto-generate token if empty
        if (empty($santri->prestasi_token)) {
            $santri->prestasi_token = bin2hex(random_bytes(16));
            $santri->save();
        }

        $linkPrestasi = route('tpq.prestasi.public', ['token' => $santri->prestasi_token]);

        // Translate date
        $formattedTanggalEn = Carbon::parse($prestasi->tanggal)->format('d F Y');
        $monthsId = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April',
            'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus',
            'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];
        $formattedTanggal = strtr($formattedTanggalEn, $monthsId);

        $statusText = strtoupper($prestasi->keterangan);
        $namaPetugas = Auth::user()->name;

        if ($prestasi->tipe === 'sorogan') {
            $templateObj = WaTemplate::firstOrCreate(
                ['key' => 'tpq_prestasi_sorogan'],
                [
                    'template' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Wali Santri dari *{nama_santri}*,\n\nKami menginfokan perkembangan belajar Sorogan Ananda pada hari ini ({tanggal}):\n- Materi: {materi_detail}\n- Keterangan: {keterangan} (Petugas: {nama_petugas})\n\nLihat riwayat perkembangan kartu prestasi Ananda secara lengkap pada tautan berikut:\n{link_prestasi}\n\nTerima kasih atas perhatiannya.\n\n*_Wassalamu'alaikum wr. wb._*"
                ]
            );
            $templateText = $templateObj->template;

            // Compute detail
            $materiDetail = '';
            if ($prestasi->materi === 'iqro') {
                $materiDetail = "Iqro Jilid {$prestasi->iqro_jilid} Halaman {$prestasi->iqro_halaman}";
            } elseif ($prestasi->materi === 'alquran') {
                $materiDetail = "Al-Quran Surah {$prestasi->alquran_surah} Ayat {$prestasi->alquran_ayat}";
            } elseif ($prestasi->materi === 'juz_amma') {
                $materiDetail = "Juz Amma Surah {$prestasi->juz_amma_surah} Ayat {$prestasi->juz_amma_ayat}";
            }

            $message = strtr($templateText, [
                '{nama_santri}' => $santri->nama_santri,
                '{tanggal}' => $formattedTanggal,
                '{materi_detail}' => $materiDetail,
                '{keterangan}' => $statusText,
                '{nama_petugas}' => $namaPetugas,
                '{nama_wali}' => $santri->nama_orang_tua ?? '-',
                '{link_prestasi}' => $linkPrestasi,
            ]);
        } else {
            $templateObj = WaTemplate::firstOrCreate(
                ['key' => 'tpq_prestasi_hafalan'],
                [
                    'template' => "*_Assalamu'alaikum wr. wb._*\n\nYth. Wali Santri dari *{nama_santri}*,\n\nKami menginfokan perkembangan belajar Hafalan Ananda pada hari ini ({tanggal}):\n- Hafalan: {nama_hafalan} ({kategori})\n- Keterangan: {keterangan} (Petugas: {nama_petugas})\n\nLihat riwayat perkembangan kartu prestasi Ananda secara lengkap pada tautan berikut:\n{link_prestasi}\n\nTerima kasih atas perhatiannya.\n\n*_Wassalamu'alaikum wr. wb._*"
                ]
            );
            $templateText = $templateObj->template;

            $hafalanName = $prestasi->masterHafalan?->nama ?? '-';
            $hafalanKat = $prestasi->masterHafalan && $prestasi->masterHafalan->kategori === 'surah_pendek' ? 'Surah Pendek' : 'Doa Harian';

            $message = strtr($templateText, [
                '{nama_santri}' => $santri->nama_santri,
                '{tanggal}' => $formattedTanggal,
                '{nama_hafalan}' => $hafalanName,
                '{kategori}' => $hafalanKat,
                '{keterangan}' => $statusText,
                '{nama_petugas}' => $namaPetugas,
                '{nama_wali}' => $santri->nama_orang_tua ?? '-',
                '{link_prestasi}' => $linkPrestasi,
            ]);
        }

        // Normalize phone number
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
                return ' (Pesan WA notifikasi terkirim ke wali murid).';
            } else {
                $err = $resData['reason'] ?? $response->body();
                return ' (Gagal kirim WA via Fonnte: ' . $err . ').';
            }
        } catch (\Exception $e) {
            return ' (Gagal menghubungkan ke Fonnte: ' . $e->getMessage() . ').';
        }
    }
}
