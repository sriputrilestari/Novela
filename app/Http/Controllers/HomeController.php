<?php
namespace App\Http\Controllers;

use App\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Hero dulu (Rating tertinggi)
        $featured = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved')
            ->orderByDesc('rating')
            ->orderByDesc('created_at') // Cadangan jika rating sama
            ->first();

        // Ambil ID featured supaya tidak muncul lagi di list bawah (opsional)
        $featuredId = $featured ? $featured->id : null;

        // 2. Novel Terbaru (Urutkan berdasarkan ID agar pasti yang paling baru di atas)
        $latestNovels = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved')
                            // ->where('id', '!=', $featuredId) // Hilangkan comment jika tak ingin duplikat dengan Hero
            ->orderByDesc('id') // Menggunakan ID lebih akurat dibanding created_at untuk deadline
            ->take(15)          // Batasi agar web tidak berat
            ->get();

        // 3. Novel Populer
        $popularNovels = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved')
            ->orderByDesc('views')
            ->take(15)
            ->get();

        // 4. Reading History
        $readingHistory = auth()->check()
            ? auth()->user()->readingHistory()
            ->with('chapter.novel.genre')
            ->latest('last_read_at')
            ->take(5)
            ->get()
            : collect();

        return view('home', [
            'featured'       => $featured,
            'latestNovels'   => $latestNovels,
            'popularNovels'  => $popularNovels,
            'readingHistory' => $readingHistory,
        ]);
    }

    public function show($id)
    {
        // Gunakan with untuk performa lebih cepat saat load detail
        $novel = Novel::with(['author', 'genre', 'chapters'])->findOrFail($id);
        return view('novel.show', compact('novel'));
    }
}
