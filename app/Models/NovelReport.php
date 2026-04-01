<?php
// app/Models/NovelReport.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class NovelReport extends Model
{
    protected $table = 'novel_reports';

    protected $fillable = ['user_id', 'novel_id', 'comment_id', 'alasan', 'deskripsi', 'status', 'catatan_admin'];

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class)->withDefault();
    }
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
    
    // Rate limit helper
    public static function reachedWeeklyLimit($userId): bool
    {
        return static::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->distinct('novel_id')
            ->count('novel_id') >= 2;
    }

    public static function quotaResetsAt($userId): ?Carbon
    {
        $oldest = static::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->oldest()
            ->first();
        return $oldest ? $oldest->created_at->addDays(7) : null;
    }
}
