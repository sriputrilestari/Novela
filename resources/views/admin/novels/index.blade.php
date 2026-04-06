@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Novel</h1>
                <p class="mb-0 text-muted small mt-1">Kelola seluruh novel yang ada di platform</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Novel</li>
            </ol>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Novel</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-book fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Published</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['published'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-2"></i>Daftar Novel
                    </h6>
                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('admin.novels.index') }}"
                        class="d-flex align-items-center flex-wrap" style="gap:8px;">
                        <div class="input-group input-group-sm" style="width:200px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-filter text-primary" style="font-size:11px;"></i>
                                </span>
                            </div>
                            <select name="status" class="form-control form-control-sm border-left-0"
                                onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm" style="width:180px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0">
                                    <i class="fas fa-tags text-primary" style="font-size:11px;"></i>
                                </span>
                            </div>
                            <select name="genre_id" class="form-control form-control-sm border-left-0"
                                onchange="this.form.submit()">
                                <option value="">Semua Genre</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->nama_genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if (request('status') || request('genre_id'))
                            <a href="{{ route('admin.novels.index') }}" class="btn btn-sm btn-light border"
                                title="Reset Filter">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fc;">
                            <tr>
                                <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width:40px;">No</th>
                                <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Judul Novel
                                </th>
                                <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Author</th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Genre</th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Status</th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($novels as $index => $novel)
                                <tr>
                                    <td class="px-4 align-middle text-muted">{{ $novels->firstItem() + $index }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if ($novel->cover)
                                                <img src="{{ asset('storage/' . $novel->cover) }}" class="rounded mr-3"
                                                    style="width:38px; height:52px; object-fit:cover; flex-shrink:0;">
                                            @else
                                                <div class="rounded mr-3 d-flex align-items-center justify-content-center text-white"
                                                    style="width:38px; height:52px; flex-shrink:0; font-size:14px;
                                            background-color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index % 5] }};">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-weight-bold text-gray-800">
                                                    {{ $novel->judul ?? $novel->title }}</div>
                                                <div class="small text-muted">
                                                    {{-- <i
                                                        class="fas fa-eye fa-fw mr-1"></i>{{ number_format($novel->views ?? 0) }}
                                                    views --}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="small font-weight-bold text-gray-800">
                                            {{ $novel->author?->name ?? '-' }}</div>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($novel->genre)
                                            <span class="badge badge-pill badge-info px-3 py-2" style="font-size:11px;">
                                                {{ $novel->genre->nama_genre }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($novel->approval_status == 'pending')
                                            <span class="badge badge-pill badge-warning px-3 py-2">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @elseif($novel->approval_status == 'published')
                                            <span class="badge badge-pill badge-success px-3 py-2">
                                                <i class="fas fa-check-circle mr-1"></i>Published
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-danger px-3 py-2">
                                                <i class="fas fa-times-circle mr-1"></i>Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.novels.show', $novel->id) }}"
                                            class="btn btn-sm btn-info" title="Detail Novel"
                                            style="width:32px; height:32px; padding:0; line-height:32px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.novels.destroy', $novel->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="confirmAction('Hapus novel ini secara permanen? Tindakan ini tidak dapat dibatalkan.', () => this.submit()); return false;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Novel"
                                                style="width:32px; height:32px; padding:0; line-height:32px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-book-open fa-3x mb-3 d-block text-gray-300"></i>
                                            <p class="mb-1 font-weight-bold">Tidak ada novel ditemukan</p>
                                            <small>Coba ubah filter status atau genre</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($novels->total() > 0)
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center py-3 px-4">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $novels->firstItem() ?? 0 }}</strong> &ndash;
                        <strong>{{ $novels->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $novels->total() }}</strong> novel
                    </div>
                    <div>{{ $novels->appends(request()->query())->links() }}</div>
                </div>
            @endif
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
