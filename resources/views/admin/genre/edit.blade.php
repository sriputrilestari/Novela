@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Manajemen Genre</h1>

    @if(session('success'))
        <div id="alert-success" class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div id="alert-error" class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <a href="{{ route('admin.genre.create') }}" class="btn btn-primary mb-3">Tambah Genre</a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Genre</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Genre</th>
                            <th>Jumlah Novel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($genres as $genre)
                        <tr>
                            <td>{{ $genre->nama_genre }}</td>
                            <td>{{ $genre->novels_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.genre.edit', $genre->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.genre.destroy',$genre->id) }}"
                                      method="POST" style="display:inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus genre ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($genres->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
