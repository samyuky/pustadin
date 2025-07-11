<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();

            // Tambahkan kolom-kolom identitas pemohon di sini
            $table->string('requester_name');
            $table->string('requester_email');
            $table->string('requester_phone')->nullable();

            $table->string('title'); // Pastikan kolom 'title' ada di sini
            $table->text('description');
            $table->string('purpose');
            $table->date('needed_date');
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_requests');
    }
};