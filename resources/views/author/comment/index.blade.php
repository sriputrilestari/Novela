{{-- resources/views/author/comment/index.blade.php --}}
@extends('author.layouts.app')

@section('title', 'Komentar & Feedback')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">💬 Komentar & Feedback</h1>
            <small class="text-muted">Kelola komentar reader dari semua novel kamu</small>
        </div>
    </div>

    <!-- Alert sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
            style="border-left:4px solid #1cc88a;">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert"
            style="border-left:4px solid #e74a3b;">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="row mb-4">
        <!-- Semua Komentar -->
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card shadow h-100 py-2" style="border-left:4px solid #5B8DEF;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#5B8DEF;">Total Komentar
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalAll }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Komentar Toxic -->
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card shadow h-100 py-2" style="border-left:4px solid #e74a3b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Komentar Toxic
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalToxic }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-radiation fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Komentar -->
    <div class="card shadow mb-4">

        <!-- Card Header: Filter Tabs -->
        <div class="card-header py-3 d-flex align-items-center" style="background:#fff; border-bottom:1px solid #e3e6f0;">
            <a href="{{ route('author.comment.index', ['filter' => 'all']) }}"
                class="btn btn-sm mr-2 {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="fas fa-list mr-1"></i>Semua
            </a>
            <a href="{{ route('author.comment.index', ['filter' => 'toxic']) }}"
                class="btn btn-sm {{ $filter === 'toxic' ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="fas fa-radiation mr-1"></i>Toxic
            </a>
        </div>

        <!-- Card Body: Daftar Komentar -->
        <div class="card-body p-0">

            @forelse($comments as $comment)
                <div class="px-4 py-4 border-bottom"
                    style="{{ $comment->is_toxic ? 'background:#fff5f5;' : ($comment->is_hidden ? 'background:#fffbf0;' : '') }}">

                    <div class="d-flex align-items-start">

                        {{-- Strip warna kiri --}}
                        <div class="mr-3 flex-shrink-0"
                            style="width:4px; min-height:100px; border-radius:4px;
                            background:{{ $comment->is_toxic ? '#e74a3b' : ($comment->is_hidden ? '#f6c23e' : '#5B8DEF') }};">
                        </div>

                        {{-- Avatar --}}
                        <div class="rounded-circle d-flex align-items-center justify-content-center
                             text-white font-weight-bold mr-3 flex-shrink-0"
                            style="width:44px; height:44px; font-size:16px;
                            background:linear-gradient(135deg,#5B8DEF,#4A7BE0);">
                            {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                        </div>

                        {{-- Konten utama --}}
                        <div class="flex-grow-1" style="min-width:0;">

                            {{-- Nama + badge + info novel --}}
                            <div class="d-flex flex-wrap align-items-center mb-1">
                                <span class="font-weight-bold text-gray-800 mr-2" style="font-size:.9rem;">
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
                                    <span class="badge mr-2" style="background:#d1fae5;color:#065f46;font-size:.7rem;">
                                        ✅ Publik
                                    </span>
                                @endif

                                <small class="text-muted" style="font-size:.78rem;">
                                    📖 <strong>{{ $comment->chapter->novel->judul ?? '-' }}</strong>
                                    &middot; Bab {{ $comment->chapter->urutan ?? '-' }}
                                    &middot; {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>

                            {{-- Alasan hidden --}}
                            @if ($comment->hidden_reason)
                                <div class="mb-2" style="display:inline-block;">
                                    <span class="small px-2 py-1 rounded"
                                        style="background:#fef3c7;color:#92400e;font-size:.78rem;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Alasan: <strong>{{ $comment->hidden_reason }}</strong>
                                    </span>
                                </div>
                            @endif

                            {{-- Isi komentar --}}
                            <div class="p-3 rounded mb-3"
                                style="background:#f8f9fc; border:1px solid #e3e6f0;
                                font-size:.9rem; line-height:1.65;
                                {{ $comment->is_hidden ? 'opacity:.6;' : '' }}">
                                {{ $comment->komentar }}
                            </div>

                            {{-- Preview reply --}}
                            @if ($comment->replies->count() > 0)
                                <div class="mb-3 pl-3" style="border-left:3px solid #e3e6f0;">
                                    @foreach ($comment->replies->take(2) as $reply)
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center
                                                 text-white font-weight-bold mr-2 flex-shrink-0"
                                                style="width:26px; height:26px; font-size:10px;
                                                background:{{ $reply->user_id === Auth::id() ? '#1cc88a' : '#858796' }};">
                                                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="font-weight-bold" style="font-size:.78rem; color:#5a5c69;">
                                                    {{ $reply->user->name ?? 'User' }}
                                                    @if ($reply->user_id === Auth::id())
                                                        <span class="badge"
                                                            style="background:#d1fae5;color:#065f46;font-size:.65rem;">
                                                            Kamu
                                                        </span>
                                                    @endif
                                                </span>
                                                <p class="mb-0 text-muted" style="font-size:.8rem; line-height:1.5;">
                                                    {{ Str::limit($reply->komentar, 90) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($comment->replies->count() > 2)
                                        <a href="{{ route('author.comments.show', $comment->id) }}"
                                            class="text-decoration-none" style="font-size:.78rem; color:#5B8DEF;">
                                            +{{ $comment->replies->count() - 2 }} balasan lainnya →
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Quick reply form --}}
                            <form method="POST" action="{{ route('author.comments.reply', $comment->id) }}" class="d-flex"
                                style="gap:.5rem;">
                                @csrf
                                <input type="text" name="komentar" placeholder="Tulis balasan..." required
                                    maxlength="1000" class="form-control form-control-sm"
                                    style="font-size:.85rem; border-color:#d1d3e2; background:#f8f9fc;">
                                <button type="submit" class="btn btn-sm btn-primary flex-shrink-0">
                                    <i class="fas fa-reply mr-1"></i>Balas
                                </button>
                            </form>

                        </div>

                        {{-- Tombol aksi (kanan) --}}
                        <div class="ml-3 d-flex flex-column flex-shrink-0" style="gap:.4rem;">

                            <a href="{{ route('author.comments.show', $comment->id) }}"
                                class="btn btn-sm btn-outline-secondary" title="Lihat detail & reply">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if (!$comment->is_toxic)
                                <form method="POST" action="{{ route('author.comments.toxic', $comment->id) }}"
                                    onsubmit="return confirm('Tandai komentar ini sebagai toxic?\nKomentar akan otomatis disembunyikan dari reader.')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-warning w-100"
                                        title="Tandai toxic">
                                        <i class="fas fa-radiation"></i>
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('author.comments.destroy', $comment->id) }}"
                                onsubmit="return confirm('Hapus komentar ini PERMANEN?\nSemua balasannya juga akan ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                    title="Hapus permanen">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x mb-3" style="color:#d1d3e2;"></i>
                    <p class="font-weight-bold text-gray-600 mb-1">Belum ada komentar</p>
                    <small class="text-muted">Komentar dari reader akan muncul di sini</small>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($comments->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-center">
                {{ $comments->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>

@endsection
