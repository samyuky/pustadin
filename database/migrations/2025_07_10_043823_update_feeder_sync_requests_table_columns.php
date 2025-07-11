<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feeder_sync_requests', function (Blueprint $table) {
            // --- Hapus Kolom Lama (Jika Ada) ---
            // Periksa apakah kolom 'requested_by' dan 'email' ada sebelum menghapusnya
            if (Schema::hasColumn('feeder_sync_requests', 'requested_by')) {
                $table->dropColumn('requested_by');
            }
            if (Schema::hasColumn('feeder_sync_requests', 'email')) {
                $table->dropColumn('email');
            }
            // Hapus juga 'feeder_name' jika Anda tidak lagi menggunakannya
            if (Schema::hasColumn('feeder_sync_requests', 'feeder_name')) {
                $table->dropColumn('feeder_name');
            }

            // --- Pastikan Kolom 'description' Ada ---
            // Jika kolom 'description' belum ada, tambahkan sebagai text nullable
            if (!Schema::hasColumn('feeder_sync_requests', 'description')) {
                $table->text('description')->nullable()->after('id'); // Menambahkan setelah 'id' sebagai posisi aman
            }

            // --- Tambahkan Kolom Baru yang Diperlukan ---
            // Tambahkan 'requester_name' jika belum ada
            if (!Schema::hasColumn('feeder_sync_requests', 'requester_name')) {
                $table->string('requester_name')->after('description'); // Setelah description
            }
            // Tambahkan 'requester_email' jika belum ada
            if (!Schema::hasColumn('feeder_sync_requests', 'requester_email')) {
                $table->string('requester_email')->after('requester_name');
            }
            // Tambahkan 'requester_phone' jika belum ada
            if (!Schema::hasColumn('feeder_sync_requests', 'requester_phone')) {
                $table->string('requester_phone', 20)->nullable()->after('requester_email');
            }
            // Tambahkan 'request_type' setelah 'requester_phone' (posisi yang lebih aman)
            if (!Schema::hasColumn('feeder_sync_requests', 'request_type')) {
                $table->string('request_type')->after('requester_phone');
            }

            // --- Atasi Kolom 'status' secara Robust ---
            // Jika kolom 'status' sudah ada, hapus dulu untuk memastikan tipe dan properti yang benar
            if (Schema::hasColumn('feeder_sync_requests', 'status')) {
                $table->dropColumn('status');
            }
            // Tambahkan kolom 'status' dengan tipe string dan default 'pending'
            // Posisikan setelah 'request_type' untuk konsistensi
            $table->string('status', 50)->default('pending')->after('request_type');

            // --- Tambahkan Kolom 'admin_id' ---
            // Pastikan kolom ini belum ada sebelum menambahkannya
            if (!Schema::hasColumn('feeder_sync_requests', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feeder_sync_requests', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu jika ada
            if (Schema::hasColumn('feeder_sync_requests', 'admin_id')) {
                $table->dropConstrainedForeignId('admin_id');
            }

            // Hapus kolom baru yang ditambahkan oleh migrasi ini
            $table->dropColumn([
                'requester_name',
                'requester_email',
                'requester_phone',
                'request_type',
                'status', // Hapus kolom status yang ditambahkan/dimodifikasi
            ]);

            // Hapus kolom description jika migrasi ini yang menambahkannya
            if (Schema::hasColumn('feeder_sync_requests', 'description')) {
                $table->dropColumn('description');
            }

            // Kembalikan kolom lama (jika sebelumnya ada dan ingin dikembalikan)
            // Sesuaikan dengan definisi asli tabel Anda sebelum migrasi ini
            // Contoh jika ini kolom asli:
            // $table->string('feeder_name')->nullable();
            // $table->string('requested_by')->nullable();
            // $table->string('email')->nullable();

            // Jika Anda ingin mengembalikan kolom 'status' ke definisi ENUM aslinya
            // Anda harus tahu nilai-nilai ENUM yang tepat dari migrasi create_feeder_sync_requests_table
            // Contoh:
            // $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
        });
    }
};
