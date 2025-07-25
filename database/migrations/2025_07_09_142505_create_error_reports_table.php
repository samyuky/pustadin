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
                $table->string('reporter_name');
                $table->string('reporter_email');
                $table->string('reporter_phone')->nullable();
                $table->string('title');
                $table->text('description');
                $table->string('related_system')->nullable();
                $table->string('attachment_path')->nullable();
                $table->string('screenshot_path')->nullable();
                $table->string('status')->default('pending');
                $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete();
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('error_reports');
        }
    };
    