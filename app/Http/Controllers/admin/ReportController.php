<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user','novel'])
            ->latest()
            ->get();

        $topReaders = User::where('role','user')
            ->withCount('readingHistories')
            ->orderBy('reading_histories_count','desc')
            ->take(5)
            ->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function updateStatus($id, $status)
    {
        $report = Report::findOrFail($id);
        $report->status = $status;
        $report->save();

        return back()->with('success', 'Status laporan diperbarui');
    }
}
