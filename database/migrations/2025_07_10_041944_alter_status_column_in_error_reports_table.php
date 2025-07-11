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
        Schema::table('error_reports', function (Blueprint $table) {
            // Mengubah kolom 'status' menjadi string (VARCHAR) dengan panjang 50 karakter
            // Pastikan untuk menambahkan ->change() agar Laravel tahu ini adalah perubahan kolom yang sudah ada
            $table->string('status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('error_reports', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan ke ENUM (jika itu tipe aslinya), Anda perlu tahu nilai ENUM aslinya
            // Contoh mengembalikan ke ENUM jika aslinya adalah ENUM('pending', 'approved', 'rejected')
            // $table->enum('status', ['pending', 'approved', 'rejected'])->change();

            // Atau, jika Anda hanya ingin mengembalikan ke string dengan panjang yang lebih kecil (jika itu aslinya)
            // Misalnya, jika aslinya adalah VARCHAR(20)
            // $table->string('status', 20)->change();

            // Untuk keamanan, jika Anda tidak yakin tipe aslinya, mungkin lebih baik
            // membiarkan kolom tetap string atau mengembalikan ke default yang aman.
            // Untuk tujuan rollback yang sederhana, kita bisa mengembalikan ke string yang lebih kecil
            // atau menghapus kolom dan menambahkannya kembali jika Anda tahu definisi persisnya.
            // Untuk saat ini, kita akan mengembalikannya ke string dengan panjang 20 sebagai contoh.
            $table->string('status', 20)->change();
        });
    }
};
