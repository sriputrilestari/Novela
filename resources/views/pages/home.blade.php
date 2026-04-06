@extends('layouts.app')
@section('title', 'Novela – Beranda')

@section('content')

    {{-- ═══ HERO BANNER (Novel Pilihan = rating tertinggi) ═══ --}}
    @if ($featured)
        <div class="hero-banner">
            <div class="hero-content">
                <div class="hero-badge">✦ Novel Pilihan</div>
                <div class="hero-title">{{ $featured->judul }}</div>
                <div class="hero-author">oleh <strong>{{ $featured->author->name }}</strong></div>
                <div class="hero-desc">{{ Str::limit($featured->sinopsis, 200) }}</div>
                <div class="hero-meta">
                    {{-- Bintang diperbaiki --}}
                    <span class="hero-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($featured->rating) ? 's-on' : 's-off' }}">★</span>
                        @endfor
                    </span>
                    <span class="hero-rating">{{ number_format($featured->rating, 1) }}
                        ({{ $featured->total_rating }})</span>
                    <span class="hero-tag">{{ $featured->genre->nama_genre }}</span>
                    <span class="hero-tag">{{ ucfirst($featured->status) }}</span>
                    <span class="hero-chapter">{{ $featured->chapters_count ?? $featured->chapters->count() }}
                        Chapter</span>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('novel.show', $featured->id) }}" class="btn-primary">▶ Mulai Baca</a>
                    <a href="{{ route('novel.show', $featured->id) }}" class="btn-secondary">ⓘ Detail Novel</a>
                    @auth
                        <form method="POST" action="{{ route('bookmark.toggle', $featured->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-secondary">❤️ Favorit</button>
                        </form>
                    @endauth
                </div>
            </div>
            <div class="hero-image">
                @if ($featured->cover)
                    <img src="{{ asset('storage/' . $featured->cover) }}" alt="{{ $featured->judul }}" />
                @else
                    <div class="hero-cover-placeholder">📖</div>
                @endif
            </div>
        </div>
    @endif

    <div class="content-wrap">

        {{-- ═══ STATS ═══ --}}
        @auth
            {{-- ═══ LANJUTKAN MEMBACA ═══ --}}
            {{-- @if ($readingHistory->isNotEmpty())
                <div class="section-header">
                    <div class="section-title">Lanjutkan Membaca</div>
                    <a class="see-all" href="{{ route('history') }}">Lihat Semua →</a>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px;margin-bottom:32px">
                    @foreach ($readingHistory as $history)
                        <div class="reading-item">
                            <div class="reading-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card))">
                                @if ($history->chapter->novel->cover)
                                    <img src="{{ asset('storage/' . $history->chapter->novel->cover) }}" alt="" />
                                @else
                                    📖
                                @endif
                            </div>
                            <div class="reading-info">
                                <div class="reading-title">{{ $history->chapter->novel->judul }}</div>
                                <div class="reading-author">{{ $history->chapter->novel->author->name }} ·
                                    {{ $history->chapter->novel->genre->nama_genre }}</div>
                                <div class="reading-actions mt-8">
                                    <a href="{{ route('chapter.show', $history->chapter->id) }}" class="btn-sm">▶ Lanjutkan
                                        Ch.{{ $history->chapter->urutan }}</a>
                                </div>
                            </div>
                            <div class="reading-right">
                                <span class="text-xs text-muted">{{ $history->last_read_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif --}}
        @endauth

        {{-- ═══ NOVEL TERBARU — muncul dari kiri (urut created_at DESC) ═══ --}}
        <div class="section-header">
            <div class="section-title">🆕 Novel Terbaru</div>
            <a class="see-all" href="{{ route('search') }}">Lihat Semua →</a>
        </div>
        <div class="novel-grid mb-32">
            @forelse($latestNovels as $novel)
                <a href="{{ route('novel.show', $novel->id) }}" class="novel-card">
                    <div class="novel-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card))">
                        @if ($novel->cover)
                            <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->judul }}" />
                        @else
                            📖
                        @endif
                        <div class="novel-cover-overlay"></div>
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">{{ $novel->judul }}</div>
                        <div class="novel-author">{{ $novel->author->name }}</div>
                        <span class="novel-genre">{{ $novel->genre->nama_genre }}</span>
                        {{-- Bintang diperbaiki --}}
                        <div class="novel-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= round($novel->rating) ? 'star-filled' : 'star-empty' }}">★</span>
                            @endfor
                            <span>{{ number_format($novel->rating, 1) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state" style="grid-column:1/-1">
                    <div class="icon">📭</div>
                    <p>Belum ada novel.</p>
                </div>
            @endforelse
        </div>

        {{-- ═══ NOVEL POPULER — diambil dari views terbanyak ═══ --}}
        <div class="section-header">
            <div class="section-title">🔥 Novel Populer</div>
            <a class="see-all" href="{{ route('search') }}">Lihat Semua →</a>
        </div>
        <div class="novel-list mb-32">
            @forelse($popularNovels as $i => $novel)
                <a href="{{ route('novel.show', $novel->id) }}" class="novel-list-item">
                    {{-- Rank badge warna berbeda top 3 --}}
                    <div class="rank-badge"
                        style="
        @if ($i == 0) background:linear-gradient(135deg,#f0c040,#c8920a);color:#1a0e00;
        @elseif($i == 1) background:linear-gradient(135deg,#b0b8c8,#6a7080);color:#fff;
        @elseif($i == 2) background:linear-gradient(135deg,#c87941,#7a3a10);color:#fff;
        @else background:var(--bg-mid);color:var(--text-muted); @endif
      ">
                        {{ $i + 1 }}</div>
                    <div class="list-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card))">
                        @if ($novel->cover)
                            <img src="{{ asset('storage/' . $novel->cover) }}" alt="" />
                        @else
                            📖
                        @endif
                    </div>
                    <div class="list-info">
                        <div class="list-title">{{ $novel->judul }}</div>
                        <div class="list-meta">{{ $novel->author->name }} · {{ $novel->chapters_count ?? 0 }} Chapter
                        </div>
                        <div class="list-tags">
                            <span class="tag">{{ $novel->genre->nama_genre }}</span>
                            <span class="tag tag-gold">★ {{ number_format($novel->rating, 1) }}</span>
                            @if ($novel->status === 'completed')
                                <span class="tag tag-green">Tamat</span>
                            @else
                                <span class="tag">Ongoing</span>
                            @endif
                        </div>
                    </div>
                    <div class="list-right">
                        <span class="text-muted text-sm">👁 {{ number_format($novel->views) }}</span>
                        <span class="btn-sm">Baca</span>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <p>Belum ada novel populer.</p>
                </div>
            @endforelse
        </div>

    </div>{{-- /content-wrap --}}
@endsection
