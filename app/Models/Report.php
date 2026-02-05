<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'novel_id',
        'alasan',
        'description',
        'status'
    ];

    // pelapor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // novel yang dilapor
    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }
}
