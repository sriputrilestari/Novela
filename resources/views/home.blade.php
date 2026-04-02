@extends('layouts.app')

@section('content')

<h3 class="mb-4">🔥 Novel Terbaru</h3>

<div class="row">
@foreach($novels as $novel)
    <div class="col-md-3 mb-4">
        <div class="card bg-dark border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">{{ $novel->judul }}</h6>
                <p class="text-secondary small">{{ Str::limit($novel->sinopsis, 80) }}</p>

                <a href="{{ route('novel.show', $novel->id) }}" class="btn btn-primary btn-sm">
                    Baca
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>

@endsection