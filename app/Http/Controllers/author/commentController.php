<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::whereHas('novel', function ($q) {
            $q->where('author_id', auth()->id());
        })->with(['user','novel'])->latest()->get();

        return view('author.comment.index', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->novel->author_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar dihapus');
    }
}
