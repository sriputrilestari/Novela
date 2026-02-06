@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Author</h1>

    {{-- INFO AUTHOR --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong>Informasi Author</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $author->name }}</p>
            <p><strong>Email:</strong> {{ $author->email }}</p>
            <p><strong>Status Akun:</strong>
                <span class="badge {{ $author->is_active ? 'badge-success' : 'badge-secondary' }}">
                    {{ $author->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
            <p><strong>Status Blokir:</strong>
                <span class="badge {{ $author->is_blocked ? 'badge-danger' : 'badge-success' }}">
                    {{ $author->is_blocked ? 'Blocked' : 'Normal' }}
                </span>
            </p>

                {{-- AKSI --}}
            <div class="mt-3">
                <form action="{{ route('admin.authors.toggle', $author->id) }}"
                    method="POST"
                    class="d-inline mr-2">
                    @csrf
                    <button class="btn btn-warning btn-sm">
                        {{ $author->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                    </button>
                </form>

                @if(!$author->is_blocked)
                <form action="{{ route('admin.authors.block', $author->id) }}"
                    method="POST"
                    class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Author akan diblokir dan tidak bisa login. Yakin?')">
                        Blokir Author
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- LIST NOVEL --}}
    <div class="card shadow">
        <div class="card-header">
            <strong>Daftar Novel Author</strong>
        </div>
        <div class="card-body">
            @if($author->novels->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status Approval</th>
                        <th>Views</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($author->novels as $novel)
                    <tr>
                        <td>{{ $novel->judul }}</td>
                        <td>{{ ucfirst($novel->approval_status) }}</td>
                        <td>{{ $novel->views }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p class="text-muted">Author ini belum memiliki novel.</p>
            @endif
        </div>
    </div>

</div>
@endsection
