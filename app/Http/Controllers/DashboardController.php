<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;
        $pengumumanList = \App\Models\Pengumuman::all();
        
        return view('dashboard.index', compact('user', 'hakakses', 'pengumumanList'));
    }

    /**
     * Update the current user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
