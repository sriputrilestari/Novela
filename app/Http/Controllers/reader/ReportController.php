<?php
// app/Http/Controllers/Reader/ReportController.php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request, $novelId)
    {
        $request->validate([
            'alasan'    => 'required|in:konten_dewasa,kekerasan,plagiarisme,ujaran_kebencian,spam,lainnya',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $novel  = Novel::findOrFail($novelId);
        $userId = Auth::id();

        // Anti-duplikat: 1 user tidak bisa lapor novel yang sama 2x
        $exists = Report::where('user_id', $userId)
            ->where('novel_id', $novel->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kamu sudah pernah melaporkan novel ini.');
        }

        // Rate limit: maks 2 laporan unik per 7 hari
        if (Report::reachedWeeklyLimit($userId)) {
            $resetsAt = Report::quotaResetsAt($userId);
            return back()->with('error', 'Batas laporan mingguan tercapai. Coba lagi ' . ($resetsAt ? $resetsAt->translatedFormat('d M Y') : 'beberapa hari lagi') . '.');
        }

        Report::create([
            'user_id'   => $userId,
            'novel_id'  => $novel->id,
            'alasan'    => $request->alasan,
            'deskripsi' => $request->deskripsi,
            'status'    => 'pending',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Admin akan meninjau segera.');
    }
}
