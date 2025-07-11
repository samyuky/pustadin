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
        Schema::table('data_requests', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan jalur file data yang dikirimkan
            // Pastikan kolom ini belum ada jika Anda pernah menjalankannya sebelumnya
            $table->string('delivered_data_path')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_requests', function (Blueprint $table) {
            // Saat rollback, hapus kolom ini
            $table->dropColumn('delivered_data_path');
        });
    }
};
