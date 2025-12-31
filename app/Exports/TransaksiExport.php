<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class TransaksiExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $user = Auth::user();

        $query = Transaksi::with(['customer', 'produk'])
            ->where('owner_id', $user->owner_id);

        if ($this->request->from && $this->request->to) {
            $query->whereBetween('tanggal_sewa', [
                $this->request->from,
                $this->request->to
            ]);
        }

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        $transaksis = $query->get();

        $rows = new Collection();

        $totalSewa = 0;
        $totalDenda = 0;

        foreach ($transaksis as $tr) {
            $rows->push([
                $tr->tanggal_sewa,
                $tr->customer->nama,
                $tr->produk->nama_produk,
                $tr->harga,
                $tr->denda,
                $tr->harga + $tr->denda,
                strtoupper($tr->status),
            ]);

            $totalSewa += $tr->harga;
            $totalDenda += $tr->denda;
        }

        $totalPendapatan = $totalSewa + $totalDenda;

        // 🔽 BARIS KOSONG
        $rows->push(['', '', '', '', '', '', '']);

        // 🔽 TOTAL-TOTAL
        $rows->push(['TOTAL TRANSAKSI', $transaksis->count(), '', '', '', '', '']);
        $rows->push(['TOTAL SEWA', '', '', $totalSewa, '', '', '']);
        $rows->push(['TOTAL DENDA', '', '', '', $totalDenda, '', '']);
        $rows->push(['TOTAL PENDAPATAN', '', '', '', '', $totalPendapatan, '']);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Customer',
            'Produk',
            'Harga',
            'Denda',
            'Total',
            'Status'
        ];
    }
}
