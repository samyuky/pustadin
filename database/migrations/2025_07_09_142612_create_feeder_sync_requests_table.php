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
        Schema::create('feeder_sync_requests', function (Blueprint $table) {
            $table->id();
            $table->string('subject'); // Pastikan kolom 'subject' ada di sini
            $table->text('description');
            $table->string('requester_name');
            $table->string('requester_email');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('resolution_notes')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            // Tambahkan foreign key constraint jika Anda memiliki tabel 'admins'
            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeder_sync_requests');
    }
};
