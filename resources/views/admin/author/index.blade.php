@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Data Reader</h1>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Reader</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jumlah Novel</th>
                            <th>Status</th>
                            <th>Blocked</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                        @foreach($authors as $author)
                        <tr>
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->email }}</td>
                            <td>{{ $author->novels_count }}</td>
                            <td>{{ $author->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $author->is_blocked ? 'Yes' : 'No' }}</td>
                            <td>
                                <form action="{{ route('admin.authors.toggle', $author->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning">{{ $author->is_active ? 'Nonaktif' : 'Aktif' }}</button>
                                </form>

                                <form action="{{ route('admin.authors.block', $author->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Blokir</button>
                                </form>

                                <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-secondary">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

