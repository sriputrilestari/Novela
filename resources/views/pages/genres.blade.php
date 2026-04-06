@extends('layouts.app')
@section('title', 'Novela – Genre')

@section('content')

    {{-- ═══ GENRE HERO ═══ --}}
    <div class="genres-hero">
        <div class="genres-hero-title">📚 Semua Genre</div>
        <div class="genres-hero-sub">Temukan novel sesuai genre favoritmu</div>
    </div>

    <div class="content-wrap">

        @php
            $genres = \App\Models\Genre::withCount([
                'novels' => fn($q) => $q->where('approval_status', 'published'),
            ])->get();

            // Emoji per genre
            $genreEmoji = [
                'Fantasy' => '🧙',
                'Romance' => '💕',
                'Action' => '⚔️',
                'Horror' => '👻',
                'Mystery' => '🔍',
                'Sci-Fi' => '🚀',
                'Isekai' => '🌀',
                'School Life' => '🏫',
                'Slice of Life' => '☀️',
                'Xianxia' => '🐉',
                'Historical' => '📜',
                'System' => '💻',
                'Thriller' => '😱',
                'Comedy' => '😄',
                'Drama' => '🎭',
                'Adventure' => '🗺️',
            ];
        @endphp

        @if ($genres->isEmpty())
            <div class="empty-state">
                <div class="icon">📂</div>
                <p>Belum ada genre.</p>
            </div>
        @else
            <div class="genre-cards-grid">
                @foreach ($genres as $genre)
                    <a href="{{ route('genre.show', $genre->id) }}" class="genre-card-item">
                        <div class="genre-card-top">
                            <span style="position:relative;z-index:1;filter:drop-shadow(0 2px 8px rgba(0,0,0,0.5))">
                                {{ $genreEmoji[$genre->nama_genre] ?? '📖' }}
                            </span>
                        </div>
                        <div class="genre-card-bottom">
                            <div class="genre-card-name">{{ $genre->nama_genre }}</div>
                            <div class="genre-card-count">{{ $genre->novels_count }} novel</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
@endsection
