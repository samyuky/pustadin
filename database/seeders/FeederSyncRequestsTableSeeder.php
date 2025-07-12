<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\FeederSyncRequest;
    use Illuminate\Support\Carbon;

    class FeederSyncRequestsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            FeederSyncRequest::create([
                'subject' => 'Permintaan Sinkronisasi Data Mahasiswa Baru',
                'description' => 'Memohon sinkronisasi data mahasiswa angkatan 2023 yang belum masuk ke sistem Feeder.',
                'requester_name' => 'Budi Santoso',
                'requester_email' => 'budi.santoso@uniga.ac.id',
                'request_type' => 'Data Mahasiswa', // Tambahkan nilai untuk request_type
                'status' => 'pending',
                'resolution_notes' => null,
                'admin_id' => null,
                'resolved_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            FeederSyncRequest::create([
                'subject' => 'Update Data Dosen Mata Kuliah X',
                'description' => 'Permintaan update data dosen pengampu mata kuliah Basis Data untuk semester genap.',
                'requester_name' => 'Siti Aminah',
                'requester_email' => 'siti.aminah@uniga.ac.id',
                'request_type' => 'Update Dosen', // Tambahkan nilai untuk request_type
                'status' => 'processing',
                'resolution_notes' => 'Sedang dalam proses verifikasi data dengan bagian akademik.',
                'admin_id' => 1,
                'resolved_at' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(1),
            ]);

            $this->command->info('FeederSyncRequests seeded!');
        }
    }
    