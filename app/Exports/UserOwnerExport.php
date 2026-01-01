<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserOwnerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with('owner')
            ->where('role', 'owner')
            ->get()
            ->map(function ($user) {
                return [
                    'Nama User'   => $user->nama,
                    'Email'       => $user->email,
                    'No HP'       => $user->no_hp,
                    'Nama Usaha'  => $user->owner?->nama_usaha ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama User',
            'Email',
            'No HP',
            'Nama Usaha',
        ];
    }
}
