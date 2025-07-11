<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('error_reports', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('reported_by')->nullable(); // Nama pelapor (opsional jika tidak ada user login)
                $table->string('email')->nullable(); // Email pelapor
                $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('error_reports');
        }
    };
    