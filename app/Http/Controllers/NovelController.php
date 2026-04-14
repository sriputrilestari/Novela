<?php
namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Novel;
use App\Models\Rating;
use App\Models\ReadingHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NovelController extends Controller
{
    // GET / (Home)
    public function home()
    {
        $publishedQuery = Novel::query()
            ->where('approval_status', 'published');
        $hasPublished = (clone $publishedQuery)->exists();
        $baseQuery    = $publishedQuery;

        $featured = (clone $baseQuery)
            ->orderByDesc('rating')
            ->orderByDesc('total_rating')
            ->orderByDesc('views')
            ->with(['author', 'genre'])
            ->withCount('chapters')
            ->first();

        // Novel Terbaru — urut dari yang terbaru dibuat (tampil kiri = grid auto-fill)
        $latestNovels = (clone $baseQuery)
            ->orderByDesc('created_at')
            ->with(['author', 'genre'])
            ->withCount('chapters')
            ->limit(20)
            ->get();

        // Novel Populer — diambil dari views terbanyak
        $popularNovels = (clone $baseQuery)
            ->with(['author', 'genre'])
            ->withCount('chapters')
            ->orderByRaw('views DESC, rating DESC, total_rating DESC, created_at DESC')
            ->limit(20)
            ->get();

        $featuredNovels = (clone $baseQuery)
            ->with(['author', 'genre'])
            ->withCount('chapters')
            ->orderByDesc('rating')
            ->orderByDesc('total_rating')
            ->orderByDesc('views')
            ->limit(20)
            ->get()
            ->when($featured, fn(Collection $items) => $items->reject(fn($novel) => $novel->id === $featured->id))
            ->values();

        // Stats user (jika login)
        $stats          = [];
        $readingHistory = collect();

        if (auth()->check()) {
            $user = auth()->user();

            $stats = [
                'novels_read'   => ReadingHistory::where('user_id', $user->id)
                    ->with('chapter')
                    ->get()
                    ->pluck('chapter.novel_id')
                    ->unique()
                    ->count(),
                'favorites'     => Bookmark::where('user_id', $user->id)->count(),
                'chapters_done' => ReadingHistory::where('user_id', $user->id)->count(),
                'comments'      => Comment::where('user_id', $user->id)->count(),
            ];

            $readingHistory = ReadingHistory::where('user_id', $user->id)
                ->with(['chapter.novel.author', 'chapter.novel.genre'])
                ->orderByDesc('last_read_at')
                ->limit(4)
                ->get();
        }

        return view('pages.home', compact(
            'featured',
            'featuredNovels',
            'latestNovels',
            'popularNovels',
            'hasPublished',
            'stats',
            'readingHistory'
        ));
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

        $userRating = Auth::check()
            ? Rating::where('user_id', Auth::id())
            ->where('novel_id', $id)
            ->value('rating')
            : null;

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
            'lastReadChapter',
            'userRating'
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
        if (! Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $novel = Novel::where('approval_status', 'published')->findOrFail($id);

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'novel_id' => $id],
            ['rating' => $request->rating]
        );

        $avg   = Rating::where('novel_id', $id)->avg('rating');
        $count = Rating::where('novel_id', $id)->count();

        $novel->update([
            'rating'       => round($avg, 2),
            'total_rating' => $count,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Rating berhasil dikirim!',
                'novel_id' => $novel->id,
                'rating'   => round($avg, 2),
                'total'    => $count,
            ]);
        }

        return back()->with('success', 'Rating berhasil dikirim!');
    }
}
