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
            'chapter_id' => 'required',
            'komentar' => 'required'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'komentar' => $request->komentar
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
}
