<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index($novel_id)
    {
        $novel = Novel::where('author_id', auth()->id())
            ->findOrFail($novel_id);

        $chapters = Chapter::where('novel_id', $novel_id)->get();

        return view('author.chapter.index', compact('novel','chapters'));
    }

    public function create($novel_id)
    {
        $novel = Novel::where('author_id', auth()->id())
            ->findOrFail($novel_id);

        return view('author.chapter.create', compact('novel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'novel_id' => 'required',
            'title'    => 'required',
            'content'  => 'required',
            'status'   => 'required'
        ]);

        Chapter::create([
            'novel_id' => $request->novel_id,
            'title'    => $request->title,
            'content'  => $request->content,
            'status'   => $request->status
        ]);

        return redirect()->route('author.chapter.index', $request->novel_id)
            ->with('success', 'Chapter berhasil ditambahkan');
    }

    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);

        // pastikan chapter milik author
        if ($chapter->novel->author_id !== auth()->id()) {
            abort(403);
        }

        return view('author.chapter.edit', compact('chapter'));
    }

    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        if ($chapter->novel->author_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status'  => 'required'
        ]);

        $chapter->update($request->only('title','content','status'));

        return back()->with('success', 'Chapter diperbarui');
    }

    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);

        if ($chapter->novel->author_id !== auth()->id()) {
            abort(403);
        }

        $chapter->delete();

        return back()->with('success', 'Chapter dihapus');
    }
}
