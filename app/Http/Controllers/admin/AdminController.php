<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total Novel
        $totalNovel = Novel::count();
        
        // Total Author (termasuk yang baru disetujui dari reader)
        $totalAuthor = User::where('role', 'author')->count();
        
        // Total Reader (tidak termasuk yang sudah jadi author)
        $totalReader = User::where('role', 'reader')->count();
        
        // Novel Pending Approval
        $novelPending = Novel::where('status', 'pending')->count();
        
        // Get Pending Novels
        $pendingNovels = Novel::where('status', 'pending')
            ->with('author')
            ->latest()
            ->limit(10)
            ->get();
        
        // Top Readers (paling aktif membaca)
        $topReaders = User::where('role', 'reader')
            ->withCount('readingHistories')
            ->orderBy('reading_histories_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalNovel',
            'totalAuthor',
            'totalReader',
            'novelPending',
            'pendingNovels',
            'topReaders'
        ));
    }
}