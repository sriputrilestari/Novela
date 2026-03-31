<?php
// ============================================================
// FILE: app/Models/NovelReport.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class NovelReport extends Model
{
    protected $fillable = [
        'user_id',
        'novel_id',
        'comment_id',
        'alasan',
        'deskripsi',
        'status',
        'catatan_admin',
    ];

    // ──────────────────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // ──────────────────────────────────────────────────────────
    // Rate Limit Helper
    // ──────────────────────────────────────────────────────────

    /**
     * Hitung berapa novel yang sudah direport user dalam 7 hari terakhir.
     * Batas: 2 novel per 7 hari.
     *
     * Contoh penggunaan di ReportController:
     *   if (NovelReport::reachedWeeklyLimit(Auth::id())) { abort atau redirect }
     */
    public static function reachedWeeklyLimit(int $userId, int $limit = 2): bool
    {
        $count = static::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->distinct('novel_id')
            ->count('novel_id');

        return $count >= $limit;
    }

    /**
     * Berapa sisa kuota report user dalam 7 hari ini.
     */
    public static function remainingQuota(int $userId, int $limit = 2): int
    {
        $used = static::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->distinct('novel_id')
            ->count('novel_id');

        return max(0, $limit - $used);
    }

    /**
     * Kapan kuota reader reset (7 hari dari report pertama minggu ini).
     */
    public static function quotaResetsAt(int $userId): ?Carbon
    {
        $oldest = static::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->oldest()
            ->first();

        return $oldest ? $oldest->created_at->addDays(7) : null;
    }

    // ──────────────────────────────────────────────────────────
    // Label Helpers
    // ──────────────────────────────────────────────────────────

    public function alasanLabel(): string
    {
        return match ($this->alasan) {
            'konten_dewasa'    => 'Konten Dewasa',
            'ujaran_kebencian' => 'Ujaran Kebencian',
            'spam'             => 'Spam',
            'plagiarisme'      => 'Plagiarisme',
            'kekerasan'        => 'Kekerasan',
            'lainnya'          => 'Lainnya',
            default            => ucfirst($this->alasan),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending'  => 'badge bg-warning text-dark',
            'ditinjau' => 'badge bg-info text-dark',
            'selesai'  => 'badge bg-success',
            'ditolak'  => 'badge bg-danger',
            default    => 'badge bg-secondary',
        };
    }
}
