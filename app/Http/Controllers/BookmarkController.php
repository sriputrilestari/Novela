<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggle($novel_id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('novel_id', $novel_id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Bookmark dihapus');
        }

        Bookmark::create([
            'user_id' => Auth::id(),
            'novel_id' => $novel_id
        ]);

        return back()->with('success', 'Novel dibookmark');
    }
}
