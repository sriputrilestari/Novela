<?php
namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Novel;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NovelController extends Controller
{
    // GET / (Home)
    public function index()
    {
        $latestNovels = Novel::with(['author', 'genre'])
            ->where('approval_status', 'published')
            ->latest()
            ->take(12)
            ->get();

        $popularNovels = Novel::with(['author', 'genre'])
            ->where('approval_status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $stats          = [];
        $readingHistory = collect();

        if (Auth::check()) {
            $userId = Auth::id();

            $readingHistory = ReadingHistory::with(['chapter.novel.author'])
                ->where('user_id', $userId)
                ->latest('last_read_at')
                ->take(4)
                ->get();

            $stats = [
                'novels_read'   => ReadingHistory::where('user_id', $userId)
                    ->join('chapters', 'reading_history.chapter_id', '=', 'chapters.id')
                    ->distinct('chapters.novel_id')
                    ->count('chapters.novel_id'),
                'favorites'     => Bookmark::where('user_id', $userId)->count(),
                'chapters_done' => ReadingHistory::where('user_id', $userId)->count(),
                'comments'      => Comment::where('user_id', $userId)->count(),
            ];
        }

        return view('pages.home', compact('latestNovels', 'popularNovels', 'stats', 'readingHistory'));
    }

    // GET /novel/{id}  ← INI YANG PALING BANYAK MASALAHNYA
    public function show($id)
    {
        $novel = Novel::with(['author', 'genre'])
            ->where('approval_status', 'published') // tambahan keamanan
            ->findOrFail($id);

        $chapters = Chapter::where('novel_id', $id)
            ->where('status', 'published')
            ->orderBy('urutan')
            ->get();

        $firstChapter  = $chapters->first();
        $bookmarkCount = Bookmark::where('novel_id', $id)->count();
        $commentCount  = Comment::whereIn('chapter_id', $chapters->pluck('id'))->count();

        $isBookmarked = Auth::check()
            ? Bookmark::where('user_id', Auth::id())
            ->where('novel_id', $id)
            ->exists()
            : false;

        // Last read chapter for this user
        $lastReadChapter = null;
        if (Auth::check()) {
            $lastRead = ReadingHistory::where('user_id', Auth::id())
                ->whereIn('chapter_id', $chapters->pluck('id'))
                ->latest('last_read_at')
                ->first();

            $lastReadChapter = $lastRead
                ? $chapters->firstWhere('id', $lastRead->chapter_id)
                : null;
        }

        // Return ke view dengan semua data
        return view('pages.detail', compact(
            'novel',
            'chapters',
            'firstChapter',
            'bookmarkCount',
            'commentCount',
            'isBookmarked',
            'lastReadChapter'
        ));
    }

    // GET /genre/{genre_id}
    public function byGenre($genre_id)
    {
        $novels = Novel::with(['author', 'genre'])
            ->where('genre_id', $genre_id)
            ->where('approval_status', 'published')
            ->latest()
            ->paginate(12);

        $genreName = optional($novels->first()?->genre)->nama_genre ?? 'Genre Tidak Ditemukan';

        return view('pages.search', compact('novels', 'genreName'));
    }

    // GET /pencarian
    public function search(Request $request)
    {
        $query = Novel::with(['author', 'genre'])
            ->where('approval_status', 'published');

        // Search by keyword
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->q . '%')
                    ->orWhereHas('author', fn($a) => $a->where('name', 'like', '%' . $request->q . '%'))
                    ->orWhereHas('genre', fn($g) => $g->where('nama_genre', 'like', '%' . $request->q . '%'));
            });
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereHas('genre', function ($q) use ($request) {
                $q->whereRaw('LOWER(nama_genre) = ?', [strtolower($request->genre)]);
            });
        }

        $novels = $query->latest()->paginate(12);

        $genres = Genre::all();

        return view('pages.search', compact('novels', 'genres'));
    }

    // GET /genre
    public function genres()
    {
        return view('pages.genres');
    }

    // GET /favorit
    public function favorites()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $bookmarks = Bookmark::with(['novel.author', 'novel.genre'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.favorites', compact('bookmarks'));
    }

    // GET /profil
    public function profile()
    {
        return redirect()->route('reader.profile.index');
    }

    // PUT /profil
    public function updateProfile(Request $request)
    {
        return redirect()->route('reader.profile.update');
    }

    // GET /novel/{id}/baca
    public function reader($id)
    {
        $novel = Novel::where('approval_status', 'published')->findOrFail($id);

        $firstChapter = Chapter::where('novel_id', $id)
            ->where('status', 'published')
            ->orderBy('urutan')
            ->first();

        if (! $firstChapter) {
            return back()->with('error', 'Novel ini belum memiliki chapter yang dipublikasikan.');
        }

        return redirect()->route('chapter.show', $firstChapter->id);
    }

    // POST /novel/{id}/rate
    public function rate(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = (int) $request->rating;

        $total                = $novel->rating * $novel->total_rating;
        $novel->total_rating += 1;
        $novel->rating        = ($total + $rating) / $novel->total_rating;

        $novel->save();

        return back()->with('success', 'Terima kasih atas ratingnya!');
    }
}
