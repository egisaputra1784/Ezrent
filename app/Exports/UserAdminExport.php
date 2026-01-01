<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserAdminExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::whereIn('role', ['superadmin', 'admin'])
            ->select('nama', 'email', 'no_hp', 'role', 'created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No HP',
            'Role',
            'Dibuat Pada',
        ];
    }
}
