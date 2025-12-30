<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //OWNER
        Owner::create([
            'nama_usaha'   => 'Rental Jaya Abadi',
            'serial_number' => strtoupper(Str::random(16)),
            'status'       => 'aktif',
            'expired_at'   => now()->addYear(),
        ]);

        // SUPERADMIN
        User::create([
            'nama'     => 'Super Admin',
            'email'    => 'superadmin@posrental.test',
            'password' => Hash::make('123456'),
            'role'     => 'superadmin',
            'owner_id' => null,
        ]);

        // ADMIN
        User::create([
            'nama'     => 'Admin',
            'email'    => 'admin@posrental.test',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
            'owner_id' => null,
        ]);

        // OWNER
        $owner = Owner::first();

        User::create([
            'nama'     => 'Owner Rental',
            'email'    => 'owner@posrental.test',
            'password' => Hash::make('123456'),
            'role'     => 'owner',
            'owner_id' => $owner->id,
        ]);

        // KASIR
        User::create([
            'nama'     => 'Kasir 1',
            'email'    => 'kasir@posrental.test',
            'password' => Hash::make('123456'),
            'role'     => 'kasir',
            'owner_id' => $owner->id,
        ]);
    }
}
