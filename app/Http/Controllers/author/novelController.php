<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NovelController extends Controller
{
    public function index()
    {
        $novels = Novel::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('author.novel.index', compact('novels'));
    }

   public function create()
    {
        $genres = Genre::orderBy('nama_genre', 'asc')->get();
        return view('author.novel.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'genre_id'  => 'required',
            'sinopsis'  => 'required',
            'penulis'   => 'required',
            'status'    => 'required',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = null;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Novel::create([
            'user_id'         => Auth::id(),
            'genre_id'        => $request->genre_id,
            'judul'           => $request->judul,
            'sinopsis'        => $request->sinopsis,
            'penulis'         => $request->penulis,
            'status'          => $request->status,
            'cover'           => $coverPath,
            'approval_status' => 'pending',
        ]);

        return redirect()
            ->route('author.novel.index')
            ->with('success', 'Novel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $novel  = Novel::where('user_id', Auth::id())->findOrFail($id);
        $genres = Genre::all();

        return view('author.novel.edit', compact('novel', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $novel = Novel::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul'    => 'required',
            'genre_id' => 'required',
            'sinopsis' => 'required',
            'penulis'  => 'required',
            'status'   => 'required',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($novel->cover) {
                Storage::disk('public')->delete($novel->cover);
            }

            $novel->cover = $request->file('cover')->store('covers', 'public');
        }

        $novel->update($request->except('cover'));

        return redirect()
            ->route('author.novel.index')
            ->with('success', 'Novel berhasil diupdate');
    }
}
