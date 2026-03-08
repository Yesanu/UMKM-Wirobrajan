<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'admin@umkmwirobrajan.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('admin12345'),
                'role'     => 'admin',
            ]
        );

        // Pemilik UMKM
        User::updateOrCreate(
            ['email' => 'pemilik@umkmwirobrajan.com'],
            [
                'name'     => 'Pemilik UMKM',
                'password' => Hash::make('pemilik12345'),
                'role'     => 'pemilik',
            ]
        );

        // User Biasa
        User::updateOrCreate(
            ['email' => 'user@umkmwirobrajan.com'],
            [
                'name'     => 'User Test',
                'password' => Hash::make('user12345'),
                'role'     => 'user',
            ]
        );
    }
}
