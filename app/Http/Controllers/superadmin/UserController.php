<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * LIST USER (SUPERADMIN & ADMIN)
     */
    public function index()
    {
        $users = User::whereIn('role', ['superadmin', 'admin'])->get();

        return view('superadmin.index', compact('users'));
    }

    /**
     * SIMPAN USER
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required|integer|min:11',
            'role'     => 'required|in:superadmin,admin',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_hp'     => $request->no_hp,
            'role'     => $request->role,
            'owner_id' => null,
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }


    /**
     * UPDATE USER
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Jangan biarin superadmin ngedit dirinya jadi admin
        if ($user->id === Auth::id() && $request->role !== 'superadmin') {
            return back()->with('error', 'Tidak bisa mengubah role diri sendiri');
        }

        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|integer|min:11',
            'role'  => 'required|in:superadmin,admin',
        ]);

        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'no_hp'  => $request->no_hp,
            'role'  => $request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    /**
     * HAPUS USER
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
