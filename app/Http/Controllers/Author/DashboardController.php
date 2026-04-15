<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $authorId = Auth::id();

        // ════════════════════════════════════════════════════════
        // 1. DATA UTAMA  (variabel yang sudah ada di blade lama)
        // ════════════════════════════════════════════════════════

        // Total novel milik author (Novel pakai kolom author_id)
        $totalNovel = Novel::where('author_id', $authorId)->count();

        // Novel yang belum disetujui admin
        $novelPending = Novel::where('author_id', $authorId)
                             ->where('approval_status', 'pending')
                             ->count();

        // Total chapter dari semua novel milik author
        $novelIds   = Novel::where('author_id', $authorId)->pluck('id');
        $totalChapter = Chapter::whereIn('novel_id', $novelIds)->count();

        // Total views — kolom views ada di tabel novels (bukan chapters)
        $totalView = Novel::where('author_id', $authorId)->sum('views');

        // ════════════════════════════════════════════════════════
        // 2. STATUS NOVEL
        // ════════════════════════════════════════════════════════

        $publishedNovel = Novel::where('author_id', $authorId)
                               ->where('approval_status', 'published')
                               ->count();

        $rejectedNovel  = Novel::where('author_id', $authorId)
                               ->where('approval_status', 'rejected')
                               ->count();

        // ════════════════════════════════════════════════════════
        // 3. KOMENTAR
        // Comment: chapter_id, parent_id (NULL = komentar utama)
        // ════════════════════════════════════════════════════════

        $chapterIds = Chapter::whereIn('novel_id', $novelIds)->pluck('id');

        // Total komentar utama
        $totalComments = Comment::whereIn('chapter_id', $chapterIds)
                                ->whereNull('parent_id')
                                ->count();

        // Komentar baru dalam 24 jam terakhir
        $newComments = Comment::whereIn('chapter_id', $chapterIds)
                              ->whereNull('parent_id')
                              ->where('created_at', '>=', Carbon::now()->subDay())
                              ->count();

        // ════════════════════════════════════════════════════════
        // 4. CHART  —  Views 7 hari terakhir
        //    Karena views adalah nilai kumulatif di novels.views,
        //    kita pakai views dari novel yang di-update hari itu
        // ════════════════════════════════════════════════════════

        $chartLabels = [];
        $chartData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date          = Carbon::now()->subDays($i);
            $chartLabels[] = $date->locale('id')->isoFormat('ddd, D MMM');
            $chartData[]   = (int) Novel::where('author_id', $authorId)
                                        ->whereDate('updated_at', $date->toDateString())
                                        ->sum('views');
        }

        // ════════════════════════════════════════════════════════
        // 6. NOVEL TERBARU  (5 novel, untuk daftar di dashboard)
        // ════════════════════════════════════════════════════════

        $recentNovels = Novel::where('author_id', $authorId)
                             ->with('genre')
                             ->latest()
                             ->take(5)
                             ->get();

        // ════════════════════════════════════════════════════════
        // 7. AKTIVITAS TERBARU
        //    Gabungan komentar + chapter + novel terbaru
        // ════════════════════════════════════════════════════════

        $recentActivities = collect();

        // — Komentar terbaru di novel milik author —
        Comment::whereIn('chapter_id', $chapterIds)
               ->whereNull('parent_id')
               ->with(['user', 'chapter.novel'])
               ->latest()
               ->take(4)
               ->get()
               ->each(function ($comment) use (&$recentActivities) {
                   $recentActivities->push([
                       'icon'  => '💬',
                       'bg'    => '#eef0fe',
                       'color' => '#3d5af1',
                       'text'  => '<b>' . e($comment->user->name) . '</b> mengomentari chapter <b>'
                                  . e($comment->chapter->judul_chapter) . '</b>',
                       'time'  => $comment->created_at->diffForHumans(),
                       'sort'  => $comment->created_at,
                   ]);
               });

        // — Chapter terbaru yang ditambahkan —
        Chapter::whereIn('novel_id', $novelIds)
               ->with('novel')
               ->latest()
               ->take(3)
               ->get()
               ->each(function ($chapter) use (&$recentActivities) {
                   $recentActivities->push([
                       'icon'  => '📄',
                       'bg'    => '#e0faf5',
                       'color' => '#00a88a',
                       'text'  => 'Chapter baru <b>' . e($chapter->judul_chapter) . '</b> ditambahkan ke <b>'
                                  . e($chapter->novel->judul) . '</b>',
                       'time'  => $chapter->created_at->diffForHumans(),
                       'sort'  => $chapter->created_at,
                   ]);
               });

        // — Novel terbaru yang dibuat —
        Novel::where('author_id', $authorId)
             ->latest()
             ->take(2)
             ->get()
             ->each(function ($novel) use (&$recentActivities) {
                 $recentActivities->push([
                     'icon'  => '📚',
                     'bg'    => '#f5f0fe',
                     'color' => '#9333ea',
                     'text'  => 'Novel <b>' . e($novel->judul) . '</b> berhasil dibuat',
                     'time'  => $novel->created_at->diffForHumans(),
                     'sort'  => $novel->created_at,
                 ]);
             });

        // Urutkan terbaru dulu, ambil 6 item
        $recentActivities = $recentActivities
            ->sortByDesc('sort')
            ->take(6)
            ->values();

        // ════════════════════════════════════════════════════════
        // 8. RETURN KE VIEW
        // ════════════════════════════════════════════════════════

        return view('author.dashboard', compact(
            // — data utama —
            'totalNovel',
            'novelPending',
            'totalChapter',
            'totalView',
            // — status —
            'publishedNovel',
            'rejectedNovel',
            // — komentar —
            'newComments',
            // — chart —
            'chartLabels',
            'chartData',
            // — list & feed —
            'recentNovels',
            'recentActivities',
        ));
    }
}