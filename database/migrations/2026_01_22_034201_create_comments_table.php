<?php
// ============================================================
// FILE: database/migrations/xxxx_xx_xx_create_comments_table.php
// PERINTAH: php artisan migrate
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained('chapters')->cascadeOnDelete();
            $table->text('komentar');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();

            // ── Moderasi ──────────────────────────────────────
            // is_hidden  : author sembunyikan → reader tidak melihat
            // is_toxic   : author tandai toxic → otomatis tersembunyi
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_toxic')->default(false);
            $table->string('hidden_reason')->nullable(); // alasan disembunyikan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
