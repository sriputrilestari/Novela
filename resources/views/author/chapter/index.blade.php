@extends('author.layouts.app')

@section('content')
<h1 class="h3 mb-4">Chapter - {{ $novel->title }}</h1>

<a href="{{ route('author.chapter.create',$novel->id) }}" class="btn btn-primary mb-3">
    + Tambah Chapter
</a>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @foreach($chapters as $chapter)
            <tr>
                <td>{{ $chapter->title }}</td>
                <td>
                    <span class="badge {{ $chapter->status == 'publish' ? 'badge-success' : 'badge-secondary' }}">
                        {{ ucfirst($chapter->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('author.chapter.edit',$chapter->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('author.chapter.destroy',$chapter->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
