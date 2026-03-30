<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request; // <- wajib supaya method reply bisa jalan
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Tampilkan semua komentar untuk chapter novel milik author login
     */
    public function index()
    {
        $comments = Comment::whereNull('parent_id') // hanya komentar utama
            ->whereHas('chapter.novel', fn($q) => $q->where('author_id', Auth::id()))
            ->with([
                'user',            // info pembaca
                'chapter',
                'replies.user'     // balasan komentar beserta usernya
            ])
            ->latest()  // urut dari terbaru
            ->paginate(5);

        return view('author.comment.index', compact('comments'));
    }

    /**
     * Balas komentar pembaca
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $parent = Comment::with('chapter.novel')->findOrFail($id);

        // pastikan komentar termasuk novel milik author login
        if ($parent->chapter->novel->author_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk membalas komentar ini.');
        }

        Comment::create([
            'user_id'    => Auth::id(),       // author
            'chapter_id' => $parent->chapter_id,
            'komentar'   => $request->komentar,
            'parent_id'  => $parent->id,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function show($id)
    {
        $comment = Comment::with([
            'user',
            'chapter.novel',
            'replies.user'
        ])->findOrFail($id);

        // pastikan ini milik author login
        if ($comment->chapter->novel->author_id !== auth()->id()) {
            abort(403);
        }

        return view('author.comment.show', compact('comment'));
    }

    /**
     * Hapus komentar
     */
    public function destroy($id)
    {
        $comment = Comment::with('chapter.novel')->findOrFail($id);

        // pastikan komentar termasuk novel milik author login
        if ($comment->chapter->novel->author_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus komentar ini.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}