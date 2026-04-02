{{-- resources/views/pages/search.blade.php --}}
@extends('layouts.main')
@section('title', 'Jelajahi – Novela')

@section('content')

    <div class="search-hero">
        <div style="color:rgba(255,255,255,.7);font-size:.85rem;margin-bottom:8px">
            Temukan cerita favoritmu
        </div>

        <div class="search-big-wrap">
            <span class="search-big-icon">🔍</span>
            <form action="{{ route('search') }}" method="GET" style="flex:1">
                <input class="search-big" name="q" placeholder="Cari judul, penulis, atau genre..."
                    value="{{ request('q') }}" autofocus />
            </form>
        </div>

        {{-- FILTER GENRE --}}
        <div class="filter-row" style="display:flex;flex-wrap:wrap;gap:10px;margin-top:12px">

            {{-- SEMUA --}}
            <a href="{{ route('search') }}" class="filter-chip {{ !request('genre') ? 'active' : '' }}">
                📚 Semua
            </a>

            {{-- GENRE DARI DATABASE --}}
            @foreach ($genres as $g)
                <a href="{{ route('search') }}?genre={{ $g->nama_genre }}"
                    class="filter-chip {{ request('genre') == $g->nama_genre ? 'active' : '' }}">

                    <span class="dot"></span>
                    {{ $g->nama_genre }}
                </a>
            @endforeach

        </div>
    </div>
    </div>

    <div class="content-wrap">

        {{-- TITLE --}}
        <div class="section-header mb-16">
            <div class="section-title">
                @if (request('q'))
                    Hasil pencarian: "{{ request('q') }}"
                @elseif(request('genre'))
                    Genre: {{ request('genre') }}
                @elseif(isset($genreName))
                    Genre: {{ $genreName }}
                @else
                    Semua Novel
                @endif
            </div>

            <span class="text-muted text-sm">
                {{ $novels->total() ?? 0 }} hasil
            </span>
        </div>

        {{-- GRID NOVEL --}}
        <div class="novel-grid">
            @forelse($novels as $novel)
                <a href="{{ route('novel.show', $novel->id) }}" class="novel-card no-underline">
                    {{-- COVER --}}
                    <div class="novel-cover">
                        @if ($novel->cover)
                            <img src="{{ asset('storage/' . $novel->cover) }}" alt="cover">
                        @else
                            <div class="cover-placeholder">📚</div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="novel-info">

                        <div class="novel-meta-top">
                            <span class="genre-pill">
                                {{ $novel->genre->nama_genre ?? '-' }}
                            </span>
                        </div>

                        <div class="novel-title">
                            {{ $novel->judul }}
                        </div>

                        <div class="novel-author">
                            {{ $novel->author->name ?? 'Unknown Author' }}
                        </div>

                        <div class="novel-rating">
                            <span class="star">★</span>
                            <span>{{ number_format($novel->rating, 1) }}</span>
                        </div>

                    </div>
                </a>

            @empty
                <div class="empty-state">
                    📭 Tidak ada novel ditemukan
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($novels->hasPages())
            <div style="display:flex;justify-content:center;margin-top:32px">
                {{ $novels->links() }}
            </div>
        @endif

    </div>

@endsection
