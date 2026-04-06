<?php
namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $id) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Simpan / update rating user
        Rating::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'novel_id' => $id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // 🔥 HITUNG ULANG RATING
        $novel = Novel::findOrFail($id);

        $avg   = Rating::where('novel_id', $id)->avg('rating');
        $count = Rating::where('novel_id', $id)->count();

        $novel->update([
            'rating'       => round($avg, 2),
            'total_rating' => $count,
        ]);

        return back()->with('success', 'Rating berhasil dikirim!');
    }
}
