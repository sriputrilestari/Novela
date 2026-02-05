<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    // baca chapter
    public function show($id)
    {
        $chapter = Chapter::with('novel')->findOrFail($id);

        // simpan riwayat baca
        if (Auth::check()) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'chapter_id' => $chapter->id
                ],
                [
                    'last_read_at' => now()
                ]
            );
        }

        return view('chapters.show', compact('chapter'));
    }
}
