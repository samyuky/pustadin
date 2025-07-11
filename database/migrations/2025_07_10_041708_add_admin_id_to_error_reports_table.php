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
            // Tambahkan kolom admin_id sebagai foreign key
            // Pastikan tabel 'admins' sudah ada dan memiliki kolom 'id'
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            // Jika Anda tidak ingin menggunakan foreign key constraint, gunakan ini saja:
            // $table->unsignedBigInteger('admin_id')->nullable()->after('reporter_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('error_reports', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu jika ada
            $table->dropConstrainedForeignId('admin_id');
            // Kemudian hapus kolom
            // $table->dropColumn('admin_id'); // Gunakan ini jika tidak ada foreignId sebelumnya
        });
    }
};
