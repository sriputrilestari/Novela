@extends('author.layouts.app')

@section('content')
<h1 class="h3 mb-4">Komentar Pembaca</h1>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Novel</th>
                <th>User</th>
                <th>Komentar</th>
                <th>Aksi</th>
            </tr>

            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->novel->title }}</td>
                <td>{{ $comment->user->name }}</td>
                <td>{{ $comment->content }}</td>
                <td>
                    <form action="{{ route('author.comment.destroy',$comment->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
