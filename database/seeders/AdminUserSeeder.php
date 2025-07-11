<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to use your User model

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin PUSDATIN',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1'), // Change to a secure password
            'peran' => 'admin',
            'peran' => 'Administrator', // <-- Add this line with an appropriate value
        ]);
    }
}
