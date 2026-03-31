<?php
// ============================================================
// FILE: app/Http/Controllers/Reader/ReportController.php
// Buat folder Reader dulu jika belum ada.
// ============================================================

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\NovelReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // ──────────────────────────────────────────────────────────
    // STORE — Reader kirim laporan novel
    // POST /novels/{novel_id}/report
    // ──────────────────────────────────────────────────────────
    public function store(Request $request, $novelId)
    {
        $request->validate([
            'alasan'     => 'required|in:konten_dewasa,ujaran_kebencian,spam,plagiarisme,kekerasan,lainnya',
            'deskripsi'  => 'nullable|string|max:1000',
            'comment_id' => 'nullable|exists:comments,id',
        ]);

        $novel = Novel::findOrFail($novelId);

        // ── Cek 1: Reader tidak bisa report novel milik dirinya sendiri ──
        if ($novel->author_id === Auth::id()) {
            return back()->with('error', 'Kamu tidak dapat melaporkan novel milik sendiri.');
        }

        // ── Cek 2: Novel ini sudah pernah dilaporkan oleh user ini ──
        $sudahReport = NovelReport::where('user_id', Auth::id())
            ->where('novel_id', $novelId)
            ->exists();

        if ($sudahReport) {
            return back()->with('error', 'Kamu sudah pernah melaporkan novel ini sebelumnya.');
        }

        // ── Cek 3: Rate limit — max 2 novel berbeda per 7 hari ──
        if (NovelReport::reachedWeeklyLimit(Auth::id())) {
            $resetAt  = NovelReport::quotaResetsAt(Auth::id());
            $resetStr = $resetAt ? $resetAt->translatedFormat('d F Y, H:i') : '-';

            return back()->with('error',
                "Kamu sudah melaporkan 2 novel dalam 7 hari terakhir. " .
                "Kuota reset pada: {$resetStr}."
            );
        }

        // ── Simpan laporan ──
        NovelReport::create([
            'user_id'    => Auth::id(),
            'novel_id'   => $novelId,
            'comment_id' => $request->comment_id,
            'alasan'     => $request->alasan,
            'deskripsi'  => $request->deskripsi,
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Laporan kamu berhasil dikirim. Terima kasih!');
    }
}
