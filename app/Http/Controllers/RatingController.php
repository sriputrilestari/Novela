<?php
namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $id)
    {
        Rating::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'novel_id' => $id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return back()->with('success', 'Rating berhasil dikirim!');
    }
}
