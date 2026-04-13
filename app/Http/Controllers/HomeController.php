<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home', [
            'featured'       => Novel::where('is_featured', true)->with(['author', 'genre', 'chapters'])->withCount('chapters')->first(),
            'featuredNovels' => Novel::where('is_featured', true)->with(['author', 'genre'])->get(),
            'latestNovels'   => Novel::latest()->with(['author', 'genre'])->get(),
            'popularNovels'  => Novel::orderBy('views', 'desc')->with(['author', 'genre'])->get(),
            'readingHistory' => auth()->check()
                ? auth()->user()->readingHistory()->with('chapter.novel.genre')->latest('last_read_at')->take(5)->get()
                : collect(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
