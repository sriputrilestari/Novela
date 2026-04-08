{{-- resources/views/author/comment/show.blade.php --}}
@extends('author.layouts.app')

@section('title', 'Detail Komentar')

@section('content')

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb" style="background:transparent; padding:0; font-size:.85rem;">
            <li class="breadcrumb-item">
                <a href="{{ route('author.comment.index') }}" style="color:#5B8DEF;">Komentar</a>
            </li>
            <li class="breadcrumb-item active text-gray-700 font-weight-bold">Detail</li>
        </ol>
    </nav>

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" style="border-left:4px solid #1cc88a;">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">

        {{-- ── Kolom Kiri: Komentar & Thread ────────────────────── --}}
        <div class="col-lg-8 mb-4">

            {{-- Info novel & chapter --}}
            <div class="card shadow-sm mb-3" style="border-left:4px solid #5B8DEF;">
                <div class="card-body py-3 px-4 d-flex align-items-center">
                    <i class="fas fa-book-open fa-lg mr-3" style="color:#5B8DEF;"></i>
                    <div>
                        <div class="font-weight-bold text-gray-800" style="font-size:.9rem;">
                            {{ $comment->chapter->novel->judul ?? '-' }}
                        </div>
                        <small class="text-muted">
                            Bab {{ $comment->chapter->urutan ?? '-' }}:
                            {{ $comment->chapter->judul ?? '-' }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Komentar utama --}}
            <div class="card shadow mb-3"
                style="border-left:5px solid {{ $comment->is_toxic ? '#e74a3b' : ($comment->is_hidden ? '#f6c23e' : '#5B8DEF') }};">
                <div class="card-body px-4 py-4">

                    {{-- Header --}}
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center
                                     text-white font-weight-bold mr-3 flex-shrink-0"
                                style="width:48px;height:48px;font-size:18px;
                                    background:linear-gradient(135deg,#5B8DEF,#4A7BE0);">
                                {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="d-flex align-items-center flex-wrap mb-1">
                                    <span class="font-weight-bold text-gray-800 mr-2">
                                        {{ $comment->user->name ?? 'Pengguna' }}
                                    </span>
                                    @if ($comment->is_toxic)
                                        <span class="badge mr-2" style="background:#fee2e2;color:#991b1b;font-size:.7rem;">
                                            ☣️ Toxic
                                        </span>
                                    @elseif($comment->is_hidden)
                                        <span class="badge mr-2" style="background:#fef3c7;color:#92400e;font-size:.7rem;">
                                            🙈 Tersembunyi
                                        </span>
                                    @else
                                        <span class="badge" style="background:#d1fae5;color:#065f46;font-size:.7rem;">
                                            ✅ Publik
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    {{ $comment->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex" style="gap:.5rem;">
                            @if (!$comment->is_toxic)
                                <form method="POST" action="{{ route('author.comment.toxic', $comment->id) }}"
                                    onsubmit="return confirm('Tandai komentar ini sebagai toxic?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-radiation mr-1"></i>Toxic
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('author.comment.destroy', $comment->id) }}"
                                onsubmit="return confirm('Hapus komentar ini PERMANEN beserta semua balasannya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Alasan hidden --}}
                    @if ($comment->hidden_reason)
                        <div class="alert py-2 px-3 mb-3 d-flex align-items-center"
                            style="background:#fef3c7;color:#92400e;border:none;font-size:.82rem;border-radius:.35rem;">
                            <i class="fas fa-info-circle mr-2"></i>
                            Alasan disembunyikan: <strong class="ml-1">{{ $comment->hidden_reason }}</strong>
                        </div>
                    @endif

                    {{-- Isi komentar --}}
                    <div class="p-3 rounded"
                        style="background:#f8f9fc; border:1px solid #e3e6f0;
                            font-size:.93rem; line-height:1.7;
                            {{ $comment->is_hidden ? 'opacity:.6;' : '' }}">
                        {{ $comment->komentar }}
                    </div>

                </div>
            </div>

            {{-- Thread balasan --}}
            @if ($comment->replies->count() > 0)
                <div class="card shadow mb-3">
                    <div class="card-header py-3" style="background:#fff; border-bottom:1px solid #e3e6f0;">
                        <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing:.1em;">
                            {{ $comment->replies->count() }} Balasan
                        </span>
                    </div>
                    <div class="card-body px-4 py-3">
                        @foreach ($comment->replies as $reply)
                            <div class="d-flex align-items-start py-3 {{ !$loop->last ? 'border-bottom' : '' }}">

                                {{-- Avatar --}}
                                <div class="rounded-circle d-flex align-items-center justify-content-center
                                         text-white font-weight-bold mr-3 flex-shrink-0"
                                    style="width:36px;height:36px;font-size:13px;
                                        background:{{ $reply->user_id === Auth::id()
                                            ? 'linear-gradient(135deg,#1cc88a,#17a673)'
                                            : 'linear-gradient(135deg,#858796,#6c6e7e)' }};">
                                    {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                </div>

                                {{-- Isi balasan --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center flex-wrap mb-1">
                                        <span class="font-weight-bold mr-2" style="font-size:.85rem; color:#3a3b45;">
                                            {{ $reply->user->name ?? 'Pengguna' }}
                                        </span>
                                        @if ($reply->user_id === Auth::id())
                                            <span class="badge mr-2"
                                                style="background:#d1fae5;color:#065f46;font-size:.65rem;">
                                                Author (Kamu)
                                            </span>
                                        @endif
                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-gray-700" style="font-size:.88rem; line-height:1.6;">
                                        {{ $reply->komentar }}
                                    </p>
                                </div>

                                {{-- Hapus reply --}}
                                <form method="POST" action="{{ route('author.comment.destroy', $reply->id) }}"
                                    class="ml-2 flex-shrink-0" onsubmit="return confirm('Hapus balasan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-muted p-1" title="Hapus balasan"
                                        style="font-size:.8rem;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Form Balas --}}
            <div class="card shadow">
                <div class="card-header py-3" style="background:#fff; border-bottom:1px solid #e3e6f0;">
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing:.1em;">
                        Tulis Balasan
                    </span>
                </div>
                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('author.comment.reply', $comment->id) }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="komentar" rows="4" required maxlength="1000" placeholder="Tulis balasanmu di sini..."
                                class="form-control @error('komentar') is-invalid @enderror"
                                style="font-size:.9rem; background:#f8f9fc;
                                         border-color:#d1d3e2; resize:none;">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maks. 1000 karakter</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('author.comment.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-1"></i>Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- ── Kolom Kanan: Info Sidebar ────────────────────────── --}}
        <div class="col-lg-4 mb-4">

            <div class="card shadow mb-3">
                <div class="card-header py-3" style="background:#fff; border-bottom:1px solid #e3e6f0;">
                    <span class="text-xs font-weight-bold text-uppercase text-muted" style="letter-spacing:.1em;">Info
                        Komentar</span>
                </div>
                <div class="card-body px-4 py-3">
                    <table class="table table-sm table-borderless mb-0" style="font-size:.85rem;">
                        <tr>
                            <td class="text-muted pl-0" style="width:50%;">Status</td>
                            <td class="font-weight-bold pr-0 text-right">
                                @if ($comment->is_toxic)
                                    <span class="text-danger">Toxic</span>
                                @elseif($comment->is_hidden)
                                    <span class="text-warning">Tersembunyi</span>
                                @else
                                    <span class="text-success">Publik</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted pl-0">Total balasan</td>
                            <td class="font-weight-bold pr-0 text-right">{{ $comment->replies->count() }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted pl-0">Dikirim</td>
                            <td class="font-weight-bold pr-0 text-right">
                                {{ $comment->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted pl-0">Dari reader</td>
                            <td class="font-weight-bold pr-0 text-right">
                                {{ $comment->user->name ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
