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
            Schema::create('simak_feature_requests', function (Blueprint $table) {
                $table->id();
                $table->string('feature_name'); // Nama fitur yang diminta
                $table->text('description');    // Deskripsi detail fitur
                $table->string('requester_name')->nullable(); // Nama peminta
                $table->string('requester_email')->nullable(); // Email peminta
                $table->string('requester_phone')->nullable(); // Nomor telepon peminta (opsional)
                $table->string('letter_path')->nullable(); // Path ke surat dari dekan/ketua
                $table->enum('status', ['pending', 'verified', 'in_process', 'completed', 'rejected'])->default('pending');
                $table->text('admin_notes')->nullable(); // Catatan dari admin
                $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null'); // Admin yang memproses
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('simak_feature_requests');
        }
    };
    