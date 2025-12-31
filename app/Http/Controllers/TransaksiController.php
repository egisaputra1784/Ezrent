<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $transaksisAktif = Transaksi::where('owner_id', $user->owner_id)
            ->where('status', 'aktif')
            ->with('produk')
            ->get();

        foreach ($transaksisAktif as $tr) {
            $tanggalKembali = Carbon::parse($tr->tanggal_kembali);
            $now = Carbon::now();

            if ($now->gt($tanggalKembali)) { // sudah lewat tanggal kembali
                $hariTerlambat = $tanggalKembali->diffInDays($now);
                $dendaPersenPerHari = $tr->produk->denda; // ambil dari produk

                $totalDenda = $tr->harga * ($dendaPersenPerHari / 100) * $hariTerlambat;

                $tr->update([
                    'status' => 'terlambat',
                    'denda' => $totalDenda
                ]);
            }
        }

        $query = Transaksi::with(['produk', 'customer', 'user'])
            ->where('owner_id', $user->owner_id);

        if ($request->search) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%");
            });
        }

        $transaksis = $query->latest()->get();
        $customers = Customer::where('owner_id', $user->owner_id)->get();
        $produks = Produk::where('owner_id', $user->owner_id)->where('status', 'tersedia')->get();

        return view('transaksi.index', compact('transaksis', 'customers', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customer,id',
            'produk_id' => 'required|exists:produk,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
            'status' => 'required|in:aktif,selesai,terlambat',
            'jaminan_tipe' => 'nullable|in:uang,identitas',
            'jaminan_nilai' => 'nullable|numeric',
            'jaminan_detail' => 'nullable|string',
        ]);

        $user = Auth::user();
        $produk = Produk::findOrFail($request->produk_id);

        // Hitung total harga sewa
        $tanggalSewa = new \DateTime($request->tanggal_sewa);
        $tanggalKembali = new \DateTime($request->tanggal_kembali);
        $diffHari = $tanggalSewa->diff($tanggalKembali)->days + 1; // termasuk hari pertama
        $totalHarga = $produk->harga_sewa * $diffHari;

        Transaksi::create([
            'owner_id' => $user->owner_id,
            'user_id' => $user->id,
            'customer_id' => $request->customer_id,
            'produk_id' => $produk->id,
            'harga' => $totalHarga,
            'denda' => 0, // default
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
            'jaminan_tipe' => $request->jaminan_tipe,
            'jaminan_nilai' => $request->jaminan_nilai,
            'jaminan_detail' => $request->jaminan_detail,
        ]);

        // update status produk jadi disewa
        $produk->update(['status' => 'disewa']);

        return back()->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::where('owner_id', Auth::user()->owner_id)->findOrFail($id);

        // ubah status produk kembali tersedia
        $transaksi->produk->update(['status' => 'tersedia']);
        $transaksi->delete();

        return back()->with('success', 'Transaksi berhasil dihapus');
    }
}
