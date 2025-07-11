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
            // Menambahkan kolom admin_id sebagai foreign key
            // Pastikan tipe data (unsignedBigInteger) cocok dengan tipe data ID di tabel 'admins'
            $table->unsignedBigInteger('admin_id')->nullable()->after('status'); // Tambahkan setelah kolom 'status'
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Menghapus foreign key constraint terlebih dahulu
            $table->dropForeign(['admin_id']);
            // Kemudian menghapus kolom admin_id
            $table->dropColumn('admin_id');
        });
    }
};
