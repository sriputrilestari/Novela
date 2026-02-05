<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthorRequestController extends Controller
{
    /**
     * Show author request form
     */
    public function index()
    {
        // Check if user already an author
        if (Auth::user()->role === 'author') {
            return redirect()->route('home')->with('info', 'Anda sudah menjadi author.');
        }

        return view('reader.author-request');
    }

    /**
     * Submit author request
     */
    public function submit(Request $request)
    {
        $user = Auth::user();

        // Validate user role
        if ($user->role !== 'reader') {
            return redirect()->route('home')->with('error', 'Hanya reader yang dapat mengajukan menjadi author.');
        }

        // Check if already has pending request
        if ($user->author_request === 'pending') {
            return redirect()->back()->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses.');
        }

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'author_request_note' => 'required|string|min:50|max:1000',
            'agree' => 'required|accepted',
        ], [
            'name.required' => 'Nama wajib diisi',
            'author_request_note.required' => 'Alasan wajib diisi',
            'author_request_note.min' => 'Alasan minimal 50 karakter',
            'author_request_note.max' => 'Alasan maksimal 1000 karakter',
            'agree.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        try {
            // Update user
            $user->update([
                'name' => $validated['name'],
                'author_request' => 'pending',
                'author_request_date' => now(),
                'author_request_note' => $validated['author_request_note'],
            ]);

            // Send notification to admin (optional)
            // Notification::send(User::where('role', 'admin')->get(), new NewAuthorRequest($user));

            return redirect()
                ->route('reader.author-request')
                ->with('success', 'Pengajuan berhasil dikirim! Tim kami akan segera meninjau pengajuan Anda.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reapply after rejection
     */
    public function reapply(Request $request)
    {
        $user = Auth::user();

        // Validate user can reapply
        if ($user->role !== 'reader') {
            return redirect()->route('home')->with('error', 'Hanya reader yang dapat mengajukan menjadi author.');
        }

        if ($user->author_request !== 'rejected') {
            return redirect()->back()->with('error', 'Anda tidak dapat mengajukan ulang saat ini.');
        }

        // Validate request
        $validated = $request->validate([
            'author_request_note' => 'required|string|min:50|max:1000',
        ], [
            'author_request_note.required' => 'Alasan wajib diisi',
            'author_request_note.min' => 'Alasan minimal 50 karakter',
            'author_request_note.max' => 'Alasan maksimal 1000 karakter',
        ]);

        try {
            // Reset and reapply
            $user->update([
                'author_request' => 'pending',
                'author_request_date' => now(),
                'author_request_note' => $validated['author_request_note'],
                'author_rejected_at' => null,
            ]);

            return redirect()
                ->route('reader.author-request')
                ->with('success', 'Pengajuan ulang berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Cancel pending request
     */
    public function cancel()
    {
        $user = Auth::user();

        if ($user->author_request !== 'pending') {
            return redirect()->back()->with('error', 'Tidak ada pengajuan yang dapat dibatalkan.');
        }

        try {
            $user->update([
                'author_request' => 'none',
                'author_request_date' => null,
                'author_request_note' => null,
            ]);

            return redirect()
                ->route('home')
                ->with('success', 'Pengajuan berhasil dibatalkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}