<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReaderController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'reader')->withCount('readingHistories');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filter === 'pending') {
            $query->where('author_request', 'pending');
        } elseif ($request->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($request->filter === 'blocked') {
            $query->where('is_active', false);
        }

        $readers = $query->latest()->paginate(10)->withQueryString();

        $totalReader = User::where('role', 'reader')->count();
        $pendingRequest = User::where('role', 'reader')
            ->where('author_request', 'pending')
            ->count();
        $activeReader = User::where('role', 'reader')
            ->where('is_active', true)
            ->count();
        $blockedReader = User::where('role', 'reader')
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

    public function show($id)
    {
        $reader = User::where('role', 'reader')
            ->withCount(['readingHistories', 'comments', 'ratings'])
            ->findOrFail($id);

        $readingHistories = $reader->readingHistories()
            ->with(['chapter.novel'])
            ->orderByDesc('last_read_at')
            ->limit(10)
            ->get();

        $comments = $reader->comments()
            ->with(['chapter.novel'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.reader.show', compact(
            'reader',
            'readingHistories',
            'comments'
        ));
    }

    public function edit($id)
    {
        $reader = User::where('role', 'reader')->findOrFail($id);

        return view('admin.reader.edit', compact('reader'));
    }

    public function update(Request $request, $id)
    {
        $reader = User::where('role', 'reader')->findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'password'  => 'nullable|min:8|confirmed',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $updateData = [
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ];

            if (! empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            if (array_key_exists('is_active', $validated)) {
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

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $reader = User::where('role', 'reader')->findOrFail($id);

            if ($reader->author_request !== 'pending') {
                return redirect()->back()->with('error', 'Tidak ada pengajuan author yang pending.');
            }

            $reader->update([
                'role'               => 'author',
                'author_request'     => 'approved',
                'author_approved_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.reader.index')
                ->with('success', 'Reader berhasil disetujui menjadi author.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $reader = User::where('role', 'reader')->findOrFail($id);

            if ($reader->author_request !== 'pending') {
                return redirect()->back()->with('error', 'Tidak ada pengajuan author yang pending.');
            }

            $reader->update([
                'author_request'     => 'rejected',
                'author_rejected_at' => now(),
            ]);

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', 'Pengajuan author berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    public function block($id)
    {
        try {
            $reader = User::where('role', 'reader')->findOrFail($id);

            $reader->update(['is_active' => ! $reader->is_active]);

            $message = $reader->is_active
                ? 'Reader berhasil diaktifkan kembali.'
                : 'Reader berhasil diblokir.';

            return redirect()
                ->route('admin.reader.show', $id)
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $reader = User::where('role', 'reader')->findOrFail($id);

            $reader->delete();

            return redirect()
                ->route('admin.reader.index')
                ->with('success', 'Reader berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
