<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Auth;

class ReadingHistoryController extends Controller
{
    public function index()
    {
        $histories = ReadingHistory::with('chapter.novel')
            ->where('user_id', Auth::id())
            ->latest('last_read_at')
            ->get();

        return view('history.index', compact('histories'));
    }
}
