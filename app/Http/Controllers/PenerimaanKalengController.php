<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kaleng;
use App\Models\PenerimaanKaleng;
use Illuminate\Support\Facades\Auth;

class PenerimaanKalengController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user->hasAccess('koin') || !$user->hasAccess('koin.penerimaan')) {
                abort(403, 'Anda tidak memiliki hak akses untuk submodule Penerimaan Kaleng.');
            }
            return $next($request);
        });
    }

    public function create()
    {
        return view('koin.penerimaan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_penerimaan' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $data['tb_user_id'] = Auth::id();

        PenerimaanKaleng::create($data);

        return redirect()->route('koin.index')->with('success', 'Penerimaan berhasil disimpan.');
    }
}
