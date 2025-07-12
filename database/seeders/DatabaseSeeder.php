<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); // Jika Anda memiliki User factory

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Panggil seeder Admin jika Anda memilikinya
        $this->call(AdminSeeder::class); // Pastikan ini ada jika Anda punya AdminSeeder
        
        // Panggil seeder FeederSyncRequestsTableSeeder
        $this->call(FeederSyncRequestsTableSeeder::class);
    }
}
