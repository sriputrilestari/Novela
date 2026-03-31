@extends('author.layouts.app')

@section('content')

<style>
/* ===== FILTER MODERN ===== */
.filter-bar{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    align-items:center;
}
.filter-select{
    appearance:none;
    border:1px solid #e0e4ef;
    background:#fff;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    color:#5a5f7a;
    cursor:pointer;
    transition:.2s;
    min-width:140px;
}
.filter-select:hover{
    border-color:#3d5af1;
}
.filter-select:focus{
    outline:none;
    border-color:#3d5af1;
    box-shadow:0 0 0 3px rgba(61,90,241,0.1);
}
.filter-reset{
    border:none;
    background:#f1f3ff;
    color:#3d5af1;
    font-weight:600;
    font-size:12px;
    padding:8px 14px;
    border-radius:999px;
    cursor:pointer;
    transition:.2s;
}
.filter-reset:hover{
    background:#3d5af1;
    color:#fff;
}
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-gray-800">Novel Saya</h1>
            <small class="text-muted">Kelola novel kamu dengan mudah</small>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $total = $novels->count();
        $published = $novels->where('approval_status','published')->count();
        $pending = $novels->where('approval_status','pending')->count();
        $rejected = $novels->where('approval_status','rejected')->count();
    @endphp

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs text-primary font-weight-bold">Total</div>
                    <div class="h5 font-weight-bold">{{ $total }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-warning shadow py-2">
                <div class="card-body">
                    <div class="text-xs text-warning font-weight-bold">Pending</div>
                    <div class="h5 font-weight-bold">{{ $pending }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <div class="text-xs text-success font-weight-bold">Published</div>
                    <div class="h5 font-weight-bold">{{ $published }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-left-danger shadow py-2">
                <div class="card-body">
                    <div class="text-xs text-danger font-weight-bold">Rejected</div>
                    <div class="h5 font-weight-bold">{{ $rejected }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">

            <h6 class="m-0 font-weight-bold text-primary">Daftar Novel</h6>

            {{-- FILTER --}}
            <form method="GET" class="filter-bar">

                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Status Cerita</option>
                    <option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>Ongoing</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                </select>

                <select name="approval" class="filter-select" onchange="this.form.submit()">
                    <option value="">Approval</option>
                    <option value="pending" {{ request('approval')=='pending'?'selected':'' }}>Pending</option>
                    <option value="published" {{ request('approval')=='published'?'selected':'' }}>Published</option>
                    <option value="rejected" {{ request('approval')=='rejected'?'selected':'' }}>Rejected</option>
                </select>

                <select name="genre" class="filter-select" onchange="this.form.submit()">
                    <option value="">Genre</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->id }}" {{ request('genre')==$g->id?'selected':'' }}>
                            {{ $g->nama_genre }}
                        </option>
                    @endforeach
                </select>

                @if(request('status') || request('approval') || request('genre'))
                    <a href="{{ route('author.novel.index') }}" class="filter-reset">Reset</a>
                @endif

            </form>

            <a href="{{ route('author.novel.create') }}" class="btn btn-sm btn-primary">
                + Tambah
            </a>

        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Genre</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($novels as $novel)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    @if($novel->cover)
                                        <img src="{{ asset('storage/'.$novel->cover) }}"
                                             class="rounded mr-2"
                                             style="width:40px;height:55px;object-fit:cover;">
                                    @endif
                                    <div>
                                        <div class="font-weight-bold">{{ $novel->judul }}</div>
                                        <small class="text-muted">{{ $novel->views ?? 0 }} views</small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $novel->genre->nama_genre ?? '-' }}</td>

                            <td>
                                <span class="badge badge-info">{{ $novel->status }}</span>
                            </td>

                            <td>
                                @if($novel->approval_status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($novel->approval_status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('author.chapter.index',$novel->id) }}"
                                   class="btn btn-sm btn-primary">Chapter</a>

                                <a href="{{ route('author.novel.edit',$novel->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>

                                <form id="delete-{{ $novel->id }}"
                                      action="{{ route('author.novel.destroy',$novel->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="if(confirm('Hapus novel ini?')) document.getElementById('delete-{{ $novel->id }}').submit()">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada novel
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