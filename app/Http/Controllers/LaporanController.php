<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function transaksi(Request $request)
    {
        $user = Auth::user();

        $query = Transaksi::with(['produk', 'customer'])
            ->where('owner_id', $user->owner_id);

        // filter tanggal
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_sewa', [$request->from, $request->to]);
        }

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->latest()->get();

        $totalTransaksi  = $transaksis->count();
        $totalDenda      = 0;
        $totalSewaMurni  = 0;

        foreach ($transaksis as $tr) {
            $hariSewa = \Carbon\Carbon::parse($tr->tanggal_sewa)
                ->diffInDays(\Carbon\Carbon::parse($tr->tanggal_kembali)) + 1;

            $hargaSewaMurni = $tr->produk->harga_sewa * $hariSewa;
            $totalSewaMurni += $hargaSewaMurni;

            // denda cuma kalau terlambat
            if ($tr->status === 'terlambat') {
                $totalDenda = $tr->denda;
            }
        }

        $totalPendapatan = $totalSewaMurni + $totalDenda;

        return view('laporan.transaksi', compact(
            'transaksis',
            'totalTransaksi',
            'totalSewaMurni',
            'totalDenda',
            'totalPendapatan'
        ));
    }
}
