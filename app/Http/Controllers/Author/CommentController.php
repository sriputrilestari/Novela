<?php
// ============================================================
// FILE: app/Http/Controllers/Author/CommentController.php
// ============================================================

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // ──────────────────────────────────────────────────────────
    // INDEX — Daftar semua komentar novel milik author
    // GET /author/comments?filter=all|toxic
    // ──────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = Comment::whereNull('parent_id')
            ->whereHas('chapter.novel', fn($q) => $q->where('author_id', Auth::id()))
            ->with([
                'user',
                'chapter.novel',
                'replies.user',
            ])
            ->latest();

        if ($filter === 'toxic') {
            $query->where('is_toxic', true);
        }
        // 'all' → tampilkan semua (termasuk yang hidden), ini panel author

        $comments   = $query->paginate(10)->withQueryString();
        $totalAll   = $this->countFilter('all');
        $totalToxic = $this->countFilter('toxic');

        return view('author.comment.index', compact(
            'comments', 'filter', 'totalAll', 'totalToxic'
        ));
    }

    // ──────────────────────────────────────────────────────────
    // SHOW — Detail 1 komentar + semua reply-nya
    // GET /author/comments/{id}
    // ──────────────────────────────────────────────────────────
    // public function show($id)
    // {
    //     $comment = Comment::with(['user', 'chapter.novel', 'replies.user'])
    //         ->findOrFail($id);

    //     // VALIDASI
    //     if ($comment->chapter->novel->author_id !== Auth::id()) {
    //         abort(403, 'Ini bukan komentar milik kamu');
    //     }

    //     return view('author.comment.show', compact('comment'));
    // }

    // ──────────────────────────────────────────────────────────
    // REPLY — Author balas komentar reader
    // POST /author/comments/{id}/reply
    // ──────────────────────────────────────────────────────────
    public function reply(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $parent = Comment::with('chapter.novel')->findOrFail($id);
        $this->gate($parent);

        Comment::create([
            'user_id'    => Auth::id(),
            'chapter_id' => $parent->chapter_id,
            'komentar'   => $request->komentar,
            'parent_id'  => $parent->id,
            'is_hidden'  => false,
            'is_toxic'   => false,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    // ──────────────────────────────────────────────────────────
    // MARK TOXIC — Tandai komentar toxic, otomatis disembunyikan
    // PATCH /author/comments/{id}/toxic
    // ──────────────────────────────────────────────────────────
    public function markToxic($id)
    {
        $comment = Comment::with('chapter.novel')->findOrFail($id);
        $this->gate($comment);

        $comment->update([
            'is_toxic'      => true,
            'is_hidden'     => true,
            'hidden_reason' => 'Ditandai toxic oleh author',
        ]);

        // Sembunyikan semua reply-nya juga
        Comment::where('parent_id', $id)->update([
            'is_hidden'     => true,
            'hidden_reason' => 'Parent komentar ditandai toxic',
        ]);

        return back()->with('success', 'Komentar berhasil ditandai sebagai toxic.');
    }

    // ──────────────────────────────────────────────────────────
    // DESTROY — Hapus komentar permanen beserta semua reply-nya
    // DELETE /author/comments/{id}
    // ──────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $comment = Comment::with(['chapter.novel', 'replies'])->findOrFail($id);
        $this->gate($comment);

        // Hapus semua reply dulu supaya tidak orphan
        Comment::where('parent_id', $id)->delete();
        $comment->delete();

        return back()->with('success', 'Komentar dan semua balasannya berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // Private Helpers
    // ──────────────────────────────────────────────────────────

    /** Pastikan komentar milik novel author yang sedang login */
    private function gate(Comment $comment): void
    {
        if ($comment->chapter->novel->author_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }

    /** Hitung komentar berdasarkan filter untuk badge counter */
    private function countFilter(string $filter): int
    {
        $q = Comment::whereNull('parent_id')
            ->whereHas('chapter.novel', fn($q) => $q->where('author_id', Auth::id()));

        if ($filter === 'toxic') {
            $q->where('is_toxic', true);
        }

        return $q->count();
    }
}
