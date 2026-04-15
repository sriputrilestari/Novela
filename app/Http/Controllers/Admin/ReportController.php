<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'novel.author'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total'    => Report::count(),
            'pending'  => Report::where('status', 'pending')->count(),
            'reviewed' => Report::where('status', 'reviewed')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.index', compact('reports', 'stats'));
    }

    public function show(Report $report)
    {
        $report->load(['user', 'novel.author']);
        return view('admin.reports.show', compact('report'));
    }

    // Tandai sudah direview
    public function review(Report $report)
    {
        $report->update(['status' => 'reviewed']);
        return back()->with('success', 'Laporan ditandai sudah direview.');
    }

    // Tolak laporan
    public function reject(Request $request, Report $report)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $report->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Laporan berhasil ditolak.');
    }

    // Beri peringatan ke author (simpan catatan, novel tetap ada)
    public function warn(Request $request, Report $report)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $report->update([
            'status'        => 'reviewed',
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Opsional: kirim notifikasi/email ke author di sini
        // Mail::to($report->novel->author->email)->send(new AuthorWarningMail($report));

        return back()->with('success', 'Peringatan berhasil dikirim ke author.');
    }

    // Hapus novel yang dilaporkan
    public function deleteNovel(Report $report)
    {
        $novel = $report->novel;

        if ($novel) {
            // Tandai semua laporan terkait novel ini sebagai reviewed
            Report::where('novel_id', $novel->id)
                ->update(['status' => 'reviewed', 'catatan_admin' => 'Novel dihapus oleh admin.']);

            $novel->delete();
        }

        return back()->with('success', 'Novel berhasil dihapus dan semua laporan terkait ditutup.');
    }
}
