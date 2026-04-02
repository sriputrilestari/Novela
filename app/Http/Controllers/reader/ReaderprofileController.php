<?php
namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'novels_read'   => ReadingHistory::where('user_id', $user->id)
                ->distinct('chapter_id')
                ->join('chapters', 'reading_histories.chapter_id', '=', 'chapters.id')
                ->distinct('chapters.novel_id')
                ->count('chapters.novel_id'),
            'chapters_done' => ReadingHistory::where('user_id', $user->id)->count(),
            'favorites'     => Bookmark::where('user_id', $user->id)->count(),
            'comments'      => \App\Models\Comment::where('user_id', $user->id)->count(),
        ];

        return view('pages.profile', compact('user', 'stats'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio'   => 'nullable|string|max:500',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'bio'   => $request->bio,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
