<?php
// app/Http/Controllers/Author/ReportController.php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\NovelReport;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Daftar semua report masuk ke semua novel milik author
    public function index()
    {
        $novels = Novel::where('author_id', Auth::id())->pluck('id');

        $reports = NovelReport::with(['novel', 'user'])
            ->whereIn('novel_id', $novels)
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => NovelReport::whereIn('novel_id', $novels)->count(),
            'pending' => NovelReport::whereIn('novel_id', $novels)->where('status', 'pending')->count(),
            'ditinjau' => NovelReport::whereIn('novel_id', $novels)->where('status', 'ditinjau')->count(),
            'selesai' => NovelReport::whereIn('novel_id', $novels)->where('status', 'selesai')->count(),
            'ditolak' => NovelReport::whereIn('novel_id', $novels)->where('status', 'ditolak')->count(),
        ];

        // Bookmark count per novel
        $novelStats = Novel::where('author_id', Auth::id())
            ->withCount(['chapters', 'bookmarks'])
            ->get();

        return view('author.report.index', compact('reports', 'stats', 'novelStats'));
    }

    // Detail 1 report
    public function show($id)
    {
        $novels = Novel::where('author_id', Auth::id())->pluck('id');
        $report = NovelReport::with(['novel', 'user', 'comment'])
            ->whereIn('novel_id', $novels)
            ->findOrFail($id);

        return view('author.report.show', compact('report'));
    }
}
