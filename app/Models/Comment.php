<?php
// ============================================================
// FILE: app/Models/Comment.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'chapter_id',
        'komentar',
        'parent_id',
        'is_hidden',
        'is_toxic',
        'hidden_reason',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'is_toxic'  => 'boolean',
    ];

    // ──────────────────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // Semua reply (untuk panel author — tampilkan semua)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user')->latest();
    }

    // Hanya reply yang visible (untuk halaman reader)
    public function visibleReplies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->where('is_hidden', false)
            ->where('is_toxic', false)
            ->with('user')
            ->latest();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // ──────────────────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────────────────

    /**
     * Gunakan di controller Reader supaya komentar hidden/toxic tidak muncul.
     * Contoh: Comment::visible()->topLevel()->where('chapter_id', $id)->get()
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_hidden', false)->where('is_toxic', false);
    }

    /** Hanya komentar utama, bukan reply */
    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    // ──────────────────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────────────────

    public function isVisible(): bool
    {
        return ! $this->is_hidden && ! $this->is_toxic;
    }
}
