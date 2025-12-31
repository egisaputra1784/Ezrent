<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserKasirExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $ownerId = Auth::user()->owner_id;

        return User::where('role', 'kasir')
            ->where('owner_id', $ownerId)
            ->get(['nama', 'email', 'no_hp']);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No HP',
        ];
    }
}
