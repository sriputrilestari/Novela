<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ReadingHistory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReaderController extends Controller
{
    /**
     * Display a listing of readers
     */
   public function index(Request $request)
{
    $query = User::where('role', 'user')
        ->withCount('readingHistories');

    // filter dropdown
    if ($request->filter === 'pending') {
        $query->where('author_request', 'pending');
    } elseif ($request->filter === 'active') {
        $query->where('is_active', true);
    } elseif ($request->filter === 'blocked') {
        $query->where('is_active', false);
    }

    // INI YANG KURANG
    $readers = $query->paginate(10);

    // statistik
    $totalReader = User::where('role', 'user')->count();

    $pendingRequest = User::where('role', 'user')
        ->where('author_request', 'pending')
        ->count();

    $activeReader = User::where('role', 'user')
        ->where('is_active', true)
        ->count();

    $blockedReader = User::where('role', 'user')
        ->where('is_active', false)
        ->count();

    return view('admin.reader.index', compact(
        'readers',
        'totalReader',
        'pendingRequest',
        'activeReader',
        'blockedReader'
    ));
}

    /**
     * Display the specified reader
     */
    public function show($id)
    {
        $reader = User::withCount('readingHistories')
            ->findOrFail($id);

        $readingHistories = $reader->readingHistories()
        ->with(['novel', 'chapter'])
        ->orderByDesc('id')
        ->limit(10)
        ->get();



        $comments = $reader->comments()
            ->with('novel')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.reader.show', compact(
            'reader',
            'readingHistories',
            'comments'
        ));
    }


    /**
     * Show edit form for reader
     */
    public function edit($id)
    {
        $reader = User::where('role', 'user')->findOrFail($id);
        return view('admin.reader.edit', compact('reader'));
    }

    /**
     * Update reader information
     */
    public function update(Request $request, $id)
    {
        $reader = User::where('role', 'user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            // Update password jika diisi
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            if (isset($validated['is_active'])) {
                $updateData['is_active'] = $validated['is_active'];
            }

            $reader->update($updateData);

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', 'Data reader berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Approve reader to become author
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $reader = User::findOrFail($id);

            // Validasi bahwa user adalah reader dan ada request author
            if ($reader->role !== 'user') {
                return redirect()->back()->with('error', 'User bukan reader');
            }

            if ($reader->author_request !== 'pending') {
                return redirect()->back()->with('error', 'Tidak ada pengajuan author yang pending');
            }

            // Update role menjadi author
            $reader->update([
                'role' => 'author',
                'author_request' => 'approved',
                'author_approved_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', 'Reader berhasil disetujui menjadi Author! Statistik telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    /**
     * Reject author request
     */
    public function reject($id)
    {
        try {
            $reader = User::findOrFail($id);

            // Validasi
            if ($reader->role !== 'user') {
                return redirect()->back()->with('error', 'User bukan reader');
            }

            if ($reader->author_request !== 'pending') {
                return redirect()->back()->with('error', 'Tidak ada pengajuan author yang pending');
            }

            // Update status pengajuan
            $reader->update([
                'author_request' => 'rejected',
                'author_rejected_at' => now(),
            ]);

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', 'Pengajuan author berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    /**
     * Block or unblock reader
     */
    public function block($id)
    {
        try {
            $reader = User::findOrFail($id);

            // Toggle status is_active
            $newStatus = !$reader->is_active;
            $reader->update(['is_active' => $newStatus]);

            $message = $newStatus 
                ? 'Reader berhasil diaktifkan kembali.' 
                : 'Reader berhasil diblokir.';

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Delete reader (soft delete)
     */
    public function destroy($id)
    {
        try {
            $reader = User::findOrFail($id);

            if ($reader->role !== 'user') {
                return redirect()->back()->with('error', 'Tidak dapat menghapus user yang bukan reader');
            }

            $reader->delete();

            return redirect()
                ->route('admin.reader.index')
                ->with('success', 'Reader berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}