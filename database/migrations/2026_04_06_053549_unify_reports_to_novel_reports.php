<?php

// ============================================================
// FILE: database/migrations/2026_04_05_000001_unify_reports_to_novel_reports.php
//
// Tujuan:
//   - Tabel `novel_reports` dijadikan satu-satunya tabel laporan
//   - Tambah kolom yang masih kurang (comment_id sudah ada di novel_reports)
//   - Samakan kolom `status` → pakai: pending | reviewed | rejected
//   - Pindah data dari `reports` ke `novel_reports` (jika ada)
//   - Hapus tabel `reports` lama
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Pastikan novel_reports punya semua kolom yang dibutuhkan ──
        Schema::table('novel_reports', function (Blueprint $table) {

            // Kolom catatan_admin mungkin belum ada (novel_reports lama belum punya)
            if (! Schema::hasColumn('novel_reports', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable()->after('status');
            }

            // Normalkan enum status agar cocok dengan Admin controller
            // (novel_reports lama pakai: pending|ditinjau|selesai|ditolak)
            // Kita ubah ke: pending|reviewed|rejected
            // → dilakukan via raw ALTER agar kompatibel MySQL & MariaDB
        });

        // Ubah enum status novel_reports → 3 nilai standar
        DB::statement("
            ALTER TABLE novel_reports
            MODIFY COLUMN status
            ENUM('pending','reviewed','rejected')
            NOT NULL DEFAULT 'pending'
        ");

        // ── 2. Pindah data dari `reports` ke `novel_reports` ──
        if (Schema::hasTable('reports')) {
            $rows = DB::table('reports')->get();

            foreach ($rows as $row) {
                // Hindari duplikat (unique user_id + novel_id)
                $exists = DB::table('novel_reports')
                    ->where('user_id', $row->user_id)
                    ->where('novel_id', $row->novel_id)
                    ->exists();

                if (! $exists) {
                    DB::table('novel_reports')->insert([
                        'user_id'       => $row->user_id,
                        'novel_id'      => $row->novel_id,
                        'comment_id'    => null,
                        'alasan'        => $this->mapAlasan($row->alasan),
                        'deskripsi'     => $row->deskripsi ?? null,
                        'status'        => $this->mapStatus($row->status),
                        'catatan_admin' => $row->catatan_admin ?? null,
                        'created_at'    => $row->created_at,
                        'updated_at'    => $row->updated_at,
                    ]);
                }
            }

            // ── 3. Hapus tabel reports lama ──
            Schema::dropIfExists('reports');
        }
    }

    public function down(): void
    {
        // Kembalikan tabel reports (tanpa data)
        if (! Schema::hasTable('reports')) {
            Schema::create('reports', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('novel_id')->constrained('novels')->cascadeOnDelete();
                $table->string('alasan');
                $table->text('deskripsi')->nullable();
                $table->enum('status', ['pending', 'reviewed', 'rejected'])->default('pending');
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }

        // Kembalikan enum novel_reports ke versi lama
        DB::statement("
            ALTER TABLE novel_reports
            MODIFY COLUMN status
            ENUM('pending','ditinjau','selesai','ditolak')
            NOT NULL DEFAULT 'pending'
        ");
    }

    // ── Helpers ──────────────────────────────────────────────────

    /**
     * Map nilai alasan dari tabel reports (string bebas) ke
     * enum ketat yang dipakai novel_reports.
     */
    private function mapAlasan(string $alasan): string
    {
        $map = [
            'Konten Dewasa'               => 'konten_dewasa',
            'Kekerasan Berlebihan'        => 'kekerasan',
            'Plagiarisme'                 => 'plagiarisme',
            'Ujaran Kebencian'            => 'ujaran_kebencian',
            'Spam / Konten Tidak Relevan' => 'spam',
            'Lainnya'                     => 'lainnya',
        ];

        return $map[$alasan] ?? 'lainnya';
    }

    /**
     * Map status antara dua skema.
     * reports: pending|reviewed|rejected
     * novel_reports lama: pending|ditinjau|selesai|ditolak
     * Tujuan akhir: pending|reviewed|rejected
     */
    private function mapStatus(string $status): string
    {
        return match ($status) {
            'ditinjau' => 'reviewed',
            'selesai'  => 'reviewed',
            'ditolak'  => 'rejected',
            default    => $status, // pending, reviewed, rejected → tetap
        };
    }
};
