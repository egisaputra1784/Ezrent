<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $produks = Produk::where('owner_id', $user->owner_id)->with('kategori')->latest()->get();
        $kategoris = Kategori::where('owner_id', $user->owner_id)->get();

        return view('produk.index', compact('produks', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|string|max:255',
            'harga_sewa'  => 'required|numeric',
            'denda'       => 'required|numeric',
            'status'      => 'required|in:tersedia,disewa',
            'gambar'      => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);


        $path = $request->file('gambar') ? $request->file('gambar')->store('produk', 'public') : null;

        Produk::create([
            'owner_id'    => Auth::user()->owner_id,
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_sewa'  => $request->harga_sewa,
            'denda'       => $request->denda ?? 0,
            'status'      => $request->status,
            'gambar'      => $path,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::where('owner_id', Auth::user()->owner_id)->findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'nama_produk' => 'required|string|max:255',
            'harga_sewa'  => 'required|numeric',
            'denda'       => 'required|integer',
            'status'      => 'required|in:tersedia,disewa',
            'gambar'      => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        if ($request->file('gambar')) {
            // hapus gambar lama kalau ada
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $produk->gambar = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'harga_sewa'  => $request->harga_sewa,
            'denda'       => $request->denda,
            'status'      => $request->status,
        ]);

        return back()->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::where('owner_id', Auth::user()->owner_id)->findOrFail($id);

        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }
}
