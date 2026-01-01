<?php

namespace App\Exports;

use App\Models\Owner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OwnerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Owner::select(
            'nama_usaha',
            'serial_number',
            'expired_at',
            'status',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama Usaha',
            'Serial Number',
            'Expired At',
            'Status',
            'Dibuat Pada',
        ];
    }
}
