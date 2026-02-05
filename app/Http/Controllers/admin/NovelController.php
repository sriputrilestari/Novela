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

        //FILTER STATUS
        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        // Filter genre
        if ($request->genre_id) {
            $query->where('genre_id', $request->genre_id);
        }

        $novels = $query->latest()->get();
        $genres = Genre::all();

       return view('admin.novels.index', compact('novels', 'genres'));
    }

    public function edit($id)
    {
        $novel  = Novel::findOrFail($id);
        $genres = Genre::all();

        return view('admin.novels.edit', compact('novel','genres'));
    }

    public function update(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);

        $novel->update([
            'title'       => $request->title,
            'genre_id'    => $request->genre_id,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.novels.index')
            ->with('success','Novel berhasil diperbarui');
    }

    public function destroy($id)
    {
        Novel::findOrFail($id)->delete();

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

    return redirect()->back()->with('success', "Status novel '$novel->judul' berhasil diubah menjadi " . ucfirst($novel->approval_status));
}

}
