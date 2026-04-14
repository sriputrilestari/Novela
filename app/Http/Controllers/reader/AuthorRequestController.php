<?php
namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ✅ ambil genre
        $genres = Genre::orderBy('nama_genre')->get();

        return view('pages.authorrequest', [
            'currentUser' => $user,
            'genres'      => $genres,
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'pen_name'         => 'required|string|max:255',
            'sinopsis_pertama' => 'required|string|min:50|max:500',
            'pengalaman'       => 'nullable|string|max:255',
            'motivasi'         => 'nullable|string|max:1000',
            'setuju'           => 'accepted',
        ], [
            'pen_name.required'         => 'Nama pena wajib diisi.',
            'sinopsis_pertama.required' => 'Sinopsis novel pertama wajib diisi.',
            'sinopsis_pertama.min'      => 'Sinopsis minimal 50 karakter.',
            'setuju.accepted'           => 'Kamu harus menyetujui syarat dan ketentuan.',
        ]);

        $user = Auth::user();

        if ($user->author_request === 'pending') {
            return back()->with('error', 'Kamu sudah memiliki permintaan yang sedang ditinjau.');
        }

        if ($user->role !== 'reader') {
            return back()->with('error', 'Hanya reader yang bisa mengajukan permintaan author.');
        }

        $noteParts = [
            'Nama pena: ' . $request->pen_name,
            'Sinopsis: ' . $request->sinopsis_pertama,
        ];

        if ($request->filled('pengalaman')) {
            $noteParts[] = 'Pengalaman: ' . $request->pengalaman;
        }

        if ($request->filled('motivasi')) {
            $noteParts[] = 'Motivasi: ' . $request->motivasi;
        }

        if ($request->filled('genres')) {
            $noteParts[] = 'Genre favorit: ' . implode(', ', (array) $request->genres);
        }

        $user->update([
            'author_request'      => 'pending',
            'author_request_note' => implode("\n\n", $noteParts),
            'author_request_date' => now(),
            'author_approved_at'  => null,
            'author_rejected_at'  => null,
        ]);

        return back()->with('success', 'Permintaan berhasil dikirim! Tim kami akan meninjau dalam 1-3 hari kerja.');
    }

    public function reapply(Request $request)
    {
        $user = Auth::user();

        if ($user->author_request !== 'rejected') {
            return redirect()->route('reader.author-request')
                ->with('error', 'Pengajuan ulang hanya tersedia setelah permintaan ditolak.');
        }

        $user->update([
            'author_request'      => 'none',
            'author_request_note' => null,
            'author_request_date' => null,
            'author_rejected_at'  => null,
        ]);

        return redirect()->route('reader.author-request')
            ->with('success', 'Kamu bisa mengisi form pengajuan ulang sekarang.');
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();

        if ($user->author_request !== 'pending') {
            return back()->with('error', 'Tidak ada permintaan yang bisa dibatalkan.');
        }

        $user->update([
            'author_request'      => 'none',
            'author_request_note' => null,
            'author_request_date' => null,
        ]);

        return back()->with('success', 'Permintaan berhasil dibatalkan.');
    }
}
