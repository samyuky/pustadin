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
        Schema::table('complaints', function (Blueprint $table) {
            // Mengubah kolom 'status' menjadi string dengan panjang yang cukup
            // Ini akan memungkinkan status seperti 'pending', 'approved', 'rejected', 'completed'
            // Jika sebelumnya ENUM, ini akan mengubahnya menjadi VARCHAR
            $table->string('status', 50)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Mengembalikan kolom 'status' ke definisi sebelumnya jika diperlukan
            // Misalnya, jika sebelumnya adalah ENUM dengan nilai spesifik:
            // $table->enum('status', ['new', 'investigating', 'resolved'])->default('new')->change();
            // Atau jika Anda hanya ingin mengembalikannya ke string yang lebih pendek:
            $table->string('status', 20)->default('new')->change(); // Sesuaikan dengan default lama Anda
        });
    }
};
