<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Pastikan Anda mengimpor model Admin Anda
use Illuminate\Support\Facades\Hash; // Untuk meng-hash password

class AdminSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat akun admin jika belum ada
        // Anda bisa mengubah email dan password di sini
        Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Cari berdasarkan email ini
            [
                'name' => 'Super Admin PUSDATIN',
                'password' => Hash::make('1'), // GANTI 'password123' dengan password yang kuat dan mudah Anda ingat
            ]
        );

        $this->command->info('Akun admin berhasil dibuat atau sudah ada!');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: 1 (Ganti dengan password yang Anda set)');
    }
}
