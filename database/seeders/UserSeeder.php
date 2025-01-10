<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat user dengan role admin
        User::create([
            'name' => 'admin',
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'role' => 'admin',
            'email' => 'admin@example.com', // Ganti dengan email yang diinginkan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
