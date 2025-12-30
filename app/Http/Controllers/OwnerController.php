<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // =========================
    // LIST DATA OWNER
    // =========================
    public function index()
    {
        $owners = Owner::latest()->get();
        return view('owner.index', compact('owners'));
    }

    // =========================
    // FORM TAMBAH OWNER
    // =========================
    public function create()
    {
        return view('owner.create');
    }

    // =========================
    // SIMPAN OWNER
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha'    => 'required|string|max:255',
            'serial_number' => 'required|unique:owner,serial_number',
            'expired_at'    => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        Owner::create([
            'nama_usaha'    => $request->nama_usaha,
            'serial_number' => $request->serial_number,
            'expired_at'    => $request->expired_at,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT OWNER
    // =========================
    public function edit(Owner $owner)
    {
        return view('owner.edit', compact('owner'));
    }

    // =========================
    // UPDATE OWNER
    // =========================
    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'nama_usaha'    => 'required|string|max:255',
            'serial_number' => 'required|unique:owner,serial_number,' . $owner->id,
            'expired_at'    => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $owner->update([
            'nama_usaha'    => $request->nama_usaha,
            'serial_number' => $request->serial_number,
            'expired_at'    => $request->expired_at,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil diupdate');
    }

    // =========================
    // HAPUS OWNER
    // =========================
    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil dihapus');
    }
}
