<?php
namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NovelController extends Controller
{
    public function index(Request $request) {
        $query = Novel::with('genre')->where('author_id', auth()->id());

        // FILTER STATUS CERITA
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // FILTER APPROVAL
        if ($request->approval) {
            $query->where('approval_status', $request->approval);
        }

        // FILTER GENRE
        if ($request->genre) {
            $query->where('genre_id', $request->genre);
        }

       $novels = $query->withCount(['bookmarks', 'chapters'])->latest()->get();

        $genres = Genre::all();

        return view('author.novel.index', compact('novels', 'genres'));
    }

    public function create()
    {
        $genres = Genre::orderBy('nama_genre')->get();
        return view('author.novel.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'sinopsis' => 'required',
            'status'   => 'required|in:ongoing,completed',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = $request->file('cover') ? $request->file('cover')->store('covers', 'public') : null;

        Novel::create([
            'author_id'       => Auth::id(),
            'genre_id'        => $request->genre_id,
            'judul'           => $request->judul,
            'sinopsis'        => $request->sinopsis,
            'status'          => $request->status,
            'cover'           => $coverPath,
            'approval_status' => 'pending',
        ]);

        return redirect()->route('author.novel.index')
            ->with('success', 'Novel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $novel  = Novel::where('author_id', Auth::id())->findOrFail($id);
        $genres = Genre::orderBy('nama_genre')->get();
        return view('author.novel.edit', compact('novel', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $novel = Novel::where('author_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'sinopsis' => 'required',
            'status'   => 'required|in:ongoing,completed',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'judul'    => $request->judul,
            'genre_id' => $request->genre_id,
            'sinopsis' => $request->sinopsis,
            'status'   => $request->status,
        ];

        if ($request->hasFile('cover')) {
            if ($novel->cover) {
                Storage::disk('public')->delete($novel->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $novel->update($data);

        return redirect()->route('author.novel.index')
            ->with('success', 'Novel berhasil diupdate');
    }

    public function destroy(Novel $novel)
    {
        if ($novel->author_id !== Auth::id()) {
            abort(403);
        }

        if ($novel->cover) {
            Storage::disk('public')->delete($novel->cover);
        }

        $novel->delete();

        return redirect()->route('author.novel.index')
            ->with('success', 'Novel berhasil dihapus');
    }
}
