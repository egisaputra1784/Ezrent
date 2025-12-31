<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $ownerId = Auth::user()->owner_id;
        return Customer::where('owner_id', $ownerId)
            ->select('nama', 'no_hp', 'alamat') // kolom yang mau ditampilkan
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'No HP',
            'Alamat',
        ];
    }
}
