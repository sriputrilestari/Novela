<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected $fillable = [
        'genre_id',
        'judul',
        'sinopsis',
        'penulis',
        'approval_status'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

}

