@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Reader</h1>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Reader
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $readers->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pengajuan Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('author_request', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Reader Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('is_active', true)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Reader Diblokir
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::where('role', 'user')->where('is_active', false)->count() }}
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

    <!-- Reader Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Reader</h6>
            <div>
                <!-- Filter Dropdown -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?filter=all">Semua Reader</a>
                        <a class="dropdown-item" href="?filter=pending">Pengajuan Pending</a>
                        <a class="dropdown-item" href="?filter=active">Reader Aktif</a>
                        <a class="dropdown-item" href="?filter=blocked">Reader Diblokir</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Total Baca</th>
                            <th>Status Author</th>
                            <th>Status Akun</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($readers as $index => $reader)
                        <tr>
                            <td>{{ $readers->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $reader->name }}</strong>
                                @if($reader->author_request === 'pending')
                                <br><small class="text-warning">
                                    <i class="fas fa-exclamation-circle"></i> Ada pengajuan author
                                </small>
                                @endif
                            </td>
                            <td>{{ $reader->email }}</td>
                            <td class="text-center">
                                <span class="badge badge-info badge-pill">
                                    {{ $reader->reading_histories_count ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @if($reader->author_request === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @elseif($reader->author_request === 'approved')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> Approved
                                    </span>
                                @elseif($reader->author_request === 'rejected')
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge badge-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                @if($reader->is_active)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-ban"></i> Diblokir
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $reader->created_at?->format('d M Y') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.reader.show', $reader->id) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($reader->author_request === 'pending')
                                <a href="{{ route('admin.reader.show', $reader->id) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Review">
                                    <i class="fas fa-clipboard-check"></i>
                                </a>
                                @endif

                                <form action="{{ route('admin.reader.block', $reader->id) }}" 
                                      method="POST" 
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin ubah status reader ini?')">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm {{ $reader->is_active ? 'btn-danger' : 'btn-success' }}"
                                            title="{{ $reader->is_active ? 'Blokir' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $reader->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Tidak ada data reader
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Menampilkan {{ $readers->firstItem() ?? 0 }} - {{ $readers->lastItem() ?? 0 }} 
                    dari {{ $readers->total() }} reader
                </div>
                <div>
                    {{ $readers->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable (optional)
    // $('#dataTable').DataTable({
    //     "pageLength": 20,
    //     "ordering": true,
    //     "searching": true
    // });

    // Auto dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endsection 