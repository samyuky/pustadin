    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('bulletin_board_announcements', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content');
                $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade'); // Admin yang membuat pengumuman
                $table->timestamp('published_at')->nullable(); // Untuk penjadwalan atau draft
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('bulletin_board_announcements');
        }
    };
    