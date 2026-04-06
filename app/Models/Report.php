<?php
// app/Models/Report.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model tunggal untuk laporan novel.
 * Tabel: novel_reports
 *
 * Dipakai oleh Admin, Author, dan Reader controller.
 */
class Report extends Model
{
    protected $table = 'novel_reports';

    protected $fillable = [
        'user_id',
        'novel_id',
        'comment_id',
        'alasan',
        'deskripsi',
        'status',
        'catatan_admin',
    ];

    // ─── Relations ────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function novel(): BelongsTo
    {
        return $this->belongsTo(Novel::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class)->withDefault();
    }
    public function chapter()
    {return $this->belongsTo(\App\Models\Chapter::class);}

    // ─── Label Helpers ────────────────────────────────────────────

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'Pending',
            'reviewed' => 'Direview',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    public function alasanLabel(): string
    {
        return match ($this->alasan) {
            'konten_dewasa'    => 'Konten Dewasa',
            'ujaran_kebencian' => 'Ujaran Kebencian',
            'spam'             => 'Spam / Tidak Relevan',
            'plagiarisme'      => 'Plagiarisme',
            'kekerasan'        => 'Kekerasan Berlebihan',
            'lainnya'          => 'Lainnya',
            default            => ucwords(str_replace('_', ' ', $this->alasan)),
        };
    }

    // ─── Rate Limit Helpers ───────────────────────────────────────

    /**
     * Cek apakah user sudah mencapai batas 2 laporan unik per 7 hari
     */
    public static function reachedWeeklyLimit(int $userId): bool
    {
        return static::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->distinct('novel_id')
            ->count('novel_id') >= 2;
    }

    /**
     * Waktu kapan kuota laporan reset (laporan terlama + 7 hari)
     */
    public static function quotaResetsAt(int $userId): ?Carbon
    {
        $oldest = static::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->oldest()
            ->first();

        return $oldest ? $oldest->created_at->addDays(7) : null;
    }
}
