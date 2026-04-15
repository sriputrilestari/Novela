@extends('layouts.app')
@section('title', 'Novela - Beranda')

@php
    // Membagi data menjadi kelompok 5 untuk slider
    $latestSlides = $latestNovels->chunk(5);
    $popularSlides = $popularNovels->chunk(5);

    $sections = [
        [
            'id' => 'latest',
            'title' => 'Novel Terbaru',
            'slides' => $latestSlides,
            'route' => route('search'),
            'showViews' => false,
        ],
        [
            'id' => 'popular',
            'title' => 'Novel Populer',
            'slides' => $popularSlides,
            'route' => route('search', ['sort' => 'popular']),
            'showViews' => true,
        ],
    ];
@endphp

@section('content')

    {{-- State jika semua data kosong --}}
    @if (!$featured && $latestNovels->isEmpty() && $popularNovels->isEmpty())
        <div
            style="min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; flex-direction: column;">
            <div style="font-size: 40px; margin-bottom: 12px;">📚</div>
            <h2 style="font-size: 22px; font-weight: 600; margin-bottom: 6px;">Belum Ada Novel</h2>
            <p style="color: #aaa;">Saat ini belum ada novel yang dipublikasikan. ✨</p>
        </div>
    @endif

    {{-- HERO SECTION (Novel Terpopuler/Rating Tertinggi) --}}
    @if ($featured)
        <section class="hero-home-shell">
            <div class="hero-banner hero-banner-home">
                <div class="hero-copy-home">
                    <div class="hero-badge">Novel Terpopuler</div>
                    <div class="hero-title">{{ $featured->judul }}</div>
                    <div class="hero-author">oleh <strong>{{ $featured->author->name }}</strong></div>
                    <div class="hero-desc">
                        {{ \Illuminate\Support\Str::limit($featured->sinopsis, 180) }}
                    </div>

                    <div class="hero-meta">
                        <span class="hero-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <span
                                    class="novel-star {{ $i <= round($featured->rating ?? 0) ? 'star-filled' : 'star-empty' }}">★</span>
                            @endfor
                        </span>
                        <span class="hero-rating">{{ number_format($featured->rating ?? 0, 1) }}
                            ({{ $featured->total_rating ?? 0 }})</span>
                        <span class="hero-separator">•</span>
                        <span class="hero-tag">{{ $featured->genre->nama_genre ?? '-' }}</span>
                        <span class="hero-separator">•</span>
                        <span class="hero-tag">{{ ucfirst($featured->status ?? '') }}</span>
                        <span class="hero-separator">•</span>
                        <span class="hero-chapter">{{ $featured->chapters_count ?? 0 }} Chapter</span>
                    </div>

                    <div class="hero-actions">
                        <a href="{{ route('reader.read', $featured->id) }}" class="btn-primary">Mulai Baca</a>
                        <a href="{{ route('novel.show', $featured->id) }}" class="btn-secondary">Detail Novel</a>
                    </div>
                </div>

                <div class="hero-image hero-image-home">
                    @if ($featured->cover)
                        <img src="{{ asset('storage/' . ltrim($featured->cover, '/')) }}" alt="{{ $featured->judul }}" />
                    @else
                        <div class="hero-cover-placeholder">Cover Novel</div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- MAIN CONTENT (Slider Terbaru & Populer) --}}
    <div class="content-wrap content-wrap-home">
        @foreach ($sections as $section)
            @if ($section['slides']->isEmpty())
                @continue
            @endif

            <section class="novel-section novel-section-{{ $section['id'] }}">
                <div class="section-header">
                    <div class="section-title">{{ $section['title'] }}</div>
                    <a class="see-all" href="{{ $section['route'] }}">Lihat Semua →</a>
                </div>

                <div class="novel-slider" data-slider-root id="slider-{{ $section['id'] }}">
                    <div class="novel-slider-window">
                        <div class="novel-slider-track" data-slider-track>
                            @foreach ($section['slides'] as $slide)
                                <div class="novel-slide" data-slide>
                                    <div class="novel-grid novel-grid-slider">
                                        @foreach ($slide as $novel)
                                            <div class="novel-card" data-novel-id="{{ $novel->id }}">
                                                <a href="{{ route('novel.show', $novel->id) }}" class="novel-cover-link">
                                                    <div class="novel-cover">
                                                        @if ($novel->cover)
                                                            <img src="{{ asset('storage/' . ltrim($novel->cover, '/')) }}"
                                                                alt="{{ $novel->judul }}" loading="lazy" />
                                                        @else
                                                            <div class="hero-cover-placeholder">Cover</div>
                                                        @endif
                                                        <div class="novel-cover-overlay"></div>
                                                    </div>
                                                </a>

                                                <div class="novel-info">
                                                    <a href="{{ route('novel.show', $novel->id) }}"
                                                        class="novel-title-link">
                                                        <div class="novel-title">{{ $novel->judul }}</div>
                                                    </a>
                                                    <div class="novel-author">{{ $novel->author->name }}</div>

                                                    <div class="novel-meta-row">
                                                        <span class="novel-genre">{{ $novel->genre->nama_genre }}</span>
                                                        <span class="novel-status">{{ ucfirst($novel->status) }}</span>
                                                    </div>

                                                    <div class="novel-stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                class="novel-star {{ $i <= round($novel->rating ?? 0) ? 'star-filled' : 'star-empty' }}">★</span>
                                                        @endfor
                                                        <span
                                                            class="novel-rating-val">{{ number_format($novel->rating ?? 0, 1) }}</span>
                                                    </div>

                                                    <div class="novel-card-footer">
                                                        <span>{{ $novel->chapters_count ?? 0 }} chapter</span>
                                                        @if ($section['showViews'])
                                                            <span>{{ number_format($novel->views ?? 0) }} views</span>
                                                        @else
                                                            <span>{{ $novel->total_rating ?? 0 }} rating</span>
                                                        @endif
                                                    </div>

                                                    <button type="button" class="btn-rate-novel" data-rate-novel
                                                        data-novel-id="{{ $novel->id }}"
                                                        data-novel-title="{{ $novel->judul }}"
                                                        data-novel-author="{{ $novel->author->name }}"
                                                        data-cover-url="{{ $novel->cover ? asset('storage/' . ltrim($novel->cover, '/')) : '' }}"
                                                        data-user-rating="{{ auth()->check() ? auth()->user()->ratings()->where('novel_id', $novel->id)->value('rating') ?? 0 : 0 }}">
                                                        ★ Beri Rating
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($section['slides']->count() > 1)
                        <div class="novel-slider-controls">
                            <button type="button" class="slider-arrow" data-prev>←</button>
                            <div class="slider-dots">
                                @foreach ($section['slides'] as $slideIndex => $unused)
                                    <button type="button" class="slider-dot {{ $slideIndex === 0 ? 'active' : '' }}"
                                        data-dot></button>
                                @endforeach
                            </div>
                            <button type="button" class="slider-arrow" data-next>→</button>
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    </div>

    {{-- Modalnya tetap simpan di bawah (seperti codingan kamu sebelumnya) --}}
    {{-- ... (lanjutkan kodingan modal & script kamu) --}}
@endsection
