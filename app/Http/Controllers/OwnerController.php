<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // List owner
    public function index()
    {
        $owners = Owner::latest()->get();
        return view('perusahaan.index', compact('owners'));
    }

    // Store owner baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'expired_at' => 'required|date',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        // generate SN
        do {
            $serial = 'SN-' . rand(100000, 999999);
        } while (Owner::where('serial_number', $serial)->exists());

        Owner::create([
            'nama_usaha'    => $request->nama_usaha,
            'serial_number' => $serial,
            'expired_at'    => $request->expired_at,
            'status'        => $request->status,
        ]);

        return redirect()->back()->with('success', 'Owner berhasil ditambahkan 🚀');
    }


    // Update owner
    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'expired_at' => 'required|date',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        $owner->update([
            'nama_usaha' => $request->nama_usaha,
            'expired_at' => $request->expired_at,
            'status'     => $request->status,
        ]);

        return redirect()->back()->with('success', 'Owner berhasil diupdate ✨');
    }


    // Delete owner
    public function destroy($id)
    {
        $owner = Owner::findOrFail($id);
        $owner->delete();

        return redirect()->back()->with('success', 'Owner berhasil dihapus 🗑️');
    }
}
