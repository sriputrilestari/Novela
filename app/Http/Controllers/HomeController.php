<?php
namespace App\Http\Controllers;

use App\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            // Hero → novel dengan rating tertinggi
            'featured'       => Novel::with(['author', 'genre'])
                ->withCount('chapters')
                ->where('approval_status', 'approved')
                ->orderByDesc('rating')
                ->first(),

            // Novel Terbaru
            'latestNovels'   => Novel::with(['author', 'genre'])
                ->withCount('chapters')
                ->where('approval_status', 'approved')
                ->latest()
                ->get(),

            // Novel Populer → urut by views terbanyak
            'popularNovels'  => Novel::with(['author', 'genre'])
                ->withCount('chapters')
                ->where('approval_status', 'approved')
                ->orderByDesc('views')
                ->get(),

            // Reading History
            'readingHistory' => auth()->check()
                ? auth()->user()->readingHistory()
                ->with('chapter.novel.genre')
                ->latest('last_read_at')
                ->take(5)
                ->get()
                : collect(),
        ]);
    }

    public function show($id)
    {
        $novel = Novel::findOrFail($id);
        return view('novel.show', compact('novel'));
    }
}
