<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\JenisBarang;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Surat;
use App\Models\RencanaKerja;
use App\Models\SuratBuat;
use App\Models\SuratTemplate;
use App\Models\EDokumen;
use App\Models\TakmirBroadcast;
use App\Models\TakmirBroadcastTemplate;
use App\Models\Setting;
use App\Models\WhatsappGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class OperasionalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('operasional')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul Data Operasional.');
            }

            $route = $request->route()->getName();
            if ($route) {
                if (str_starts_with($route, 'operasional.struktur') && !$user->hasAccess('operasional.struktur')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Struktur Organisasi.');
                }
                if ((str_starts_with($route, 'operasional.inventaris') || str_starts_with($route, 'operasional.jenis') || str_starts_with($route, 'operasional.barang')) && !$user->hasAccess('operasional.inventaris')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Inventarisasi Barang.');
                }
                if ((str_starts_with($route, 'operasional.surat') || str_starts_with($route, 'operasional.broadcast')) && !$user->hasAccess('operasional.surat')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Persuratan.');
                }
                if (str_starts_with($route, 'operasional.rencana') && !$user->hasAccess('operasional.rencana')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Rencana Kerja Seksi.');
                }
            }

            return $next($request);
        });
    }

    /**
     * Dashboard Data Operasional.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $totalTakmir = Takmir::count();
        $aktifTakmir = Takmir::where('status', 'aktif')->count();

        $totalJenis = JenisBarang::count();
        $totalBarang = Barang::count();
        $totalInventaris = Inventaris::count();
        $kondisiBaik = Inventaris::where('kondisi', 'baik')->count();
        $kondisiRusak = Inventaris::whereIn('kondisi', ['rusak_ringan', 'rusak_berat'])->count();

        $totalSurat = Surat::count();
        $suratMasuk = Surat::where('tipe', 'masuk')->count();
        $suratKeluar = Surat::where('tipe', 'keluar')->count();
        $proposal = Surat::where('tipe', 'proposal')->count();

        $totalRencana = RencanaKerja::count();
        $rencanaJalan = RencanaKerja::where('status', 'sedang_berjalan')->count();
        $rencanaSelesai = RencanaKerja::where('status', 'selesai')->count();

        return view('operasional.dashboard', compact(
            'user', 'hakakses', 'totalTakmir', 'aktifTakmir',
            'totalJenis', 'totalBarang', 'totalInventaris', 'kondisiBaik', 'kondisiRusak',
            'totalSurat', 'suratMasuk', 'suratKeluar', 'proposal',
            'totalRencana', 'rencanaJalan', 'rencanaSelesai'
        ));
    }

    /* ── Submodul 1: Struktur Organisasi Takmir ── */

    public function strukturIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $takmirs = Takmir::with(['parent', 'user'])->get();
        $parentOptions = Takmir::where('status', 'aktif')->get();
        $users = \App\Models\User::orderBy('name')->get();

        return view('operasional.struktur', compact('user', 'hakakses', 'takmirs', 'parentOptions', 'users'));
    }

    public function strukturStore(Request $request)
    {
        $request->validate([
            'tb_user_id' => 'nullable|exists:tb_user,id',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:tb_takmir,id',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,non_aktif',
        ]);

        Takmir::create($request->all());

        return redirect()->route('operasional.struktur.index')->with('success', 'Anggota takmir berhasil ditambahkan.');
    }

    public function strukturUpdate(Request $request, $id)
    {
        $request->validate([
            'tb_user_id' => 'nullable|exists:tb_user,id',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:tb_takmir,id',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,non_aktif',
        ]);

        $takmir = Takmir::findOrFail($id);
        $takmir->update($request->all());

        return redirect()->route('operasional.struktur.index')->with('success', 'Data takmir berhasil diubah.');
    }

    public function strukturDestroy($id)
    {
        $takmir = Takmir::findOrFail($id);
        $takmir->delete();

        return redirect()->route('operasional.struktur.index')->with('success', 'Anggota takmir berhasil dihapus.');
    }

    /* ── Submodul 2: Inventarisasi Barang ── */

    public function inventarisIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $jenisBarangs = JenisBarang::all();
        $barangs = Barang::with('jenis')->get();
        $inventaris = Inventaris::with('barang.jenis')->get();

        return view('operasional.inventaris', compact('user', 'hakakses', 'jenisBarangs', 'barangs', 'inventaris'));
    }

    // Jenis Barang CRUD
    public function jenisStore(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JenisBarang::create($request->all());

        return redirect()->route('operasional.inventaris.index', ['tab' => 'jenis'])->with('success', 'Jenis barang berhasil ditambahkan.');
    }

    public function jenisUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jenis = JenisBarang::findOrFail($id);
        $jenis->update($request->all());

        return redirect()->route('operasional.inventaris.index', ['tab' => 'jenis'])->with('success', 'Jenis barang berhasil diubah.');
    }

    public function jenisDestroy($id)
    {
        $jenis = JenisBarang::findOrFail($id);
        $jenis->delete();

        return redirect()->route('operasional.inventaris.index', ['tab' => 'jenis'])->with('success', 'Jenis barang berhasil dihapus.');
    }

    // Barang CRUD
    public function barangStore(Request $request)
    {
        $request->validate([
            'tb_jenis_barang_id' => 'required|exists:tb_jenis_barang,id',
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        Barang::create($request->all());

        return redirect()->route('operasional.inventaris.index', ['tab' => 'barang'])->with('success', 'Master barang berhasil ditambahkan.');
    }

    public function barangUpdate(Request $request, $id)
    {
        $request->validate([
            'tb_jenis_barang_id' => 'required|exists:tb_jenis_barang,id',
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('operasional.inventaris.index', ['tab' => 'barang'])->with('success', 'Master barang berhasil diubah.');
    }

    public function barangDestroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('operasional.inventaris.index', ['tab' => 'barang'])->with('success', 'Master barang berhasil dihapus.');
    }

    // Unit Inventaris CRUD
    public function inventarisStore(Request $request)
    {
        $request->validate([
            'tb_barang_id' => 'required|exists:tb_barang,id',
            'tanggal_perolehan' => 'required|date',
            'asal_usul' => 'required|string|max:100',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'lokasi' => 'required|string|max:255',
            'harga_perolehan' => 'nullable|numeric|min:0',
        ]);

        $barang = Barang::with('jenis')->findOrFail($request->tb_barang_id);
        $shortJenis = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $barang->jenis->nama_jenis), 0, 3));
        if (empty($shortJenis)) {
            $shortJenis = 'INV';
        }
        
        $nextNum = Inventaris::where('tb_barang_id', $barang->id)->count() + 1;
        $kode = 'INV-' . $shortJenis . '-' . str_pad($barang->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['kode_inventaris'] = $kode;

        Inventaris::create($data);

        return redirect()->route('operasional.inventaris.index', ['tab' => 'inventaris'])->with('success', 'Unit inventaris berhasil ditambahkan.');
    }

    public function inventarisUpdate(Request $request, $id)
    {
        $request->validate([
            'tb_barang_id' => 'required|exists:tb_barang,id',
            'tanggal_perolehan' => 'required|date',
            'asal_usul' => 'required|string|max:100',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'lokasi' => 'required|string|max:255',
            'harga_perolehan' => 'nullable|numeric|min:0',
        ]);

        $inventaris = Inventaris::findOrFail($id);
        
        // If barang_id changes, regenerate code
        $data = $request->all();
        if ($inventaris->tb_barang_id != $request->tb_barang_id) {
            $barang = Barang::with('jenis')->findOrFail($request->tb_barang_id);
            $shortJenis = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $barang->jenis->nama_jenis), 0, 3));
            if (empty($shortJenis)) {
                $shortJenis = 'INV';
            }
            $nextNum = Inventaris::where('tb_barang_id', $barang->id)->count() + 1;
            $kode = 'INV-' . $shortJenis . '-' . str_pad($barang->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            $data['kode_inventaris'] = $kode;
        }

        $inventaris->update($data);

        return redirect()->route('operasional.inventaris.index', ['tab' => 'inventaris'])->with('success', 'Unit inventaris berhasil diubah.');
    }

    public function inventarisDestroy($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('operasional.inventaris.index', ['tab' => 'inventaris'])->with('success', 'Unit inventaris berhasil dihapus.');
    }

    /* ── Submodul 3: Administrasi Persuratan & Proposal ── */

    public function suratIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $surats = Surat::orderBy('tanggal_surat', 'desc')->get();
        $suratBuats = SuratBuat::with('creator')->orderBy('created_at', 'desc')->get();

        // Auto number generator for new letters
        $currentYear = date('Y');
        $countThisYear = SuratBuat::whereYear('tanggal_surat', $currentYear)->count();
        $nextNum = str_pad($countThisYear + 1, 3, '0', STR_PAD_LEFT);
        $monthsRoman = [
            1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI',
            7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'
        ];
        $currentMonthRoman = $monthsRoman[(int)date('n')];
        $autoNomorSurat = "{$nextNum}/TKM-MB/{$currentMonthRoman}/{$currentYear}";

        $userTakmir = $user->takmir;

        // Fetch names from Takmir structure dynamically
        $sekretarisNama = Takmir::where('jabatan', 'like', '%sekretaris%')->where('status', 'aktif')->value('nama') ?? 'Amel';
        $ketuaNama = Takmir::where('jabatan', 'like', '%ketua%')->where('jabatan', 'not like', '%wakil%')->where('status', 'aktif')->value('nama') ?? 'Ahmad Khoirudin';
        $penasehatNama = Takmir::where('jabatan', 'like', '%penasehat%')->where('status', 'aktif')->value('nama') ?? 'H. Daryanto';

        // Fetch templates and e-dokumens
        $templates = SuratTemplate::orderBy('nama_template')->get();
        $edokumens = EDokumen::with('user')->orderBy('created_at', 'desc')->get();

        return view('operasional.surat', compact(
            'user', 'hakakses', 'surats', 'suratBuats', 'autoNomorSurat', 'userTakmir',
            'sekretarisNama', 'ketuaNama', 'penasehatNama', 'templates', 'edokumens'
        ));
    }

    public function suratStore(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar,proposal',
            'nomor_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'nullable|date',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'status_proposal' => 'nullable|required_if:tipe,proposal|in:pending,disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except('file_dokumen');

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $path = $file->store('dokumen_operasional', 'public');
            $data['file_path'] = $path;
        }

        if ($request->tipe !== 'proposal') {
            $data['status_proposal'] = null;
        }

        Surat::create($data);

        return redirect()->route('operasional.surat.index')->with('success', 'Surat/proposal berhasil dicatat.');
    }

    public function suratUpdate(Request $request, $id)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar,proposal',
            'nomor_surat' => 'required|string|max:100',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'nullable|date',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'status_proposal' => 'nullable|required_if:tipe,proposal|in:pending,disetujui,ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $surat = Surat::findOrFail($id);
        $data = $request->except('file_dokumen');

        if ($request->hasFile('file_dokumen')) {
            // Delete old file
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            $file = $request->file('file_dokumen');
            $path = $file->store('dokumen_operasional', 'public');
            $data['file_path'] = $path;
        }

        if ($request->tipe !== 'proposal') {
            $data['status_proposal'] = null;
        }

        $surat->update($data);

        return redirect()->route('operasional.surat.index')->with('success', 'Surat/proposal berhasil diubah.');
    }

    public function suratDestroy($id)
    {
        $surat = Surat::findOrFail($id);
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }
        $surat->delete();

        return redirect()->route('operasional.surat.index')->with('success', 'Surat/proposal berhasil dihapus.');
    }

    /* ── Submodul 4: Rencana Kerja Seksi ── */

    public function rencanaIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $rencanas = RencanaKerja::with('penanggungJawab')->orderBy('target_selesai', 'asc')->get();
        $takmirs = Takmir::where('status', 'aktif')->get();
        $userTakmir = $user->takmir;

        return view('operasional.rencana', compact('user', 'hakakses', 'rencanas', 'takmirs', 'userTakmir'));
    }

    public function rencanaStore(Request $request)
    {
        $request->validate([
            'tb_takmir_id' => 'required|exists:tb_takmir,id',
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'anggaran' => 'required|numeric|min:0',
            'target_selesai' => 'required|date',
            'status' => 'required|in:belum_mulai,sedang_berjalan,selesai,dibatalkan',
        ]);

        RencanaKerja::create($request->all());

        return redirect()->route('operasional.rencana.index')->with('success', 'Rencana kerja berhasil ditambahkan.');
    }

    public function rencanaUpdate(Request $request, $id)
    {
        $request->validate([
            'tb_takmir_id' => 'required|exists:tb_takmir,id',
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'anggaran' => 'required|numeric|min:0',
            'target_selesai' => 'required|date',
            'status' => 'required|in:belum_mulai,sedang_berjalan,selesai,dibatalkan',
        ]);

        $rencana = RencanaKerja::findOrFail($id);
        $rencana->update($request->all());

        return redirect()->route('operasional.rencana.index')->with('success', 'Rencana kerja berhasil diubah.');
    }

    public function rencanaDestroy($id)
    {
        $rencana = RencanaKerja::findOrFail($id);
        $rencana->delete();

        return redirect()->route('operasional.rencana.index')->with('success', 'Rencana kerja berhasil dihapus.');
    }

    /* ── Submodul 3b: Pembuatan Surat Resmi ── */

    public function suratBuatStore(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'template_key' => 'required|string',
            'header_title' => 'required|string|max:255',
            'header_subtitle' => 'nullable|string',
            'tujuan_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'nama_sekretaris' => 'nullable|string',
            'nama_ketua' => 'nullable|string',
            'nama_penasehat' => 'nullable|string',
            'is_draft' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        SuratBuat::create($data);

        return redirect()->route('operasional.surat.index', ['tab' => 'buat-surat'])->with('success', 'Surat resmi berhasil dibuat.');
    }

    public function suratBuatUpdate(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'perihal' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'template_key' => 'required|string',
            'header_title' => 'required|string|max:255',
            'header_subtitle' => 'nullable|string',
            'tujuan_surat' => 'nullable|string',
            'isi_surat' => 'nullable|string',
            'nama_sekretaris' => 'nullable|string',
            'nama_ketua' => 'nullable|string',
            'nama_penasehat' => 'nullable|string',
            'is_draft' => 'nullable|boolean',
        ]);

        $surat = SuratBuat::findOrFail($id);
        $surat->update($request->all());

        return redirect()->route('operasional.surat.index', ['tab' => 'buat-surat'])->with('success', 'Surat resmi berhasil diperbarui.');
    }

    public function suratBuatDestroy($id)
    {
        $surat = SuratBuat::findOrFail($id);
        $surat->delete();

        return redirect()->route('operasional.surat.index', ['tab' => 'buat-surat'])->with('success', 'Surat resmi berhasil dihapus.');
    }

    public function suratBuatSign(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:sekretaris,ketua,penasehat',
            'nama_penandatangan' => 'required|string|max:255',
        ]);

        $surat = SuratBuat::findOrFail($id);
        $role = $request->role;

        // Enforce role-based signing auth on the backend
        $user = Auth::user();
        $takmir = $user->takmir;
        
        if (!$takmir) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak terhubung dengan jabatan pengurus Takmir mana pun.'
            ], 403);
        }
        
        $jabatan = strtolower($takmir->jabatan);
        $hasPermission = false;
        
        if ($role === 'sekretaris' && str_contains($jabatan, 'sekretaris')) {
            $hasPermission = true;
        } elseif ($role === 'ketua' && str_contains($jabatan, 'ketua')) {
            $hasPermission = true;
        } elseif ($role === 'penasehat' && (str_contains($jabatan, 'penasehat') || str_contains($jabatan, 'penasihat'))) {
            $hasPermission = true;
        }
        
        if (!$hasPermission) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki wewenang untuk menandatangani sebagai ' . ucfirst($role) . '.'
            ], 403);
        }
        
        $verifyUrl = route('tte.verify', ['id' => $id, 'role' => $role]);
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($verifyUrl);
        
        if ($role === 'sekretaris') {
            $surat->status_sekretaris = 'signed';
            $surat->ttd_sekretaris = $qrCodeUrl;
            $surat->nama_sekretaris = $request->nama_penandatangan;
        } elseif ($role === 'ketua') {
            $surat->status_ketua = 'signed';
            $surat->ttd_ketua = $qrCodeUrl;
            $surat->nama_ketua = $request->nama_penandatangan;
        } elseif ($role === 'penasehat') {
            $surat->status_penasehat = 'signed';
            $surat->ttd_penasehat = $qrCodeUrl;
            $surat->nama_penasehat = $request->nama_penandatangan;
        }
        
        $surat->save();

        return response()->json([
            'success' => true, 
            'message' => 'Tanda tangan elektronik (QR Code) berhasil disematkan.',
            'qr_code_url' => $qrCodeUrl
        ]);
    }

    public function tteVerify(Request $request, $id)
    {
        $surat = SuratBuat::findOrFail($id);
        $role = $request->query('role');
        
        $signerName = '-';
        $signerRole = '-';
        $tanggalSign = $surat->updated_at->format('d M Y');
        
        if ($role === 'sekretaris') {
            $signerName = $surat->nama_sekretaris;
            $signerRole = 'Sekretaris';
        } elseif ($role === 'ketua') {
            $signerName = $surat->nama_ketua;
            $signerRole = 'Ketua Takmir';
        } elseif ($role === 'penasehat') {
            $signerName = $surat->nama_penasehat;
            $signerRole = 'Penasehat Takmir';
        }
        
        return view('operasional.tte_verify', compact('surat', 'role', 'signerName', 'signerRole', 'tanggalSign'));
    }

    public function suratBuatPrint($id)
    {
        $surat = SuratBuat::findOrFail($id);
        return view('operasional.surat_print', compact('surat'));
    }

    /* ── Submodul 5: Broadcast Pengumuman Takmir ── */

    public function broadcastIndex()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $broadcasts = TakmirBroadcast::with('creator')->orderBy('created_at', 'desc')->get();
        $templates = TakmirBroadcastTemplate::orderBy('nama_template')->get();
        $takmirs = Takmir::where('status', 'aktif')->get();
        $whatsappGroups = WhatsappGroup::orderBy('group_name')->get();

        return view('operasional.broadcast', compact('user', 'hakakses', 'broadcasts', 'templates', 'takmirs', 'whatsappGroups'));
    }

    public function broadcastStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengumuman' => 'required|string',
            'target_type' => 'required|in:semua_takmir,grup_wa,custom',
            'target_detail' => 'nullable|string',
        ]);

        $setting = Setting::first();
        if ($setting && !$setting->whatsapp_status) {
            return redirect()->route('operasional.broadcast.index')->with('error', 'Fitur WhatsApp Gateway sedang dinonaktifkan di Pengaturan Sistem.');
        }
        $token = ($setting && $setting->fonnte_token) ? $setting->fonnte_token : env('FONNTE_TOKEN');
        
        if (empty($token)) {
            return redirect()->route('operasional.broadcast.index')->with('error', 'Token Fonnte belum dikonfigurasi di Pengaturan Sistem.');
        }

        $isi = $request->isi_pengumuman;
        $targetType = $request->target_type;
        $targets = [];

        if ($targetType === 'semua_takmir') {
            $targets = Takmir::where('status', 'aktif')->whereNotNull('no_hp')->pluck('no_hp')->toArray();
        } elseif ($targetType === 'grup_wa') {
            $targets = [$request->target_detail]; // Group ID
        } elseif ($targetType === 'custom') {
            // Split by comma or newline
            $raw = preg_split('/[\s,]+/', $request->target_detail);
            $targets = array_filter(array_map('trim', $raw));
        }

        if (empty($targets)) {
            return redirect()->route('operasional.broadcast.index')->with('error', 'Tidak ada nomor target pengiriman.');
        }

        // Clean & normalize phone numbers if not group_wa
        $normalizedTargets = [];
        if ($targetType === 'grup_wa') {
            $normalizedTargets = $targets; // Keep group ID exactly as-is!
        } else {
            foreach ($targets as $t) {
                $num = preg_replace('/[^0-9]/', '', $t);
                if (empty($num)) continue;
                if (str_starts_with($num, '0')) {
                    $num = '62' . substr($num, 1);
                }
                $normalizedTargets[] = $num;
            }
        }

        $totalSent = 0;

        // Send to each target
        foreach ($normalizedTargets as $phone) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $token
                ])->asForm()->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $isi,
                ]);

                $resData = $response->json();
                if ($response->successful() && isset($resData['status']) && $resData['status'] == true) {
                    $totalSent++;
                }
            } catch (\Exception $e) {
                // Keep trying other numbers
            }
        }

        TakmirBroadcast::create([
            'judul' => $request->judul,
            'isi_pengumuman' => $isi,
            'target_type' => $targetType,
            'target_detail' => $request->target_detail,
            'status' => $totalSent > 0 ? 'success' : 'failed',
            'total_sent' => $totalSent,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('operasional.broadcast.index')->with('success', "Pengumuman berhasil diproses. Berhasil mengirim ke {$totalSent} nomor.");
    }

    public function broadcastTemplateStore(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'isi_template' => 'required|string',
        ]);

        TakmirBroadcastTemplate::create($request->all());

        return redirect()->route('operasional.broadcast.index', ['tab' => 'templates'])->with('success', 'Template pengumuman berhasil disimpan.');
    }

    public function broadcastTemplateUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'isi_template' => 'required|string',
        ]);

        $template = TakmirBroadcastTemplate::findOrFail($id);
        $template->update($request->all());

        return redirect()->route('operasional.broadcast.index', ['tab' => 'templates'])->with('success', 'Template pengumuman berhasil diperbarui.');
    }

    public function broadcastTemplateDestroy($id)
    {
        $template = TakmirBroadcastTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('operasional.broadcast.index', ['tab' => 'templates'])->with('success', 'Template pengumuman berhasil dihapus.');
    }

    public function suratTemplateStore(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'konten' => 'required|string',
            'header_title' => 'nullable|string|max:255',
            'header_subtitle' => 'nullable|string',
        ]);

        $template = SuratTemplate::create([
            'nama_template' => $request->nama_template,
            'konten' => $request->konten,
            'header_title' => $request->header_title,
            'header_subtitle' => $request->header_subtitle,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Template surat berhasil disimpan.',
            'template' => $template
        ]);
    }

    public function edokumenStore(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png,mp4,mov,avi|max:20480', // 20 MB max
        ]);

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $extension = strtolower($file->getClientOriginalExtension());
            
            // Determine file type category
            $fileType = 'file';
            if (in_array($extension, ['pdf'])) {
                $fileType = 'pdf';
            } elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $fileType = 'image';
            } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                $fileType = 'video';
            }

            // Save file
            $path = $file->store('edokumen', 'public');
            
            // Format size
            $bytes = $file->getSize();
            if ($bytes >= 1048576) {
                $fileSize = number_format($bytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = number_format($bytes / 1024, 2) . ' KB';
            }

            EDokumen::create([
                'nama_dokumen' => $request->nama_dokumen,
                'deskripsi' => $request->deskripsi,
                'file_path' => $path,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'tb_user_id' => Auth::id(),
            ]);

            return redirect()->route('operasional.surat.index', ['tab' => 'edokumen-tab'])->with('success', 'Dokumen berhasil diunggah.');
        }

        return redirect()->route('operasional.surat.index', ['tab' => 'edokumen-tab'])->with('error', 'Gagal mengunggah dokumen.');
    }

    public function edokumenDestroy($id)
    {
        $dokumen = EDokumen::findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('operasional.surat.index', ['tab' => 'edokumen-tab'])->with('success', 'Dokumen berhasil dihapus.');
    }

    public function fetchWaGroups()
    {
        $setting = Setting::first();
        $token = $setting?->fonnte_token;

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token Fonnte belum dikonfigurasi di Pengaturan Aplikasi.'
            ], 422);
        }

        try {
            // Step 1: Sync groups from device
            Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/fetch-group');

            // Step 2: Retrieve the list of groups
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/get-whatsapp-group');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'groups' => $data
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data grup dari Fonnte. Silakan periksa koneksi internet.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
