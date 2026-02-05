<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    // LIST ALL GENRES
    public function index()
    {
        $genres = Genre::withCount('novels')->get();
        return view('admin.genre.index', compact('genres'));
    }

    // SHOW FORM CREATE
    public function create()
    {
        return view('admin.genre.create');
    }

    // STORE NEW GENRE
    public function store(Request $request)
    {
        $request->validate([
            'nama_genre' => 'required|unique:genres,nama_genre'
        ]);

        Genre::create([
            'nama_genre' => $request->nama_genre
        ]);

        return redirect()->route('admin.genre.index')
            ->with('success', 'Genre berhasil ditambahkan');
    }

    // SHOW FORM EDIT
    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genre.edit', compact('genre'));
    }

    // UPDATE GENRE
    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'nama_genre' => 'required|unique:genres,nama_genre,' . $genre->id
        ]);

        $genre->update([
            'nama_genre' => $request->nama_genre
        ]);

        return redirect()->route('admin.genre.index')
            ->with('success', 'Genre berhasil diperbarui');
    }

    // DELETE GENRE
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->back()->with('success', 'Genre berhasil dihapus');
    }
}
