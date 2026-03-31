<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'novel_id',
        'alasan',
        'deskripsi',
        'status',
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function novel()
    {
        return $this->belongsTo(Novel::class);
    }

    // Label & warna untuk badge status
    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'Menunggu',
            'reviewed' => 'Direview',
            'rejected' => 'Ditolak',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'  => '#f1a83d',
            'reviewed' => '#00c9a7',
            'rejected' => '#f1523d',
            default    => '#9698ae',
        };
    }

    public function statusBg(): string
    {
        return match ($this->status) {
            'pending'  => '#fef6e6',
            'reviewed' => '#e0faf5',
            'rejected' => '#fef0ee',
            default    => '#f4f6fc',
        };
    }
}
