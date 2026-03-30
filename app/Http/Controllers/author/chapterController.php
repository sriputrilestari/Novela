<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    // LIST CHAPTER PER NOVEL
   public function index($novel_id)
{
    $novel = Novel::where('id', $novel_id)
        ->where('author_id', Auth::id())
        ->firstOrFail();

    $chapters = $novel->chapters()->orderBy('urutan')->get();

    $total = $chapters->count();
    $published = $chapters->where('status','published')->count();
    $draft = $chapters->where('status','draft')->count();

    return view('author.chapter.index', compact(
        'novel','chapters','total','published','draft'
    ));
}

    // FORM CREATE
    public function create($novel_id)
    {
        $novel = Novel::where('id', $novel_id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        return view('author.chapter.create', compact('novel'));
    }

    // STORE
    public function store(Request $request, $novel_id)
    {
        $novel = Novel::where('id', $novel_id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'urutan'  => 'required|integer|min:1',
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        $novel->chapters()->create([
            'urutan'        => $request->urutan,
            'judul_chapter' => $request->title,
            'isi'           => $request->content,
            'status'        => 'draft',
        ]);

        return redirect()->route('author.chapter.index', $novel->id)
            ->with('success', 'Chapter berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit(Novel $novel, Chapter $chapter)
    {
        if ($novel->author_id !== Auth::id()) abort(403);

        return view('author.chapter.edit', compact('novel','chapter'));
    }

    // UPDATE
    public function update(Request $request, $novel_id, $id)
    {
        $novel = Novel::where('id', $novel_id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $chapter = Chapter::where('id', $id)
            ->where('novel_id', $novel->id)
            ->firstOrFail();

        $request->validate([
            'urutan'  => 'required|integer|min:1',
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        $chapter->update([
            'urutan'        => $request->urutan,
            'judul_chapter' => $request->title,
            'isi'           => $request->content,
            'status'        => $chapter->status ?? 'draft',
        ]);

        return redirect()->route('author.chapter.index', $novel->id)
            ->with('success', 'Chapter berhasil diupdate.');
    }

    // SHOW
    public function show($novel_id, $id)
    {
        $novel = Novel::where('id', $novel_id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $chapter = Chapter::where('id', $id)
            ->where('novel_id', $novel->id)
            ->firstOrFail();

        return view('author.chapter.show', compact('novel', 'chapter'));
    }

    // DELETE
    public function destroy($novel_id, $id)
    {
        $chapter = Chapter::whereHas('novel', function ($q) {
            $q->where('author_id', Auth::id());
        })->findOrFail($id);

        $chapter->delete();

        return back()->with('success', 'Chapter berhasil dihapus');
    }

    // TOGGLE STATUS
    public function toggle($novel_id, $id)
    {
        $novel = Novel::where('id', $novel_id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $chapter = Chapter::where('id', $id)
            ->where('novel_id', $novel->id)
            ->firstOrFail();

        $chapter->status = $chapter->status === 'draft' ? 'published' : 'draft';
        $chapter->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}