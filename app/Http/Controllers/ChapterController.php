<?php
namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function show($id)
    {
        $chapter = Chapter::with(['novel.author', 'novel.genre'])->findOrFail($id);

        // Hanya chapter yang dipublish
        if ($chapter->status !== 'published') {
            abort(403, 'Chapter belum tersedia.');
        }

        // Auto save riwayat baca
        if (Auth::check()) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id'    => Auth::id(),
                    'chapter_id' => $chapter->id,
                ],
                [
                    'last_read_at' => now(),
                ]
            );

            // Tambah view counter novel (throttled by session)
            $sessionKey = 'viewed_novel_' . $chapter->novel_id;
            if (! session()->has($sessionKey)) {
                $chapter->novel->increment('views');
                session([$sessionKey => true]);
            }
        }

        // Previous & next chapter
        $prevChapter = Chapter::where('novel_id', $chapter->novel_id)
            ->where('status', 'published')
            ->where('urutan', '<', $chapter->urutan)
            ->orderBy('urutan', 'desc')
            ->first();

        $nextChapter = Chapter::where('novel_id', $chapter->novel_id)
            ->where('status', 'published')
            ->where('urutan', '>', $chapter->urutan)
            ->orderBy('urutan')
            ->first();

        $totalChapters = Chapter::where('novel_id', $chapter->novel_id)
            ->where('status', 'published')
            ->count();

        // Komentar chapter
        $comments = Comment::with('user')
            ->where('chapter_id', $chapter->id)
            ->whereNull('parent_id')
            ->where('is_hidden', 0)
            ->latest()
            ->take(20)
            ->get();

        // Bookmark status
        $isBookmarked = Auth::check()
            ? Bookmark::where('user_id', Auth::id())->where('novel_id', $chapter->novel_id)->exists()
            : false;

        return view('pages.reader', compact(
            'chapter',
            'prevChapter',
            'nextChapter',
            'totalChapters',
            'comments',
            'isBookmarked'
        ));
    }
}
