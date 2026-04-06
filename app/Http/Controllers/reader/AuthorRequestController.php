<?php
namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.authorrequest', compact('user'))->with('currentUser', $user);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'pen_name'         => 'required|string|max:255',
            'sinopsis_pertama' => 'required|string|min:50|max:500',
            'pengalaman'       => 'nullable|string',
            'motivasi'         => 'nullable|string|max:1000',
            'setuju'           => 'accepted',
        ], [
            'pen_name.required'         => 'Nama pena wajib diisi.',
            'sinopsis_pertama.required' => 'Sinopsis novel pertama wajib diisi.',
            'sinopsis_pertama.min'      => 'Sinopsis minimal 50 karakter.',
            'setuju.accepted'           => 'Kamu harus menyetujui syarat dan ketentuan.',
        ]);

        $user = Auth::user();

        // Cek apakah sudah punya request yang pending
        if ($user->author_request && $user->author_request->status === 'pending') {
            return back()->with('error', 'Kamu sudah memiliki permintaan yang sedang ditinjau.');
        }

        // Simpan request ke tabel reports (atau bisa buat tabel author_requests sendiri)
        // Menggunakan field yang ada di model user (author_request)
        // Untuk sementara update field author_request = 1 sebagai tanda sudah request
        $user->update([
            'author_request' => 1,
        ]);

        // Kirim notifikasi ke admin (opsional, bisa via event/notification)
        // event(new AuthorRequested($user, $request->all()));

        return back()->with('success', 'Permintaan berhasil dikirim! Tim kami akan meninjau dalam 1–3 hari kerja.');
    }

    public function reapply(Request $request)
    {
        $user = Auth::user();
        $user->update(['author_request' => 0]);

        return redirect()->route('reader.author-request')
            ->with('success', 'Kamu bisa mengisi form pengajuan ulang sekarang.');
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();
        $user->update(['author_request' => 0]);

        return back()->with('success', 'Permintaan berhasil dibatalkan.');
    }
}
