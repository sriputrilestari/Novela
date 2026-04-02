<?php
namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Novel;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function home()
    {
        $latest  = Novel::latest()->take(6)->get();
        $popular = Novel::inRandomOrder()->take(6)->get();

        return view('reader.home', compact('latest', 'popular'));
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $novels = Novel::where('judul', 'like', "%$q%")->get();

        return view('reader.search', compact('novels', 'q'));
    }

    public function genre($id)
    {
        $genre  = Genre::findOrFail($id);
        $novels = Novel::where('genre_id', $id)->get();

        return view('reader.genre', compact('genre', 'novels'));
    }

    public function detail($id)
    {
        $novel = Novel::with('chapters')->findOrFail($id);

        return view('reader.detail', compact('novel'));
    }

    public function read($id)
    {
        $chapter = Chapter::findOrFail($id);

        return view('reader.read', compact('chapter'));
    }
}
