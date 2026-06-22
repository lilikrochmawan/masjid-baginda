<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\JenisBarang;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Surat;
use App\Models\RencanaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                if (str_starts_with($route, 'operasional.surat') && !$user->hasAccess('operasional.surat')) {
                    abort(403, 'Anda tidak memiliki akses untuk submodule Administrasi Persuratan.');
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
        $takmirs = Takmir::with('parent')->get();
        $parentOptions = Takmir::where('status', 'aktif')->get();

        return view('operasional.struktur', compact('user', 'hakakses', 'takmirs', 'parentOptions'));
    }

    public function strukturStore(Request $request)
    {
        $request->validate([
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

        return view('operasional.surat', compact('user', 'hakakses', 'surats'));
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

        return view('operasional.rencana', compact('user', 'hakakses', 'rencanas', 'takmirs'));
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
}
