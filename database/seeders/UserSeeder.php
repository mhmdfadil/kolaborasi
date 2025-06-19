<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan user admin
        User::create([
            'nama' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // pastikan password dienkripsi
            'email_verified_at' => now(),
            'role' => 'Admin',
            'status' => 'Active',
            'profile_picture' => 'default-admin.png', // Bisa menambahkan gambar default
        ]);

        // Menambahkan user mitra
        User::create([
            'nama' => 'Mitra A',
            'email' => 'mitra@example.com',
            'password' => Hash::make('password123'), // pastikan password dienkripsi
            'email_verified_at' => now(),
            'role' => 'Mitra',
            'status' => 'Active',
            'profile_picture' => 'default-mitra.png', // Bisa menambahkan gambar default
        ]);

        // Menambahkan user lainnya, bisa menambahkan lebih banyak lagi sesuai kebutuhan
        User::create([
            'nama' => 'Mitra B',
            'email' => 'mitra2@example.com',
            'password' => Hash::make('password123'), // pastikan password dienkripsi
            'email_verified_at' => now(),
            'role' => 'Mitra',
            'status' => 'Inactive',
            'profile_picture' => 'default-mitra2.png', // Bisa menambahkan gambar default
        ]);
    }
}
