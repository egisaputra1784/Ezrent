<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kategori sesuai owner_id
        $kategoris = Kategori::where('owner_id', $user->owner_id)->latest()->get();

        return view('kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'owner_id' => Auth::user()->owner_id,
            'nama_kategori' => $request->nama_kategori,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::where('owner_id', Auth::user()->owner_id)->findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::where('owner_id', Auth::user()->owner_id)->findOrFail($id);
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
