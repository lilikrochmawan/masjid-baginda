<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\AbsensiSantri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TpqController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('tpq')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul TPQ.');
            }

            $route = $request->route()->getName();
            if ($route) {
                if (str_starts_with($route, 'tpq.guru') && !$user->hasAccess('tpq.guru')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Data Guru.');
                }
                if (str_starts_with($route, 'tpq.kelas') && !$user->hasAccess('tpq.kelas')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Data Kelas.');
                }
                if (str_starts_with($route, 'tpq.santri') && !$user->hasAccess('tpq.santri')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Data Santri.');
                }
                if (str_starts_with($route, 'tpq.absensi') && !$user->hasAccess('tpq.absensi')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Absensi Santri.');
                }
                if (str_starts_with($route, 'tpq.laporan') && !$user->hasAccess('tpq.laporan')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Laporan Absensi.');
                }
            }

            return $next($request);
        });
    }

    /**
     * TPQ landing dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalSantri = Santri::count();

        // Kehadiran hari ini
        $today = Carbon::today()->toDateString();
        $totalAbsenToday = AbsensiSantri::whereDate('tanggal', $today)->count();
        $totalHadirToday = AbsensiSantri::whereDate('tanggal', $today)->where('status', 'H')->count();

        $persentaseHadir = $totalSantri > 0 ? round(($totalHadirToday / $totalSantri) * 100) : 0;

        return view('tpq.dashboard', compact(
            'user',
            'hakakses',
            'totalGuru',
            'totalKelas',
            'totalSantri',
            'totalAbsenToday',
            'totalHadirToday',
            'persentaseHadir'
        ));
    }

    /**
     * Data Guru CRUD.
     */
    public function guruIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $gurus = Guru::with('user')->get();
        // Ambil user dengan hakakses tpq dan guru tpq untuk ditautkan ke guru
        $users = User::whereHas('hakakses', function ($query) {
            $query->whereIn('nama_hakakses', ['tpq', 'guru tpq']);
        })->get();

        return view('tpq.guru', compact('user', 'hakakses', 'gurus', 'users'));
    }

    public function guruStore(Request $request)
    {
        $validated = $request->validate([
            'tb_user_id' => 'nullable|unique:tb_guru,tb_user_id',
            'nip' => 'nullable|unique:tb_guru,nip',
            'nama_guru' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Guru::create($validated);

        return redirect()->route('tpq.guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'tb_user_id' => 'nullable|unique:tb_guru,tb_user_id,' . $guru->id,
            'nip' => 'nullable|unique:tb_guru,nip,' . $guru->id,
            'nama_guru' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $guru->update($validated);

        return redirect()->route('tpq.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function guruDestroy($id)
    {
        $guru = Guru::findOrFail($id);
        
        // Lepaskan referensi guru di kelas sebelum menghapus
        Kelas::where('tb_guru_id', $guru->id)->update(['tb_guru_id' => null]);
        
        $guru->delete();

        return redirect()->route('tpq.guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Data Kelas CRUD.
     */
    public function kelasIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $kelas = Kelas::with('guru')->get();
        $gurus = Guru::all();

        return view('tpq.kelas', compact('user', 'hakakses', 'kelas', 'gurus'));
    }

    public function kelasStore(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tb_guru_id' => 'nullable|exists:tb_guru,id',
        ]);

        Kelas::create($validated);

        return redirect()->route('tpq.kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tb_guru_id' => 'nullable|exists:tb_guru,id',
        ]);

        $kelas->update($validated);

        return redirect()->route('tpq.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // Pindahkan santri ke tanpa kelas sebelum menghapus kelas
        Santri::where('tb_kelas_id', $kelas->id)->update(['tb_kelas_id' => null]);
        
        $kelas->delete();

        return redirect()->route('tpq.kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    /**
     * Data Santri CRUD.
     */
    public function santriIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $query = Santri::with('kelas');

        $selectedKelasId = $request->input('kelas_id');
        if ($selectedKelasId !== null && $selectedKelasId !== '') {
            if ($selectedKelasId === 'none') {
                $query->whereNull('tb_kelas_id');
            } else {
                $query->where('tb_kelas_id', $selectedKelasId);
            }
        }

        $santris = $query->get();
        $kelas = Kelas::all();

        // Auto-generate NIS (e.g. 0001, 0002)
        $lastNis = Santri::whereNotNull('nis')
            ->get()
            ->filter(function ($item) {
                return is_numeric($item->nis);
            })
            ->map(function ($item) {
                return intval($item->nis);
            })
            ->max();

        $nextNisNum = $lastNis ? $lastNis + 1 : 1;
        $nextNis = str_pad($nextNisNum, 4, '0', STR_PAD_LEFT);

        return view('tpq.santri', compact('user', 'hakakses', 'santris', 'kelas', 'nextNis', 'selectedKelasId'));
    }

    public function santriStore(Request $request)
    {
        $validated = $request->validate([
            'tb_kelas_id' => 'nullable|exists:tb_kelas,id',
            'nis' => 'nullable|unique:tb_santri,nis',
            'nama_santri' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'no_hp_orang_tua' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:1000',
        ]);

        // Auto-generate NIS if empty
        if (empty($validated['nis'])) {
            $lastNis = Santri::whereNotNull('nis')
                ->get()
                ->filter(function ($item) {
                    return is_numeric($item->nis);
                })
                ->map(function ($item) {
                    return intval($item->nis);
                })
                ->max();

            $nextNisNum = $lastNis ? $lastNis + 1 : 1;
            $validated['nis'] = str_pad($nextNisNum, 4, '0', STR_PAD_LEFT);
        }

        Santri::create($validated);

        return redirect()->route('tpq.santri.index')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function santriUpdate(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $validated = $request->validate([
            'tb_kelas_id' => 'nullable|exists:tb_kelas,id',
            'nis' => 'nullable|unique:tb_santri,nis,' . $santri->id,
            'nama_santri' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'no_hp_orang_tua' => 'nullable|string|max:20',
            'alamat_rumah' => 'nullable|string|max:1000',
        ]);

        $santri->update($validated);

        return redirect()->route('tpq.santri.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function santriDestroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();

        return redirect()->route('tpq.santri.index')->with('success', 'Data santri berhasil dihapus.');
    }

    /**
     * Absensi Santri.
     */
    public function absensiIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $tanggal = $request->query('tanggal', Carbon::today()->toDateString());
        $kelasId = $request->query('tb_kelas_id');

        // Batasi kelas jika user yang login terikat sebagai guru pengampu
        $isGuru = $hakakses->nama_hakakses !== 'administrator' && $user->guru;
        
        if ($isGuru) {
            $classes = Kelas::where('tb_guru_id', $user->guru->id)->get();
        } else {
            $classes = Kelas::all();
        }

        $selectedClassId = $kelasId ?: ($classes->first()?->id ?? null);
        
        // Validasi jika guru mencoba mengakses kelas lain
        if ($isGuru && $selectedClassId && !$classes->contains('id', $selectedClassId)) {
            abort(403, 'Anda tidak diijinkan mengabsen kelas ini.');
        }

        $santris = collect();
        $existingAbsensi = collect();

        if ($selectedClassId) {
            $santris = Santri::where('tb_kelas_id', $selectedClassId)->orderBy('nama_santri')->get();
            $existingAbsensi = AbsensiSantri::where('tb_kelas_id', $selectedClassId)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy('tb_santri_id');
        }

        return view('tpq.absensi', compact(
            'user',
            'hakakses',
            'classes',
            'selectedClassId',
            'tanggal',
            'santris',
            'existingAbsensi'
        ));
    }

    public function absensiStore(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $request->validate([
            'tb_kelas_id' => 'required|exists:tb_kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*' => 'required|in:H,S,I,A',
            'keterangan' => 'nullable|array',
        ]);

        $kelasId = $request->tb_kelas_id;
        $tanggal = $request->tanggal;
        $absensiData = $request->absensi;
        $keteranganData = $request->keterangan ?? [];

        // Validasi kepemilikan kelas oleh guru
        $isGuru = $hakakses->nama_hakakses !== 'administrator' && $user->guru;
        if ($isGuru) {
            $kelas = Kelas::where('id', $kelasId)->where('tb_guru_id', $user->guru->id)->first();
            if (!$kelas) {
                abort(403, 'Anda tidak berwenang mengabsen kelas ini.');
            }
        }

        $guruId = $user->guru?->id ?? null;

        foreach ($absensiData as $santriId => $status) {
            AbsensiSantri::updateOrCreate(
                [
                    'tb_santri_id' => $santriId,
                    'tanggal' => $tanggal
                ],
                [
                    'tb_kelas_id' => $kelasId,
                    'tb_guru_id' => $guruId,
                    'status' => $status,
                    'keterangan' => $keteranganData[$santriId] ?? null
                ]
            );
        }

        return redirect()->route('tpq.absensi.index', [
            'tb_kelas_id' => $kelasId,
            'tanggal' => $tanggal
        ])->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Laporan Absensi.
     */
    public function laporanIndex(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $periode = $request->query('periode', 'weekly'); // weekly, monthly, yearly
        $kelasId = $request->query('tb_kelas_id');
        $selectedDate = Carbon::parse($request->query('tanggal', Carbon::today()->toDateString()));

        $classes = Kelas::all();
        $selectedClassId = $kelasId ?: ($classes->first()?->id ?? null);

        $santris = collect();
        $dates = [];
        $matrix = [];
        $months = [];

        if ($selectedClassId) {
            $santris = Santri::where('tb_kelas_id', $selectedClassId)->orderBy('nama_santri')->get();

            if ($periode === 'weekly') {
                // Ambil Senin - Minggu dari minggu terpilih
                $startOfWeek = $selectedDate->copy()->startOfWeek();
                for ($i = 0; $i < 7; $i++) {
                    $dates[] = $startOfWeek->copy()->addDays($i)->toDateString();
                }

                // Ambil data absensi dalam range
                $absensi = AbsensiSantri::where('tb_kelas_id', $selectedClassId)
                    ->whereBetween('tanggal', [$dates[0], $dates[6]])
                    ->get()
                    ->groupBy('tb_santri_id');

                foreach ($santris as $santri) {
                    $studentAbsen = $absensi->get($santri->id, collect())->keyBy('tanggal');
                    $row = [];
                    $hadir = 0;
                    $total = 0;

                    foreach ($dates as $date) {
                        $absenRecord = $studentAbsen->get($date);
                        $status = $absenRecord ? $absenRecord->status : '-';
                        $row[$date] = $status;
                        
                        if ($status === 'H') {
                            $hadir++;
                        }
                        if ($status !== '-') {
                            $total++;
                        }
                    }

                    $matrix[$santri->id] = [
                        'santri' => $santri,
                        'attendance' => $row,
                        'summary' => $total > 0 ? round(($hadir / $total) * 100) . '%' : '0%'
                    ];
                }

            } elseif ($periode === 'monthly') {
                // Hari dalam sebulan
                $daysInMonth = $selectedDate->daysInMonth;
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $dates[] = $selectedDate->copy()->day($d)->toDateString();
                }

                $absensi = AbsensiSantri::where('tb_kelas_id', $selectedClassId)
                    ->whereYear('tanggal', $selectedDate->year)
                    ->whereMonth('tanggal', $selectedDate->month)
                    ->get()
                    ->groupBy('tb_santri_id');

                foreach ($santris as $santri) {
                    $studentAbsen = $absensi->get($santri->id, collect())->keyBy('tanggal');
                    $row = [];
                    $hadir = 0;
                    $total = 0;

                    foreach ($dates as $date) {
                        $absenRecord = $studentAbsen->get($date);
                        $status = $absenRecord ? $absenRecord->status : '-';
                        $row[$date] = $status;

                        if ($status === 'H') {
                            $hadir++;
                        }
                        if ($status !== '-') {
                            $total++;
                        }
                    }

                    $matrix[$santri->id] = [
                        'santri' => $santri,
                        'attendance' => $row,
                        'summary' => $total > 0 ? round(($hadir / $total) * 100) . '%' : '0%'
                    ];
                }

            } elseif ($periode === 'yearly') {
                // Berdasarkan 12 bulan dalam tahun terpilih
                $year = $selectedDate->year;
                
                for ($m = 1; $m <= 12; $m++) {
                    $months[$m] = Carbon::create($year, $m, 1)->format('F');
                }

                $absensi = AbsensiSantri::where('tb_kelas_id', $selectedClassId)
                    ->whereYear('tanggal', $year)
                    ->get()
                    ->groupBy('tb_santri_id');

                foreach ($santris as $santri) {
                    $studentAbsen = $absensi->get($santri->id, collect());
                    $row = [];
                    $totalHadirYear = 0;
                    $totalDayYear = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $monthAbsen = $studentAbsen->filter(function($item) use ($m) {
                            return Carbon::parse($item->tanggal)->month === $m;
                        });

                        $hadir = $monthAbsen->where('status', 'H')->count();
                        $total = $monthAbsen->count();

                        $row[$m] = $total > 0 ? round(($hadir / $total) * 100) . '%' : '-';
                        $totalHadirYear += $hadir;
                        $totalDayYear += $total;
                    }

                    $matrix[$santri->id] = [
                        'santri' => $santri,
                        'attendance' => $row,
                        'summary' => $totalDayYear > 0 ? round(($totalHadirYear / $totalDayYear) * 100) . '%' : '0%'
                    ];
                }
            }
        }

        return view('tpq.laporan', compact(
            'user',
            'hakakses',
            'classes',
            'selectedClassId',
            'periode',
            'selectedDate',
            'dates',
            'months',
            'matrix'
        ));
    }
}
