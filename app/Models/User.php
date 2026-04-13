<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ReadingHistory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'bio',
        'photo',
        'is_active',
        'is_blocked',
        'author_request',
        'author_request_note',
        'author_request_date',
        'author_approved_at',
        'author_rejected_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'is_blocked'        => 'boolean',
            'author_request_date' => 'datetime',
            'author_approved_at'  => 'datetime',
            'author_rejected_at'  => 'datetime',
        ];
    }

    // user punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // user punya banyak bookmark
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // user punya banyak riwayat baca
    public function readingHistories()
    {
        return $this->hasMany(ReadingHistory::class, 'user_id');
    }

    public function novels()
    {
        return $this->hasMany(Novel::class, 'author_id');
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
