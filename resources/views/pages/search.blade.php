@extends('layouts.app')
@section('title', 'Novela - Jelajahi')

@section('content')
    <div class="search-hero">
        <div class="search-hero-label">Jelajahi Novel</div>
        <div class="search-hero-sub">Temukan cerita favoritmu dari ribuan judul menarik</div>

        <form action="{{ route('search') }}" method="GET">
            <div class="search-big-wrap">
                <span class="search-big-icon">🔍</span>
                <input
                    class="search-big"
                    name="q"
                    id="search-big-input"
                    placeholder="Cari judul, penulis, atau genre..."
                    value="{{ request('q') }}" />
            </div>

            <div class="filter-row">
                <button type="submit" name="genre" value="" class="filter-chip {{ !request('genre') ? 'active' : '' }}">
                    Semua
                </button>
                @foreach ($genres as $genre)
                    <button
                        type="submit"
                        name="genre"
                        value="{{ $genre->nama_genre }}"
                        class="filter-chip {{ request('genre') === $genre->nama_genre ? 'active' : '' }}">
                        {{ $genre->nama_genre }}
                    </button>
                @endforeach
            </div>
        </form>
    </div>

    <div class="content-wrap search-results-wrap">
        <div class="section-header search-results-head mb-16">
            <div class="section-title">
                @if (request('q'))
                    Hasil: "{{ request('q') }}"
                @elseif(request('genre'))
                    Genre: {{ request('genre') }}
                @else
                    Semua Novel
                @endif
            </div>
            <span class="text-muted text-sm">{{ $novels->total() }} novel ditemukan</span>
        </div>

        @if ($novels->isEmpty())
            <div class="empty-state">
                <div class="icon">📚</div>
                <p>Novel tidak ditemukan. Coba kata kunci lain.</p>
            </div>
        @else
            <div class="novel-grid novel-grid-search mb-32">
                @foreach ($novels as $novel)
                    <a href="{{ route('novel.show', $novel->id) }}" class="novel-card">
                        <div class="novel-cover">
                            @if ($novel->cover)
                                <img src="{{ asset('storage/' . ltrim($novel->cover, '/')) }}" alt="{{ $novel->judul }}" />
                            @else
                                <div class="hero-cover-placeholder">Cover</div>
                            @endif
                            <div class="novel-cover-overlay"></div>
                        </div>
                        <div class="novel-info">
                            <div class="novel-title">{{ $novel->judul }}</div>
                            <div class="novel-author">{{ $novel->author->name }}</div>
                            <div class="novel-meta-row">
                                <span class="novel-genre">{{ $novel->genre->nama_genre }}</span>
                                <span class="novel-status">{{ ucfirst($novel->status) }}</span>
                            </div>
                            <div class="novel-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= round($novel->rating) ? 'star-filled' : 'star-empty' }}">★</span>
                                @endfor
                                <span>{{ number_format($novel->rating, 1) }}</span>
                            </div>
                            <div class="novel-card-footer">
                                <span>{{ $novel->chapters_count ?? 0 }} chapter</span>
                                <span>{{ $novel->total_rating }} rating</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="search-pagination">
                {{ $novels->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
