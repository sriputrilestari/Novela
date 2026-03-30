@extends('author.layouts.app')

@section('content')

<h3 class="mb-4">Detail Komentar</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <h5>{{ $comment->chapter->novel->title }}</h5>
        <small class="text-muted">
            Chapter: {{ $comment->chapter->judul_chapter }}
        </small>

        <hr>

        <div class="p-3 bg-light rounded mb-3">
            <strong>{{ $comment->user->name }}</strong>
            <small class="text-muted">
                {{ $comment->created_at->diffForHumans() }}
            </small>
            <div class="mt-2">
                {{ $comment->komentar }}
            </div>
        </div>

        <h6 class="mb-3">Balasan</h6>

        @forelse($comment->replies as $reply)
            <div class="mb-2 p-3 rounded 
                @if($reply->user->id === auth()->id()) 
                    bg-primary text-white 
                @else 
                    bg-light 
                @endif">
                
                <strong>{{ $reply->user->name }}</strong>
                <small class="@if($reply->user->id === auth()->id()) text-white-50 @else text-muted @endif">
                    {{ $reply->created_at->diffForHumans() }}
                </small>

                <div class="mt-1">
                    {{ $reply->komentar }}
                </div>
            </div>
        @empty
            <div class="text-muted">Belum ada balasan.</div>
        @endforelse

        <hr>

        <form action="{{ route('author.comment.reply', $comment->id) }}" method="POST">
            @csrf
            <div class="mb-2">
                <textarea name="komentar" class="form-control" rows="3"
                          placeholder="Tulis balasan..." required></textarea>
            </div>
            <button class="btn btn-success">Kirim Balasan</button>
            <a href="{{ route('author.comment.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection