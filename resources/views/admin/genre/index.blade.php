@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Genre</h1>
                <p class="mb-0 text-muted small mt-1">Kelola kategori genre novel di platform</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Genre</li>
            </ol>
        </div>

        {{-- Alerts --}}
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

        {{-- Stats + Add Button Row --}}
        <div class="row mb-4 align-items-stretch">
            <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Genre</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $genres->count() }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-tags fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Novel</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $genres->sum('novels_count') }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-book fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
                <div class="card shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <a href="{{ route('admin.genre.create') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Genre Baru
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4 mb-xl-0">
                <div class="card shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
                    <div class="card-body d-flex align-items-center">
                        <div class="w-100">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Urutkan Berdasarkan Novel
                            </div>
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="?sort=desc"
                                    class="btn {{ request('sort', 'desc') === 'desc' ? 'btn-info text-white' : 'btn-outline-info' }}">
                                    <i class="fas fa-sort-amount-down mr-1"></i>Terbanyak
                                </a>
                                <a href="?sort=asc"
                                    class="btn {{ request('sort') === 'asc' ? 'btn-info text-white' : 'btn-outline-info' }}">
                                    <i class="fas fa-sort-amount-up mr-1"></i>Tersedikit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Genre Table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-2"></i>Daftar Genre
                </h6>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background-color: #f8f9fc;">
                            <tr>
                                <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width:50px;">No</th>
                                <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Nama Genre
                                </th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">
                                    Jumlah Novel</th>
                                <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600"
                                    style="width:160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($genres as $i => $genre)
                                <tr>
                                    <td class="px-4 align-middle text-muted">{{ $i + 1 }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 d-flex align-items-center justify-content-center text-white rounded"
                                                style="width:36px; height:36px; flex-shrink:0; font-size:14px;
                                        background-color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#fd7e14', '#6f42c1'][$i % 8] }};">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <span class="font-weight-bold text-gray-800">{{ $genre->nama_genre }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        @php $count = $genre->novels_count ?? 0; @endphp
                                        <span
                                            class="badge badge-pill px-3 py-2 {{ $count > 0 ? 'badge-primary' : 'badge-secondary' }}"
                                            style="font-size:12px;">
                                            <i class="fas fa-book mr-1"></i>{{ $count }} novel
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.genre.edit', $genre->id) }}"
                                            class="btn btn-sm btn-warning mr-1" title="Edit Genre"
                                            style="width:32px; height:32px; padding:0; line-height:32px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.genre.destroy', $genre->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus genre {{ $genre->nama_genre }}? Novel yang terkait akan kehilangan genre ini.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Genre"
                                                style="width:32px; height:32px; padding:0; line-height:32px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-tags fa-3x mb-3 d-block text-gray-300"></i>
                                            <p class="mb-1 font-weight-bold">Belum ada genre</p>
                                            <small>Klik tombol "Tambah Genre Baru" untuk menambahkan genre pertama.</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
