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
        Schema::create('complaints', function (Blueprint $table) {
            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('admins')
                  ->nullOnDelete();
            $table->id();
            $table->string('subject');
            $table->text('message');
            $table->string('complainant_name');
            $table->string('complainant_email');
            $table->string('status')->default('pending');
            $table->text('resolution_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        DB::table('complaints')
            ->where('id', 2)
            ->update([
                'status' => 'completed',
                'updated_at' => now()
            ]);

        Complaint::find(2)->update([
            'status' => 'completed',
            'admin_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
