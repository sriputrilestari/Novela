<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $authorId = Auth::id();

        $totalNovel = Novel::where('user_id', $authorId)->count();

        $novelPending = Novel::where('user_id', $authorId)
            ->where('approval_status', 'pending')
            ->count();

        $totalChapter = Chapter::whereHas('novel', function ($q) use ($authorId) {
            $q->where('user_id', $authorId);
        })->count();

        $totalView = Novel::where('user_id', $authorId)->sum('views');

        return view('author.dashboard', compact(
            'totalNovel',
            'novelPending',
            'totalChapter',
            'totalView'
        ));
    }
}
