@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen Novel</h1>

    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif
    @if(session('error')) 
        <div class="alert alert-danger">{{ session('error') }}</div> 
    @endif

    <!-- FILTER STATUS & GENRE -->
    <div class="mb-3">
        <form method="GET" action="{{ route('admin.novels.index') }}" class="form-inline">
            <label class="mr-2" for="status">Filter Status:</label>
            <select name="status" id="status" class="form-control mr-3" onchange="this.form.submit()">
                <option value="">Semua</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Published</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <label class="mr-2" for="genre">Filter Genre:</label>
            <select name="genre_id" id="genre" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->nama_genre }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Novel</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($novels as $novel)
                        <tr>
                            <td>{{ $novel->judul }}</td>
                            <td>{{ $novel->author?->name ?? '-' }}</td>
                            <td>
                                @if($novel->genre)
                                    <span class="badge badge-info">{{ $novel->genre->nama_genre }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    {{ $novel->approval_status == 'pending' ? 'badge-warning' : ($novel->approval_status == 'published' ? 'badge-success' : 'badge-danger') }}">
                                    {{ ucfirst($novel->approval_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.novels.edit',$novel->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.novels.destroy',$novel->id) }}" method="POST" style="display:inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus novel ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($novels->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
