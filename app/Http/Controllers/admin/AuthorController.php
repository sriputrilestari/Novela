<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);   
    }

    // 1. Index
    public function index()
    {
        $authors = User::where('role', 'author')
                    ->withCount('novels')
                    ->paginate(10); // 10 data per halaman

                    // Statistik untuk dashboard / cards di atas tabel
    $totalAuthor   = User::where('role', 'author')->count();
    $activeAuthor  = User::where('role', 'author')->where('is_active', true)->count();
    $blockedAuthor = User::where('role', 'author')->where('is_blocked', true)->count();

    // Kirim ke view
    return view('admin.author.index', compact(
        'authors',
        'totalAuthor',
        'activeAuthor',
        'blockedAuthor'
    ));
                    
        return view('admin.author.index', compact('authors'));
    }

    // 2. Aktif / Nonaktif
    public function toggle($id)
    {
        $author = User::where('role','author')->findOrFail($id);
        $author->is_active = !$author->is_active;
        $author->save();

        return redirect()->back()->with('success', 'Status author berhasil diubah.');
    }

    // 3. Blokir
    public function block($id)
    {
        $author = User::where('role','author')->findOrFail($id);
        $author->is_blocked = true;
        $author->save();

        return redirect()->back()->with('success', 'Author berhasil diblokir.');
    }

    // 4. Hapus
    public function destroy($id)
    {
        $author = User::where('role','author')->findOrFail($id);

        // optional: cek dulu kalau author masih punya novel
        if($author->novels()->count() > 0){
            return redirect()->back()->with('error', 'Author masih punya novel, hapus novel dulu.');
        }

        $author->delete();
        return redirect()->back()->with('success', 'Author berhasil dihapus.');
    }

    //show
        public function show($id)
    {
        $author = User::where('role', 'author')
            ->with('novels')
            ->findOrFail($id);

        return view('admin.author.show', compact('author'));
    }

}
