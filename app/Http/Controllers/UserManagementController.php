<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display the user management page.
     */
    public function index()
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if ($hakakses->nama_hakakses !== 'administrator') {
            abort(403);
        }

        $roles = HakAkses::all();
        $users = User::with('hakakses')->get();

        return view('users.index', compact('user', 'hakakses', 'roles', 'users'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if ($hakakses->nama_hakakses !== 'administrator') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tb_user,email',
            'tb_hakakses_id' => 'required|exists:tb_hakakses,id',
            'password' => 'required|string|min:8|confirmed',
            'akses_modul' => 'nullable|array',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'tb_hakakses_id' => $validated['tb_hakakses_id'],
            'password' => Hash::make($validated['password']),
            'akses_modul' => $validated['akses_modul'] ?? [],
            'remember_token' => null,
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if ($hakakses->nama_hakakses !== 'administrator') {
            abort(403);
        }

        $roles = HakAkses::all();
        $editUser = User::with('hakakses')->findOrFail($id);

        return view('users.edit', compact('user', 'hakakses', 'roles', 'editUser'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $hakakses = $user->hakakses;

        if ($hakakses->nama_hakakses !== 'administrator') {
            abort(403);
        }

        $validated = $request->validate([
            'tb_hakakses_id' => 'required|exists:tb_hakakses,id',
            'password' => 'nullable|string|min:8|confirmed',
            'akses_modul' => 'nullable|array',
        ]);

        $editUser = User::findOrFail($id);
        $editUser->tb_hakakses_id = $validated['tb_hakakses_id'];
        $editUser->akses_modul = $validated['akses_modul'] ?? [];

        if (!empty($validated['password'])) {
            $editUser->password = Hash::make($validated['password']);
        }

        $editUser->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }
}

