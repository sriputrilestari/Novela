@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen Author</h1>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Author
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $authors->total() }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Author Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Author Diblokir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'author')->where('is_blocked', true)->count() }}
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

    <!-- Author Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Author</h6>
            <div>
                <!-- Filter Dropdown -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?filter=all">Semua Author</a>
                        <a class="dropdown-item" href="?filter=active">Author Aktif</a>
                        <a class="dropdown-item" href="?filter=blocked">Author Diblokir</a>
                        <a class="dropdown-item" href="?filter=pending">Author Pending</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jumlah Novel</th>
                            <th>Status Akun</th>
                            <th>Blocked</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($authors as $index => $author)
                        <tr>
                            <td>{{ $authors->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $author->name }}</strong>
                            </td>
                            <td>{{ $author->email }}</td>
                            <td class="text-center">{{ $author->novels_count }}</td>
                            <td>
                                @if($author->is_active)
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($author->is_blocked)
                                    <span class="badge badge-danger"><i class="fas fa-ban"></i> Diblokir</span>
                                @else
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Normal</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.authors.show', $author->id) }}" 
                                   class="btn btn-sm btn-info mr-2" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.authors.toggle', $author->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $author->is_active ? 'btn-danger' : 'btn-success' }}" 
                                            title="{{ $author->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $author->is_active ? 'times' : 'check' }}"></i>
                                    </button>
                                </form>
                                @if(!$author->is_blocked)
                                <form action="{{ route('admin.authors.block', $author->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning" 
                                            title="Blokir Author"
                                            onclick="return confirm('Yakin blokir author ini?')">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Tidak ada data author
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $authors->firstItem() ?? 0 }} - {{ $authors->lastItem() ?? 0 }} 
                    dari {{ $authors->total() }} author
                </div>
                <div>
                    {{ $authors->links() }}
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
