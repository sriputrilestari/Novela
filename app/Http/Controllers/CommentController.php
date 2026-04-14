<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // ================= STORE COMMENT =================
    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'komentar'   => 'required|string|max:1000',
            'parent_id'  => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'user_id'    => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'komentar'   => $request->komentar,
            'parent_id'  => $request->parent_id ?? null,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    // ================= LIKE COMMENT =================
    public function like($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->increment('likes_count');

        return back();
    }

    // ================= REPLY COMMENT =================
    public function reply(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'komentar'   => 'required|string|max:1000',
        ]);

        $parent = Comment::findOrFail($request->comment_id);

        Comment::create([
            'user_id'    => Auth::id(),
            'chapter_id' => $parent->chapter_id,
            'komentar'   => $request->komentar,
            'parent_id'  => $parent->id,
        ]);

        return back();
    }

    // ================= LIKE REPLY =================
    public function likeReply($id)
    {
        $reply = Comment::findOrFail($id);

        $reply->increment('likes_count');

        return back();
    }
}
