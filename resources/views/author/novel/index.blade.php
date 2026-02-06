@extends('author.layouts.app')

@section('content')
<h1 class="h3 mb-4">Novel Saya</h1>

<a href="{{ route('author.novel.create') }}" class="btn btn-primary mb-3">
    + Tambah Novel
</a>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Judul</th>
                <th>Genre</th>
                <th>Cover</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <div class="row">
                @foreach($novels as $novel)
                    <div class="col-md-3">
                        <div class="card mb-4 shadow">

                            <img
                                src="{{ $novel->cover ? asset('storage/'.$novel->cover) : asset('backend/img/no-image.png') }}"
                                class="card-img-top"
                                style="height: 220px; object-fit: cover;"
                            >

                            <div class="card-body">
                                <h6>{{ $novel->judul }}</h6>
                                <span class="badge badge-warning">
                                    {{ ucfirst($novel->approval_status) }}
                                </span>

                                <div class="mt-2">
                                    <a href="{{ route('author.novel.edit', $novel->id) }}"
                                    class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                </div>
        </table>
    </div>
</div>
@endsection
