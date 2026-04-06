@extends('layouts.app')

@section('content')

<div class="section-header">
    <div class="section-title">🔥 Novel Terbaru</div>
</div>

<div class="novel-grid">
    @foreach($novels as $novel)
        <div class="novel-card" onclick="window.location='{{ route('novel.show', $novel->id) }}'">
            <div class="novel-cover" style="background: linear-gradient(135deg, var(--bg-mid), var(--bg-card))">
                📖
                <div class="novel-cover-overlay"></div>
            </div>
            <div class="novel-info">
                <div class="novel-title">{{ $novel->judul }}</div>
                <div class="novel-author">{{ $novel->penulis ?? 'Anonim' }}</div>
                <div class="novel-genre">{{ $novel->genre ?? 'Novel' }}</div>
                <p class="text-muted text-sm mt-8">{{ Str::limit($novel->sinopsis, 80) }}</p>
                <div class="reading-actions mt-8">
                    <a href="{{ route('novel.show', $novel->id) }}" class="btn-sm">▶ Baca</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection