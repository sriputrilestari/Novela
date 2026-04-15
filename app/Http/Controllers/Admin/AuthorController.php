<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // 1. INDEX (FIX TOTAL)
    public function index(Request $request)
    {
        $query = User::where('role', 'author')
            ->withCount('novels');

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 🎯 FILTER
        if ($request->filter === 'active') {
            $query->where('is_active', 1);
        } elseif ($request->filter === 'blocked') {
            $query->where('is_active', 0);
        }

        $authors = $query->latest()->paginate(10);

        // 📊 STATISTIK (PAKAI is_active AJA)
        $totalAuthor   = User::where('role', 'author')->count();
        $activeAuthor  = User::where('role', 'author')->where('is_active', 1)->count();
        $blockedAuthor = User::where('role', 'author')->where('is_active', 0)->count();

        return view('admin.author.index', compact(
            'authors',
            'totalAuthor',
            'activeAuthor',
            'blockedAuthor'
        ));
    }

    // 2. AKTIF / NONAKTIF
    public function toggle($id)
    {
        $author = User::where('role', 'author')->findOrFail($id);

        $author->is_active = ! $author->is_active;
        $author->save();

        return redirect()->back()->with('success', 'Status author berhasil diubah.');
    }

    // 3. BLOKIR (SEKARANG PAKE is_active)
    public function block($id)
    {
        $author = User::where('role', 'author')->findOrFail($id);

        $author->is_active = 0;
        $author->save();

        return redirect()->back()->with('success', 'Author berhasil diblokir.');
    }

    // 4. HAPUS
    public function destroy($id)
    {
        $author = User::where('role', 'author')->findOrFail($id);

        if ($author->novels()->count() > 0) {
            return redirect()->back()->with('error', 'Author masih punya novel, hapus novel dulu.');
        }

        $author->delete();

        return redirect()->back()->with('success', 'Author berhasil dihapus.');
    }

    // 5. DETAIL
    public function show($id)
    {
        $author = User::where('role', 'author')
            ->with('novels')
            ->findOrFail($id);

        return view('admin.author.show', compact('author'));
    }
}
