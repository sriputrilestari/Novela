@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Reader</h1>
            <p class="mb-0 text-muted small mt-1">Kelola seluruh reader terdaftar di platform</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Reader</li>
        </ol>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg mr-3"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Reader</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $readers->total() }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pengajuan Pending</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('author_request', 'pending')->count() }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reader Aktif</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('is_active', true)->count() }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Reader Diblokir</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('is_active', false)->count() }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-ban fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reader Table --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Daftar Reader
                </h6>
                <div class="d-flex align-items-center">
                    {{-- Search --}}
                    <form method="GET" action="" class="mr-2">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <input type="text" name="search" class="form-control border-0 shadow-sm"
                                placeholder="Cari nama / email..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- Filter --}}
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-filter mr-1"></i>
                            {{ request('filter') === 'pending' ? 'Pending' : (request('filter') === 'active' ? 'Aktif' : (request('filter') === 'blocked' ? 'Diblokir' : 'Semua')) }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                            <h6 class="dropdown-header text-uppercase small">Filter Status</h6>
                            <a class="dropdown-item {{ !request('filter') || request('filter') === 'all' ? 'active' : '' }}" href="?filter=all">
                                <i class="fas fa-users fa-fw mr-2"></i>Semua Reader
                            </a>
                            <a class="dropdown-item {{ request('filter') === 'pending' ? 'active' : '' }}" href="?filter=pending">
                                <i class="fas fa-clock fa-fw mr-2 text-warning"></i>Pengajuan Pending
                            </a>
                            <a class="dropdown-item {{ request('filter') === 'active' ? 'active' : '' }}" href="?filter=active">
                                <i class="fas fa-check-circle fa-fw mr-2 text-success"></i>Reader Aktif
                            </a>
                            <a class="dropdown-item {{ request('filter') === 'blocked' ? 'active' : '' }}" href="?filter=blocked">
                                <i class="fas fa-ban fa-fw mr-2 text-danger"></i>Reader Diblokir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="dataTable">
                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600" style="width:50px;">No</th>
                            <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Reader</th>
                            <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Email</th>
                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Total Baca</th>
                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Pengajuan Author</th>
                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Status Akun</th>
                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Bergabung</th>
                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($readers as $index => $reader)
                        <tr @if($reader->author_request === 'pending') style="background-color: #fffdf0;" @endif>
                            <td class="px-4 align-middle text-muted">{{ $readers->firstItem() + $index }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle mr-3 text-white d-flex align-items-center justify-content-center font-weight-bold"
                                        style="width:38px; height:38px; border-radius:50%; flex-shrink:0; font-size:15px;
                                        background-color: {{ ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'][crc32($reader->name) % 5] }};">
                                        {{ strtoupper(substr($reader->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-gray-800">{{ $reader->name }}</div>
                                        @if($reader->author_request === 'pending')
                                            <div class="small text-warning">
                                                <i class="fas fa-exclamation-circle mr-1"></i>Ada pengajuan author
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-muted">
                                <i class="fas fa-envelope fa-fw mr-1 text-gray-400"></i>{{ $reader->email }}
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-pill badge-info px-3 py-2" style="font-size:12px;">
                                    <i class="fas fa-book-open mr-1"></i>{{ $reader->reading_histories_count ?? 0 }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                @if($reader->author_request === 'pending')
                                    <span class="badge badge-pill badge-warning px-3 py-2">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($reader->author_request === 'approved')
                                    <span class="badge badge-pill badge-success px-3 py-2">
                                        <i class="fas fa-check mr-1"></i>Approved
                                    </span>
                                @elseif($reader->author_request === 'rejected')
                                    <span class="badge badge-pill badge-danger px-3 py-2">
                                        <i class="fas fa-times mr-1"></i>Rejected
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($reader->is_active)
                                    <span class="badge badge-pill badge-success px-3 py-2">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge badge-pill badge-danger px-3 py-2">
                                        <i class="fas fa-ban mr-1"></i>Diblokir
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-center small text-muted">
                                {{ $reader->created_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.reader.show', $reader->id) }}"
                                    class="btn btn-sm btn-info" title="Detail"
                                    style="width:32px; height:32px; padding:0; line-height:32px;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($reader->author_request === 'pending')
                                <a href="{{ route('admin.reader.show', $reader->id) }}"
                                    class="btn btn-sm btn-warning" title="Review Pengajuan"
                                    style="width:32px; height:32px; padding:0; line-height:32px;">
                                    <i class="fas fa-clipboard-check"></i>
                                </a>
                                @endif

                                @php $aksi = $reader->is_active ? 'memblokir' : 'mengaktifkan'; @endphp
                                <form action="{{ route('admin.reader.block', $reader->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin {{ $aksi }} reader ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $reader->is_active ? 'btn-danger' : 'btn-success' }}"
                                        title="{{ $reader->is_active ? 'Blokir' : 'Aktifkan' }}"
                                        style="width:32px; height:32px; padding:0; line-height:32px;">
                                        <i class="fas fa-{{ $reader->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-user-slash fa-3x mb-3 d-block text-gray-300"></i>
                                    <p class="mb-1 font-weight-bold">Tidak ada data reader</p>
                                    <small>Coba ubah filter atau kata kunci pencarian</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($readers->total() > 0)
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center py-3 px-4">
            <div class="text-muted small">
                Menampilkan <strong>{{ $readers->firstItem() ?? 0 }}</strong> &ndash; <strong>{{ $readers->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $readers->total() }}</strong> reader
            </div>
            <div>{{ $readers->links() }}</div>
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