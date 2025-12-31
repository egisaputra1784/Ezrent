<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\UserKasirExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserKasirController extends Controller
{
    public function index()
    {
        return view('kasir.index', [
            'users' => User::where('role', 'kasir')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp'    => 'required',
        ]);

        $userLogin = Auth::user();

        User::create([
            'owner_id' => $userLogin->owner_id,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'no_hp'    => $request->no_hp,
            'role'     => 'kasir',
        ]);

        return back()->with('success', 'User kasir berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'kasir')->findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User kasir berhasil diupdate');
    }

    public function destroy($id)
    {
        User::where('role', 'kasir')->findOrFail($id)->delete();
        return back()->with('success', 'User kasir berhasil dihapus');
    }

    public function exportExcel()
    {
        // dd('export function called');
        $ownerId = Auth::user()->owner_id;
        $filename = 'user-kasir-' . $ownerId . '.xlsx';
        return Excel::download(new UserKasirExport, $filename);
    }
}
