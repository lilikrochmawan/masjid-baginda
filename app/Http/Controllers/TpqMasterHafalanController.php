<?php

namespace App\Http\Controllers;

use App\Models\TpqMasterHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TpqMasterHafalanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('tpq')) {
                abort(403, 'Anda tidak memiliki hak akses untuk modul TPQ.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of master hafalan items.
     */
    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        $items = TpqMasterHafalan::orderBy('kategori')->orderBy('nama')->get();

        return view('tpq.master_hafalan', compact('user', 'hakakses', 'items'));
    }

    /**
     * Store a newly created item in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:surah_pendek,doa_harian',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        TpqMasterHafalan::create($request->all());

        return redirect()->route('tpq.master-hafalan.index')->with('success', 'Master data hafalan berhasil ditambahkan.');
    }

    /**
     * Update the specified item in database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|in:surah_pendek,doa_harian',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $item = TpqMasterHafalan::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('tpq.master-hafalan.index')->with('success', 'Master data hafalan berhasil diperbarui.');
    }

    /**
     * Remove the specified item from database.
     */
    public function destroy($id)
    {
        $item = TpqMasterHafalan::findOrFail($id);
        $item->delete();

        return redirect()->route('tpq.master-hafalan.index')->with('success', 'Master data hafalan berhasil dihapus.');
    }
}
