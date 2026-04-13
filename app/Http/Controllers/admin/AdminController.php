<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalNovel  = Novel::count();
        $totalAuthor = User::where('role', 'author')->count();
        $totalReader = User::where('role', 'reader')->count();

        $novelPending = Novel::where('approval_status', 'pending')->count();

        $pendingNovels = Novel::where('approval_status', 'pending')
            ->with('author')
            ->latest()
            ->limit(10)
            ->get();

        $publishedNovel = Novel::where('approval_status', 'published')->count();

        $topReaders = User::where('role', 'reader')
            ->withCount('readingHistories')
            ->orderBy('reading_histories_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalNovel',
            'totalAuthor',
            'totalReader',
            'novelPending',
            'pendingNovels',
            'publishedNovel',
            'topReaders'
        ));
    }
}
