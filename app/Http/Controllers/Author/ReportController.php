<?php
// app/Http/Controllers/Author/ReportController.php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Report; // ✅ ganti dari NovelReport
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    { $novelIds = Novel::where('author_id', Auth::id())->pluck('id');

        $reports = Report::with(['novel', 'user', 'chapter', 'comment'])
            ->whereIn('novel_id', $novelIds)
            ->latest()
            ->paginate(15);

        $stats = [
            'total'    => Report::whereIn('novel_id', $novelIds)->count(),
            'pending'  => Report::whereIn('novel_id', $novelIds)->where('status', 'pending')->count(),
            'reviewed' => Report::whereIn('novel_id', $novelIds)->where('status', 'reviewed')->count(),
            'rejected' => Report::whereIn('novel_id', $novelIds)->where('status', 'rejected')->count(),
        ];

        return view('author.report.index', compact('reports', 'stats'));}

    public function show($id)
    {
        $novelIds = Novel::where('author_id', Auth::id())->pluck('id');

        $report = Report::with(['novel', 'user', 'comment'])
            ->whereIn('novel_id', $novelIds)
            ->findOrFail($id);

        return view('author.report.show', compact('report'));
    }
}
