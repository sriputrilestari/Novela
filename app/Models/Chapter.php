<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'novel_id',
        'judul_chapter',
        'isi',
        'urutan'
    ];

    
    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class);
    }
}

