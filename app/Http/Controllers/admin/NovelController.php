<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Novel;
use App\Models\Genre;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Novel::with('author', 'genre');

        if ($request->status) $query->where('approval_status', $request->status);
        if ($request->genre_id) $query->where('genre_id', $request->genre_id);

        $novels = $query->latest()->get();
        $genres = Genre::all();

        return view('admin.novels.index', compact('novels', 'genres'));
    }

    public function show($id)
    {
        $novel = Novel::with('author','genre')->findOrFail($id);
        return view('admin.novels.show', compact('novel'));
    }

    public function update(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);

        $request->validate([
            'judul'           => 'required|string|max:255',
            'genre_id'        => 'required|exists:genres,id',
            'sinopsis'        => 'required',
            'approval_status' => 'required|in:pending,published,rejected'
        ]);

        $novel->update($request->only('judul','genre_id','sinopsis','approval_status'));

        return redirect()->route('admin.novels.index')
            ->with('success','Novel berhasil diperbarui');
    }

    public function destroy($id)
    {
        $novel = Novel::findOrFail($id);
        $novel->delete();

        return back()->with('success','Novel dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);
        $request->validate([
            'approval_status' => 'required|in:pending,published,rejected'
        ]);
        $novel->approval_status = $request->approval_status;
        $novel->save();

        return redirect()->back()
            ->with('success', "Status novel '$novel->judul' berhasil diubah menjadi $novel->approval_status");
    }
}