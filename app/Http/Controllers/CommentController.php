<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
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
            'parent_id'  => $request->parent_id ?? null, // 🔥 INI KUNCI
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
}
