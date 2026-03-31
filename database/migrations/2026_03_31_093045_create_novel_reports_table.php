<?php
// ============================================================
// FILE: database/migrations/xxxx_xx_xx_create_novel_reports_table.php
// PERINTAH: php artisan migrate
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('novel_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();                // reader yang report
            $table->foreignId('novel_id')->constrained('novels')->cascadeOnDelete();              // novel yang dilaporkan
            $table->foreignId('comment_id')->nullable()->constrained('comments')->nullOnDelete(); // komentar terkait (opsional)

            // Alasan report
            $table->enum('alasan', [
                'konten_dewasa',
                'ujaran_kebencian',
                'spam',
                'plagiarisme',
                'kekerasan',
                'lainnya',
            ]);
            $table->text('deskripsi')->nullable(); // penjelasan tambahan dari reader

            // Status penanganan oleh admin/author
            $table->enum('status', ['pending', 'ditinjau', 'selesai', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            // ── Rate limit: 1 user hanya bisa report 1 novel 1 kali ──
            // (batas 2 novel per 7 hari dikontrol di ReportController)
            $table->unique(['user_id', 'novel_id'], 'unique_user_novel_report');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('novel_reports');
    }
};
