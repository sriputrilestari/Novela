@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Author</h1>
                <p class="mb-0 text-muted small mt-1">Kelola seluruh author terdaftar di platform</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Author</li>
            </ol>
        </div>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg mr-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-lg mr-3"></i>
                    <div>{{ session('error') }}</div>
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
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Author</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $authors->total() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Author Aktif</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::where('role', 'author')->where('is_active', true)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Author Non-Aktif
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::where('role', 'author')->where('is_active', false)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-slash fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Author Diblokir</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::where('role', 'author')->where('is_active', false)->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ban fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Author Table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list mr-2"></i>Daftar Author
                        </h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        {{-- Search --}}
                        <form method="GET" action="" class="mr-2">
                            <div class="input-group input-group-sm" style="width: 220px;">
                                <input type="text" name="search" class="form-control border-0 shadow-sm"
                                    placeholder="Cari nama / email..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- Filter --}}
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                data-toggle="dropdown">
                                <i class="fas fa-filter mr-1"></i>
                                {{ request('filter') === 'active' ? 'Aktif' : (request('filter') === 'blocked' ? 'Diblokir' : 'Semua') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                <a class="dropdown-item {{ !request('filter') || request('filter') === 'all' ? 'active' : '' }}"
                                    href="?filter=all">
                                    <i class="fas fa-users fa-fw mr-2"></i>Semua Author
                                </a>
                                <a class="dropdown-item {{ request('filter') === 'active' ? 'active' : '' }}"
                                    href="?filter=active">
                                    <i class="fas fa-check-circle fa-fw mr-2 text-success"></i>Author Aktif
                                </a>
                                <a class="dropdown-item {{ request('filter') === 'blocked' ? 'active' : '' }}"
                                    href="?filter=blocked">
                                    <i class="fas fa-ban fa-fw mr-2 text-danger"></i>Author Diblokir
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
                                <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width: 50px;">No</th>
                                <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Author</th>
                                <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Email</th>
                                <th
                                    class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Novel</th>
                                <th
                                    class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Status Akun</th>
                                <th
                                    class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Blokir</th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($authors as $index => $author)
                                <tr>
                                    <td class="px-4 align-middle text-muted">
                                        {{ $authors->firstItem() + $index }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle mr-3 text-white d-flex align-items-center justify-content-center font-weight-bold"
                                                style="width:38px; height:38px; border-radius:50%; background-color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][crc32($author->name) % 5] }}; flex-shrink:0; font-size:15px;">
                                                {{ strtoupper(substr($author->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-gray-800">{{ $author->name }}</div>
                                                <div class="small text-muted">Bergabung
                                                    {{ $author->created_at?->format('d M Y') ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-muted">
                                        <i class="fas fa-envelope fa-fw mr-1 text-gray-400"></i>{{ $author->email }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-pill badge-primary px-3 py-2" style="font-size: 12px;">
                                            {{ $author->novels_count }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($author->is_active)
                                            <span class="badge badge-pill badge-success px-3 py-2">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-secondary px-3 py-2">
                                                <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if (!$author->is_active)
                                            <span class="badge badge-pill badge-danger px-3 py-2">
                                                <i class="fas fa-ban mr-1"></i>Diblokir
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-light border px-3 py-2 text-success">
                                                <i class="fas fa-shield-alt mr-1"></i>Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.author.show', $author->id) }}"
                                            class="btn btn-sm btn-info" title="Detail Author"
                                            style="width:32px; height:32px; padding:0; line-height:32px;">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.author.toggle', $author->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('{{ $author->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun author ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm {{ $author->is_active ? 'btn-warning' : 'btn-success' }}"
                                                title="{{ $author->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                style="width:32px; height:32px; padding:0; line-height:32px;">
                                                <i class="fas fa-{{ $author->is_active ? 'times' : 'check' }}"></i>
                                            </button>
                                        </form>

                                       @if ($author->is_active)
                                            <form action="{{ route('admin.author.block', $author->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Author akan diblokir dan tidak bisa login. Yakin?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    title="Blokir Author"
                                                    style="width:32px; height:32px; padding:0; line-height:32px;">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-user-slash fa-3x mb-3 d-block text-gray-300"></i>
                                            <p class="mb-1 font-weight-bold">Tidak ada data author</p>
                                            <small>Coba ubah filter atau kata kunci pencarian</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($authors->total() > 0)
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center py-3 px-4">
                    <div class="text-muted small">
                        Menampilkan <strong>{{ $authors->firstItem() ?? 0 }}</strong> &ndash;
                        <strong>{{ $authors->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $authors->total() }}</strong> author
                    </div>
                    <div>
                       {{ $authors->appends(request()->query())->links() }}
                    </div>
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
