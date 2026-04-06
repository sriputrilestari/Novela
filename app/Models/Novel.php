<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected $fillable = [
        'author_id', // wajib, bukan user_id lagi
        'genre_id',
        'judul',
        'sinopsis',
        'status',
        'cover',
        'approval_status',
        'views',
    ];

    // RELASI
    public function genre()
    {
        return $this->belongsTo(Genre::class);
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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
