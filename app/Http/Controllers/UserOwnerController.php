<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserOwnerController extends Controller
{
    public function index()
    {
        return view('owner.index', [
            'users' => User::where('role', 'owner')->with('owner')->get(),
            'owners' => Owner::where('status', 'aktif')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owner,id',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp'    => 'required',
        ]);

        User::create([
            'owner_id' => $request->owner_id,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_hp'    => $request->no_hp,
            'role'     => 'owner',
        ]);

        return back()->with('success', 'User owner berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'owner')->findOrFail($id);

        $request->validate([
            'owner_id' => 'required|exists:owner,id',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'no_hp'    => 'required',
        ]);

        $user->update([
            'owner_id' => $request->owner_id,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
        ]);

        return back()->with('success', 'User owner berhasil diupdate');
    }

    public function destroy($id)
    {
        User::where('role', 'owner')->findOrFail($id)->delete();
        return back()->with('success', 'User owner berhasil dihapus');
    }
}
