@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Detail Author</h1>
                <p class="mb-0 text-muted small mt-1">Informasi lengkap dan aktivitas author</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.author.index') }}">Author</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg mr-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="row">
            {{-- LEFT: Profile Card --}}
            <div class="col-xl-4 col-lg-5 mb-4">

                {{-- Profile --}}
                <div class="card shadow mb-4">
                    <div class="card-body text-center pt-4 pb-3">
                        <div class="avatar-circle mx-auto mb-3 text-white d-flex align-items-center justify-content-center font-weight-bold"
                            style="width:80px; height:80px; border-radius:50%; font-size:32px;
                            background-color: {{ ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'][crc32($author->name) % 5] }};">
                            {{ strtoupper(substr($author->name, 0, 1)) }}
                        </div>
                        <h5 class="font-weight-bold text-gray-800 mb-1">{{ $author->name }}</h5>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-envelope mr-1"></i>{{ $author->email }}
                        </p>

                        {{-- Status Badges --}}
                        <div class="mb-3">
                            @if ($author->is_active)
                                <span class="badge badge-pill badge-success px-3 py-2 mr-1">
                                    <i class="fas fa-check-circle mr-1"></i>Akun Aktif
                                </span>
                            @else
                                <span class="badge badge-pill badge-secondary px-3 py-2 mr-1">
                                    <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                </span>
                            @endif

                            @if ($author->is_blocked)
                                <span class="badge badge-pill badge-danger px-3 py-2">
                                    <i class="fas fa-ban mr-1"></i>Diblokir
                                </span>
                            @else
                                <span class="badge badge-pill badge-light border px-3 py-2 text-success">
                                    <i class="fas fa-shield-alt mr-1"></i>Normal
                                </span>
                            @endif
                        </div>

                        <hr>

                        {{-- Stats Row --}}
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="h5 font-weight-bold text-gray-800 mb-0">{{ $author->novels->count() }}</div>
                                <div class="text-xs text-muted text-uppercase">Novel</div>
                            </div>
                            <div class="col-4 border-left border-right">
                                <div class="h5 font-weight-bold text-gray-800 mb-0">
                                    {{ $author->novels->sum('views') }}
                                </div>
                                <div class="text-xs text-muted text-uppercase">Views</div>
                            </div>
                            <div class="col-4">
                                <div class="h5 font-weight-bold text-gray-800 mb-0">
                                    {{ $author->novels->where('approval_status', 'approved')->count() }}
                                </div>
                                <div class="text-xs text-muted text-uppercase">Approved</div>
                            </div>
                        </div>
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
                                <span class="small font-weight-bold">{{ $author->created_at?->format('d M Y') ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-clock fa-fw mr-2"></i>Login Terakhir</span>
                                <span class="small font-weight-bold">
                                    {{ $author->last_login_at ? \Carbon\Carbon::parse($author->last_login_at)->format('d M Y') : '-' }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-user-tag fa-fw mr-2"></i>Role</span>
                                <span class="badge badge-primary px-3 py-1">Author</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <span class="text-muted small"><i class="fas fa-id-badge fa-fw mr-2"></i>ID</span>
                                <span class="small font-weight-bold text-muted">#{{ $author->id }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cog mr-2"></i>Manajemen Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Toggle Aktif --}}
                        <form action="{{ route('admin.author.toggle', $author->id) }}" method="POST" class="mb-2"
                            onsubmit="return confirm('{{ $author->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun author ini?')">
                            @csrf
                            <button type="submit" class="btn btn-block btn-sm {{ $author->is_active ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $author->is_active ? 'times-circle' : 'check-circle' }} mr-2"></i>
                                {{ $author->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                            </button>
                        </form>

                        {{-- Blokir --}}
                        @if (!$author->is_blocked)
                            <form action="{{ route('admin.author.block', $author->id) }}" method="POST" class="mb-2"
                                onsubmit="return confirm('Author akan diblokir dan tidak bisa login. Yakin?')">
                                @csrf
                                <button type="submit" class="btn btn-block btn-sm btn-danger">
                                    <i class="fas fa-ban mr-2"></i>Blokir Author
                                </button>
                            </form>
                        @endif

                        {{-- Kembali --}}
                        <a href="{{ route('admin.author.index') }}" class="btn btn-block btn-sm btn-light border mt-1">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>

            {{-- RIGHT: Novel List --}}
            <div class="col-xl-8 col-lg-7 mb-4">

                {{-- Novel Stats Mini --}}
                <div class="row mb-4">
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body py-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $author->novels->where('approval_status', 'pending')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body py-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $author->novels->where('approval_status', 'approved')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body py-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $author->novels->where('approval_status', 'rejected')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Novel --}}
                <div class="card shadow">
                    <div class="card-header py-3 d-flex align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-book mr-2"></i>Daftar Novel
                        </h6>
                        <span class="badge badge-primary badge-pill px-3">{{ $author->novels->count() }} novel</span>
                    </div>

                    <div class="card-body p-0">
                        @if ($author->novels->count())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead style="background-color: #f8f9fc;">
                                        <tr>
                                            <th class="border-0 px-4 py-3 text-xs font-weight-bold text-uppercase text-gray-600" style="width: 40px;">#</th>
                                            <th class="border-0 py-3 text-xs font-weight-bold text-uppercase text-gray-600">Judul Novel</th>
                                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Status</th>
                                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Views</th>
                                            <th class="border-0 py-3 text-center text-xs font-weight-bold text-uppercase text-gray-600">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($author->novels as $i => $novel)
                                            <tr>
                                                <td class="px-4 align-middle text-muted">{{ $i + 1 }}</td>
                                                <td class="align-middle">
                                                    <div class="font-weight-bold text-gray-800">{{ $novel->judul }}</div>
                                                    @if ($novel->created_at)
                                                        <div class="small text-muted">
                                                            <i class="fas fa-calendar-alt fa-fw mr-1"></i>{{ $novel->created_at->format('d M Y') }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    @php
                                                        $status = $novel->approval_status;
                                                        $badgeClass = match($status) {
                                                            'approved' => 'badge-success',
                                                            'pending'  => 'badge-warning',
                                                            'rejected' => 'badge-danger',
                                                            default    => 'badge-secondary',
                                                        };
                                                        $icon = match($status) {
                                                            'approved' => 'check-circle',
                                                            'pending'  => 'clock',
                                                            'rejected' => 'times-circle',
                                                            default    => 'question-circle',
                                                        };
                                                    @endphp
                                                    <span class="badge badge-pill {{ $badgeClass }} px-3 py-2">
                                                        <i class="fas fa-{{ $icon }} mr-1"></i>{{ ucfirst($status) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-gray-700 font-weight-bold">
                                                        <i class="fas fa-eye fa-fw text-gray-400 mr-1"></i>{{ number_format($novel->views) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if (Route::has('admin.novels.show'))
                                                        <a href="{{ route('admin.novels.show', $novel->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="Lihat Novel"
                                                            style="width:32px; height:32px; padding:0; line-height:30px;">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-3x text-gray-300 d-block mb-3"></i>
                                <p class="font-weight-bold text-muted mb-1">Belum ada novel</p>
                                <small class="text-muted">Author ini belum mempublikasikan novel apapun.</small>
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
        $(document).ready(function () {
            setTimeout(function () {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection