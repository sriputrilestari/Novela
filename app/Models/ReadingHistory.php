<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    use HasFactory;

    protected $table = 'reading_history';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'last_read_at',
    ];

    // relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke Chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
