@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Detail Novel</h1>
                <p class="mb-0 text-muted small mt-1">Informasi lengkap dan manajemen novel</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.novels.index') }}">Novel</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>

        <div class="row">

            {{-- LEFT: Cover + Aksi --}}
            <div class="col-xl-3 col-lg-4 mb-4">

                {{-- Cover Card --}}
                <div class="card shadow mb-4">
                    <div class="card-body text-center p-4">
                        @if ($novel->cover)
                            <img src="{{ asset('storage/' . $novel->cover) }}" alt="Cover Novel"
                                class="img-fluid rounded shadow-sm" style="max-width:200px; width:100%;">
                        @else
                            <div class="d-flex align-items-center justify-content-center text-white rounded mx-auto"
                                style="width:160px; height:220px; background: linear-gradient(135deg, #4e73df, #36b9cc); font-size:48px;">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <h6 class="font-weight-bold text-gray-800 mt-3 mb-1">{{ $novel->judul ?? $novel->title }}</h6>
                        <p class="text-muted small mb-0">by {{ $novel->author?->name ?? '-' }}</p>
                    </div>
                </div>

                {{-- Info Singkat --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-2"></i>Info Novel
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-tags fa-fw mr-2"></i>Genre</span>
                                <span class="small font-weight-bold">{{ $novel->genre?->nama_genre ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-eye fa-fw mr-2"></i>Views</span>
                                <span class="small font-weight-bold">{{ number_format($novel->views ?? 0) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-list fa-fw mr-2"></i>Chapter</span>
                                <span class="small font-weight-bold">{{ $novel->chapters?->count() ?? 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-calendar fa-fw mr-2"></i>Dibuat</span>
                                <span
                                    class="small font-weight-bold">{{ $novel->created_at?->format('d M Y') ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-circle fa-fw mr-2"></i>Status</span>
                                <span>
                                    @if ($novel->approval_status == 'pending')
                                        <span class="badge badge-pill badge-warning px-2">Pending</span>
                                    @elseif($novel->approval_status == 'published')
                                        <span class="badge badge-pill badge-success px-2">Published</span>
                                    @else
                                        <span class="badge badge-pill badge-danger px-2">Rejected</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cog mr-2"></i>Aksi
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($novel->approval_status !== 'published')
                            <form action="{{ route('admin.novels.updateStatus', $novel->id) }}" method="POST"
                                class="mb-2"
                                onsubmit="confirmAction('Publish novel ini? Novel akan langsung tayang ke publik.', () => this.submit()); return false;">
                                @csrf
                                <input type="hidden" name="approval_status" value="published">
                                <button type="submit" class="btn btn-success btn-block btn-sm">
                                    <i class="fas fa-check-circle mr-2"></i>Publish Novel
                                </button>
                            </form>
                        @endif

                        @if ($novel->approval_status !== 'rejected')
                            <form action="{{ route('admin.novels.updateStatus', $novel->id) }}" method="POST"
                                class="mb-2"
                                onsubmit="confirmAction('Tolak novel ini? Author akan diberitahu bahwa novelnya ditolak.', () => this.submit()); return false;">
                                @csrf
                                <input type="hidden" name="approval_status" value="rejected">
                                <button type="submit" class="btn btn-danger btn-block btn-sm">
                                    <i class="fas fa-times-circle mr-2"></i>Reject Novel
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.novels.index') }}" class="btn btn-light border btn-block btn-sm mt-1">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>

            </div>

            {{-- RIGHT: Detail --}}
            <div class="col-xl-9 col-lg-8 mb-4">

                {{-- Sinopsis --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-align-left mr-2"></i>Sinopsis
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($novel->sinopsis ?? $novel->description)
                            <p class="text-gray-700 mb-0" style="line-height: 1.8;">
                                {{ $novel->sinopsis ?? $novel->description }}
                            </p>
                        @else
                            <p class="text-muted mb-0"><em>Tidak ada sinopsis.</em></p>
                        @endif
                    </div>
                </div>

                {{-- Daftar Chapter --}}
                <div class="card shadow">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list-ol mr-2"></i>Daftar Chapter
                        </h6>
                        @if ($novel->chapters?->count())
                            <span class="badge badge-primary badge-pill px-3">{{ $novel->chapters->count() }}
                                chapter</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if ($novel->chapters?->count())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead style="background-color: #f8f9fc;">
                                        <tr>
                                            <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600"
                                                style="width:60px;">No</th>
                                            <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">
                                                Judul Chapter</th>
                                            <th
                                                class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                                Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($novel->chapters as $chapter)
                                            <tr>
                                                <td class="px-4 align-middle text-muted">
                                                    {{ $chapter->nomor_chapter ?? $loop->iteration }}</td>
                                                <td class="align-middle font-weight-bold text-gray-800">
                                                    {{ $chapter->judul_chapter ?? ($chapter->title ?? '-') }}</td>
                                                <td class="align-middle text-center text-muted small">
                                                    {{ $chapter->created_at?->format('d M Y') ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-gray-300 d-block mb-3"></i>
                                <p class="font-weight-bold text-muted mb-1">Belum ada chapter</p>
                                <small class="text-muted">Novel ini belum memiliki chapter.</small>
                            </div>
                        @endif
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
