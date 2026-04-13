@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Detail Reader</h1>
            <p class="mb-0 text-muted small mt-1">Informasi lengkap dan aktivitas reader</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.reader.index') }}">Reader</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg mr-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
            <div>{{ session('error') }}</div>
        </div>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Pending Request Banner --}}
    @if($reader->author_request === 'pending')
    <div class="alert border-0 shadow-sm mb-4" style="background-color: #fff8e1;">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle fa-lg text-warning mr-3"></i>
                <div>
                    <strong class="text-warning">Pengajuan Author Menunggu Review</strong>
                    <div class="small text-muted mt-1">Reader ini mengajukan diri menjadi author. Tinjau dan ambil keputusan.</div>
                </div>
            </div>
            <div class="mt-2 mt-md-0">
                <form action="{{ route('admin.reader.approve', $reader->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Setujui pengajuan menjadi Author?')">
                    @csrf
                    <button class="btn btn-success btn-sm mr-2">
                        <i class="fas fa-check mr-1"></i>Setujui
                    </button>
                </form>
                <form action="{{ route('admin.reader.reject', $reader->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Tolak pengajuan Author ini?')">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-times mr-1"></i>Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        {{-- LEFT COLUMN --}}
        <div class="col-xl-4 col-lg-5 mb-4">

            {{-- Profile Card --}}
            <div class="card shadow mb-4">
                <div class="card-body text-center pt-4 pb-3">
                    <div class="mb-3">
                        @if($reader->photo)
                            <img src="{{ asset('storage/' . $reader->photo) }}"
                                class="rounded-circle"
                                style="width:90px; height:90px; object-fit:cover; border: 3px solid #4e73df;">
                        @else
                            <div class="mx-auto text-white d-flex align-items-center justify-content-center font-weight-bold"
                                style="width:90px; height:90px; border-radius:50%; font-size:36px;
                                background-color: {{ ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'][crc32($reader->name) % 5] }};">
                                {{ strtoupper(substr($reader->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h5 class="font-weight-bold text-gray-800 mb-1">{{ $reader->name }}</h5>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-envelope mr-1"></i>{{ $reader->email }}
                    </p>

                    {{-- Status Badges --}}
                    <div class="mb-3">
                        @if($reader->is_active)
                            <span class="badge badge-pill badge-success px-3 py-2 mr-1">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                        @else
                            <span class="badge badge-pill badge-danger px-3 py-2 mr-1">
                                <i class="fas fa-ban mr-1"></i>Diblokir
                            </span>
                        @endif

                        @if($reader->author_request === 'pending')
                            <span class="badge badge-pill badge-warning px-3 py-2">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                        @elseif($reader->author_request === 'approved')
                            <span class="badge badge-pill badge-success px-3 py-2">
                                <i class="fas fa-star mr-1"></i>Author
                            </span>
                        @elseif($reader->author_request === 'rejected')
                            <span class="badge badge-pill badge-secondary px-3 py-2">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                        @endif
                    </div>

                    <hr>

                </div>
            </div>

            {{-- Informasi Akun --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="text-muted small"><i class="fas fa-calendar-plus fa-fw mr-2"></i>Bergabung</span>
                            <span class="small font-weight-bold">{{ $reader->created_at?->format('d M Y') ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="text-muted small"><i class="fas fa-sync-alt fa-fw mr-2"></i>Terakhir Update</span>
                            <span class="small font-weight-bold">{{ $reader->updated_at?->diffForHumans() ?? '-' }}</span>
                        </li>
                        @if($reader->author_request_date)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="text-muted small"><i class="fas fa-paper-plane fa-fw mr-2"></i>Tgl Pengajuan</span>
                            <span class="small font-weight-bold">{{ \Carbon\Carbon::parse($reader->author_request_date)->format('d M Y') }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                            <span class="text-muted small"><i class="fas fa-id-badge fa-fw mr-2"></i>ID</span>
                            <span class="small font-weight-bold text-muted">#{{ $reader->id }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Catatan Pengajuan --}}
            @if($reader->author_request_note)
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #fff8e1; border-left: 4px solid #f6c23e;">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-sticky-note mr-2"></i>Catatan Pengajuan Author
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 text-gray-700" style="line-height: 1.7;">{{ $reader->author_request_note }}</p>
                </div>
            </div>
            @endif

            {{-- Manajemen Akun --}}
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cog mr-2"></i>Manajemen Akun
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.reader.block', $reader->id) }}" method="POST" class="mb-2"
                        onsubmit="return confirm('Yakin ingin {{ $reader->is_active ? 'memblokir' : 'mengaktifkan' }} reader ini?')">
                        @csrf
                        <button type="submit" class="btn btn-block btn-sm {{ $reader->is_active ? 'btn-danger' : 'btn-success' }}">
                            <i class="fas fa-{{ $reader->is_active ? 'ban' : 'check-circle' }} mr-2"></i>
                            {{ $reader->is_active ? 'Blokir Reader' : 'Aktifkan Reader' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.reader.index') }}" class="btn btn-block btn-sm btn-light border">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-xl-8 col-lg-7 mb-4">

            {{-- Mini Stats --}}
            <div class="row mb-4">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body py-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Baca</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reader->reading_histories_count ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body py-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Komentar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reader->comments_count ?? 0 }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body py-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rating Diberikan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reader->ratings_count ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Bacaan --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-book-open mr-2"></i>Riwayat Bacaan Terakhir
                    </h6>
                    @if(!empty($readingHistories) && count($readingHistories))
                        <span class="badge badge-primary badge-pill px-3">{{ count($readingHistories) }}</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    @forelse($readingHistories ?? [] as $history)
                        @if($loop->first)
                        <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fc;">
                                <tr>
                                    <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Novel</th>
                                    <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Chapter</th>
                                    <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Terakhir Baca</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                                <tr>
                                    <td class="px-4 align-middle font-weight-bold text-gray-800">{{ $history->chapter?->novel?->judul ?? '-' }}</td>
                                    <td class="align-middle text-muted small">
                                        <i class="fas fa-bookmark fa-fw mr-1 text-gray-400"></i>
                                        {{ $history->chapter?->judul_chapter ?? '-' }}
                                    </td>
                                    <td class="align-middle text-muted small">
                                        <i class="fas fa-clock fa-fw mr-1 text-gray-400"></i>
                                        {{ $history->last_read_at?->diffForHumans() ?? '-' }}
                                    </td>
                                </tr>
                        @if($loop->last)
                            </tbody>
                        </table>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-gray-300 d-block mb-3"></i>
                            <p class="font-weight-bold text-muted mb-1">Belum ada riwayat bacaan</p>
                            <small class="text-muted">Reader ini belum membaca novel apapun.</small>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Komentar Terakhir --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comments mr-2"></i>Komentar Terakhir
                    </h6>
                    @if(!empty($comments) && count($comments))
                        <span class="badge badge-primary badge-pill px-3">{{ count($comments) }}</span>
                    @endif
                </div>
                <div class="card-body p-0">
                    @forelse($comments ?? [] as $comment)
                        @if($loop->first)
                        <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fc;">
                                <tr>
                                    <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Novel</th>
                                    <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Komentar</th>
                                    <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                                <tr>
                                    <td class="px-4 align-middle font-weight-bold text-gray-800">{{ $comment->chapter?->novel?->judul ?? '-' }}</td>
                                    <td class="align-middle text-muted small">{{ \Illuminate\Support\Str::limit($comment->komentar, 60) }}</td>
                                    <td class="align-middle text-muted small">
                                        <i class="fas fa-calendar-alt fa-fw mr-1 text-gray-400"></i>
                                        {{ $comment->created_at?->format('d M Y') ?? '-' }}
                                    </td>
                                </tr>
                        @if($loop->last)
                            </tbody>
                        </table>
                        </div>
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-comment-slash fa-3x text-gray-300 d-block mb-3"></i>
                            <p class="font-weight-bold text-muted mb-1">Belum ada komentar</p>
                            <small class="text-muted">Reader ini belum memberikan komentar apapun.</small>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endsection
