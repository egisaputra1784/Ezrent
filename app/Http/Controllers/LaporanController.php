<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
                $totalDenda += $tr->denda;
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

    public function exportExcel(Request $request)
    {
        $from   = $request->from;
        $to     = $request->to;
        $status = $request->status;

        // nama dasar
        $filename = 'laporan-transaksi';

        // tambahin status
        if ($status) {
            $filename .= '-' . $status;
        }

        // tambahin periode
        if ($from && $to) {
            $filename .= '-' . $from . '_sampai_' . $to;
        }

        $filename .= '.xlsx';

        return Excel::download(
            new TransaksiExport($request),
            $filename
        );
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $query = Transaksi::with(['customer', 'produk'])
            ->where('owner_id', $user->owner_id);

        // filter tanggal
        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_sewa', [$request->from, $request->to]);
        }

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transaksis = $query->get();

        // =====================
        // HITUNG TOTAL
        // =====================
        $totalTransaksi = $transaksis->count();
        $totalSewaMurni = 0;
        $totalDenda     = 0;

        foreach ($transaksis as $tr) {
            $hariSewa = \Carbon\Carbon::parse($tr->tanggal_sewa)
                ->diffInDays(\Carbon\Carbon::parse($tr->tanggal_kembali)) + 1;

            $totalSewaMurni += $tr->produk->harga_sewa * $hariSewa;

            if ($tr->status === 'terlambat') {
                $totalDenda += $tr->denda;
            }
        }

        $totalPendapatan = $totalSewaMurni + $totalDenda;

        // =====================
        // GENERATE PDF
        // =====================
        $pdf = Pdf::loadView('laporan.transaksi_pdf', compact(
            'transaksis',
            'totalTransaksi',
            'totalSewaMurni',
            'totalDenda',
            'totalPendapatan'
        ))->setPaper('A4', 'portrait');

        // =====================
        // NAMA FILE
        // =====================
        $filename = 'laporan-transaksi';

        if ($request->status) {
            $filename .= '-' . $request->status;
        }

        if ($request->from && $request->to) {
            $filename .= '-' . $request->from . '_sampai_' . $request->to;
        }

        $filename .= '.pdf';

        return $pdf->download($filename);
    }
}
