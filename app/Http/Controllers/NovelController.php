<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Genre;

class NovelController extends Controller
{
    // halaman daftar novel
    public function index()
    {
        $novels = Novel::with('genre')->latest()->get();
        return view('novels.index', compact('novels'));
    }

    // detail novel + chapter
    public function show($id)
    {
        $novel = Novel::with(['genre', 'chapters'])->findOrFail($id);
        return view('novels.show', compact('novel'));
    }

    // filter novel per genre
    public function byGenre($genre_id)
    {
        $novels = Novel::where('genre_id', $genre_id)->get();
        return view('novels.index', compact('novels'));
    }
}
