<?php
namespace App\Http\Controllers;

use App\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Hero (Featured) - Berdasarkan rating tertinggi
        $featured = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved')
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->first();

        // 2. Novel Terbaru - Urutkan berdasarkan ID DESC (Paling baru di paling awal)
        $latestNovels = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved') // Pastikan status di DB adalah 'approved'
            ->orderByDesc('id')
            ->take(15)
            ->get();

        // 3. Novel Populer - Berdasarkan jumlah views
        $popularNovels = Novel::with(['author', 'genre'])
            ->withCount('chapters')
            ->where('approval_status', 'approved')
            ->orderByDesc('views')
            ->take(15)
            ->get();

        // 4. Riwayat Membaca (Jika sudah login)
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
        $novel = Novel::with(['author', 'genre', 'chapters'])->findOrFail($id);
        return view('novel.show', compact('novel'));
    }
}
