<?php

namespace App\Exports;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $ownerId = Auth::user()->owner_id;

        return Produk::where('owner_id', $ownerId)
            ->with('kategori')
            ->get()
            ->map(function ($produk) {
                return [
                    'Nama Produk' => $produk->nama_produk,
                    'Kategori'    => $produk->kategori?->nama_kategori ?? '-',
                    'Harga Sewa'  => $produk->harga_sewa,
                    'Denda'       => $produk->denda,
                    'Status'      => $produk->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kategori',
            'Harga Sewa',
            'Denda (%)',
            'Status',
        ];
    }
}
