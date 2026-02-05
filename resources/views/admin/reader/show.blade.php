@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Reader</h1>
        <a href="{{ route('admin.reader.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Reader</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($reader->profile_photo)
                            <img src="{{ asset('storage/' . $reader->profile_photo) }}" 
                                 class="rounded-circle" 
                                 width="150" 
                                 height="150" 
                                 style="object-fit: cover; border: 3px solid #4e73df;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                                 style="width: 150px; height: 150px; font-size: 60px; border: 3px solid #4e73df;">
                                {{ strtoupper(substr($reader->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="mb-1">{{ $reader->name }}</h4>
                    <p class="text-muted mb-2">{{ $reader->email }}</p>
                    
                    <!-- Status Badge -->
                    <div class="mb-3">
                        @if($reader->is_active)
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                        @else
                            <span class="badge badge-danger badge-lg">
                                <i class="fas fa-ban"></i> Diblokir
                            </span>
                        @endif

                        @if($reader->author_request === 'pending')
                            <span class="badge badge-warning badge-lg">
                                <i class="fas fa-clock"></i> Pengajuan Author Pending
                            </span>
                        @elseif($reader->author_request === 'rejected')
                            <span class="badge badge-danger badge-lg">
                                <i class="fas fa-times-circle"></i> Pengajuan Ditolak
                            </span>
                        @endif
                    </div>

                    <hr>

                    <!-- Additional Info -->
                    <div class="text-left">
                        <p class="mb-2">
                            <strong>Tanggal Bergabung:</strong><br>
                            <i class="fas fa-calendar-alt text-primary"></i> 
                            {{ $reader->created_at->format('d M Y') }}
                        </p>
                        <p class="mb-2">
                            <strong>Terakhir Update:</strong><br>
                            <i class="fas fa-clock text-info"></i> 
                            {{ $reader->updated_at->diffForHumans() }}
                        </p>
                        @if($reader->author_request_date)
                        <p class="mb-0">
                            <strong>Tanggal Pengajuan Author:</strong><br>
                            <i class="fas fa-paper-plane text-warning"></i> 
                            {{ \Carbon\Carbon::parse($reader->author_request_date)->format('d M Y H:i') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    
                    @if($reader->author_request === 'pending')
                    <!-- Approve / Reject Author Request -->
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> Reader ini mengajukan menjadi Author
                    </div>

                    <form action="{{ route('admin.reader.approve', $reader->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Setujui pengajuan menjadi Author?')">
                            <i class="fas fa-check"></i> Setujui Jadi Author
                        </button>
                    </form>

                    <form action="{{ route('admin.reader.reject', $reader->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Tolak pengajuan Author?')">
                            <i class="fas fa-times"></i> Tolak Pengajuan
                        </button>
                    </form>

                    <hr>
                    @endif

                    <!-- Block / Unblock User -->
                    <form action="{{ route('admin.reader.block', $reader->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin {{ $reader->is_active ? 'memblokir' : 'mengaktifkan' }} reader ini?')">
                        @csrf
                        <button type="submit" class="btn btn-{{ $reader->is_active ? 'danger' : 'success' }} btn-block">
                            <i class="fas fa-{{ $reader->is_active ? 'ban' : 'check' }}"></i> 
                            {{ $reader->is_active ? 'Blokir Reader' : 'Aktifkan Reader' }}
                        </button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Activity & Statistics -->
        <div class="col-lg-8">
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Baca
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $reader->reading_histories_count ?? 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Komentar
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $reader->comments_count ?? 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Rating Diberikan
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $reader->ratings_count ?? 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reading History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Bacaan Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Novel</th>
                                    <th>Chapter</th>
                                    <th>Terakhir Baca</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($readingHistories ?? [] as $history)
                                <tr>
                                    <td>{{ $history->novel->judul ?? '-' }}</td>
                                    <td>Chapter {{ $history->chapter->nomor_chapter ?? '-' }}</td>
                                    <td>{{ $history->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Belum ada riwayat bacaan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Comments Activity -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Komentar Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Novel</th>
                                    <th>Komentar</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comments ?? [] as $comment)
                                <tr>
                                    <td>{{ $comment->novel->judul ?? '-' }}</td>
                                    <td>{{ Str::limit($comment->content, 50) }}</td>
                                    <td>{{ $comment->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Belum ada komentar
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Author Request Notes (if any) -->
            @if($reader->author_request_note)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-sticky-note"></i> Catatan Pengajuan Author
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $reader->author_request_note }}</p>
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection

@section('styles')
<style>
    .badge-lg {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endsection