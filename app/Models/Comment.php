<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'chapter_id',
        'komentar',
        'parent_id'
    ];

    // Relasi ke user (pembuat komentar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    // Balasan komentar
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user');
    }

    // Parent komentar
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}