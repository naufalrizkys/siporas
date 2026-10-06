<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus admin lama
        User::where('role', 'admin')
            ->where('email', '!=', 'adminsiporas@gmail.com')
            ->delete();

        // Admin Utama SIPORAS
        User::updateOrCreate(
            ['email' => 'adminsiporas@gmail.com'],
            [
                'name' => 'Admin Utama SIPORAS',
                'email' => 'adminsiporas@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // User / Operator
        User::updateOrCreate(
            ['email' => 'operator@siporas.go.id'],
            [
                'name' => 'Operator Kesbangpol',
                'email' => 'operator@siporas.go.id',
                'password' => Hash::make('operator123'),
                'role' => 'user',
            ]
        );
    }
}
