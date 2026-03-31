<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Novel::with('author', 'genre');

        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        if ($request->genre_id) {
            $query->where('genre_id', $request->genre_id);
        }

        $novels = $query->latest()->paginate(15);
        $genres = Genre::all();

        // Stats dihitung terpisah biar akurat (tidak terpengaruh filter)
        $stats = [
            'total'     => Novel::count(),
            'pending'   => Novel::where('approval_status', 'pending')->count(),
            'published' => Novel::where('approval_status', 'published')->count(),
            'rejected'  => Novel::where('approval_status', 'rejected')->count(),
        ];

        return view('admin.novels.index', compact('novels', 'genres', 'stats'));
    }

    public function show($id)
    {
        $novel = Novel::with('author', 'genre')->findOrFail($id);
        return view('admin.novels.show', compact('novel'));
    }

    public function destroy($id)
    {
        $novel = Novel::findOrFail($id);
        $novel->delete();

        return back()->with('success', 'Novel dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);
        $request->validate([
            'approval_status' => 'required|in:pending,published,rejected',
        ]);
        $novel->approval_status = $request->approval_status;
        $novel->save();

        return redirect()->back()
            ->with('success', "Status novel '$novel->judul' berhasil diubah menjadi $novel->approval_status");
    }
}
