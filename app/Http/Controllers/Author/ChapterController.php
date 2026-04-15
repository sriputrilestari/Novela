<?php
namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    // =====================
    // LIST CHAPTER PER NOVEL
    // =====================
    public function index(Novel $novel)
    {
        $this->checkOwner($novel);

        $chapters  = $novel->chapters()->orderBy('urutan')->get();
        $total     = $chapters->count();
        $published = $chapters->where('status', 'published')->count();
        $draft     = $chapters->where('status', 'draft')->count();

        return view('author.chapter.index', compact(
            'novel', 'chapters', 'total', 'published', 'draft'
        ));
    }

    // =====================
    // FORM CREATE
    // =====================
    public function create(Novel $novel)
    {
        $this->checkOwner($novel);
        return view('author.chapter.create', compact('novel'));
    }

    // =====================
    // STORE CHAPTER
    // =====================
    public function store(Request $request, Novel $novel)
    {
        $this->checkOwner($novel);

        $request->validate([
            'urutan'  => 'required|integer|min:1',
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
        ]);

        $novel->chapters()->create([
            'urutan'        => $request->urutan,
            'judul_chapter' => $request->title,
            'isi'           => $request->content, // simpan mentah
            'status'        => $request->status,
        ]);

        return redirect()->route('author.chapter.index', $novel->id)
            ->with('success', 'Chapter berhasil ditambahkan.');
    }

    // =====================
    // FORM EDIT
    // =====================
    public function edit(Novel $novel, Chapter $chapter)
    {
        $this->checkOwner($novel);
        $this->checkChapter($novel, $chapter);

        return view('author.chapter.edit', compact('novel', 'chapter'));
    }

    // =====================
    // UPDATE CHAPTER
    // =====================
    public function update(Request $request, Novel $novel, Chapter $chapter) {
        $this->checkOwner($novel);
        $this->checkChapter($novel, $chapter);

        // validasi
        $validated = $request->validate([
            'urutan'  => 'required|integer|min:1',
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
        ]);

        // update
        $chapter->update([
            'urutan'        => $validated['urutan'],
            'judul_chapter' => $validated['title'],
            'isi'           => $validated['content'],
            'status'        => $validated['status'],
        ]);

        return redirect()->route('author.chapter.index', $novel->id)
            ->with('success', 'Chapter berhasil diupdate.');
    }

    // =====================
    // SHOW CHAPTER
    // =====================
    public function show(Novel $novel, Chapter $chapter)
    {
        $this->checkOwner($novel);
        $this->checkChapter($novel, $chapter);

        return view('author.chapter.show', compact('novel', 'chapter'));
    }

    // =====================
    // DELETE CHAPTER
    // =====================
    public function destroy(Novel $novel, Chapter $chapter)
    {
        $this->checkOwner($novel);
        $this->checkChapter($novel, $chapter);

        $chapter->delete();

        return back()->with('success', 'Chapter berhasil dihapus.');
    }

    // =====================
    // TOGGLE STATUS
    // =====================
    public function toggle(Novel $novel, Chapter $chapter)
    {
        $this->checkOwner($novel);
        $this->checkChapter($novel, $chapter);

        $chapter->status = $chapter->status === 'draft' ? 'published' : 'draft';
        $chapter->save();

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    // =====================
    // HELPERS
    // =====================
    private function checkOwner(Novel $novel)
    {
        if ($novel->author_id !== Auth::id()) {
            abort(403, 'This action is unauthorized.');
        }
    }

    private function checkChapter(Novel $novel, Chapter $chapter)
    {
        if ($chapter->novel_id !== $novel->id) {
            abort(403, 'This chapter does not belong to this novel.');
        }
    }
}
