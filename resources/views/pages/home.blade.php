@extends('layouts.app')
@section('title', 'Novela - Beranda')

@php
    /** * 1. Pakai values() setelah sort supaya index-nya reset jadi 0, 1, 2...
     * Ini kuncinya biar looping nomornya nggak loncat-loncat.
     */
    $sortedLatest = $latestNovels->sortByDesc('id')->values();
    $latestSlides = $sortedLatest->chunk(5);

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

    {{-- 1. HERO SECTION --}}
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
                        <span class="hero-rating">{{ number_format($featured->rating ?? 0, 1) }}</span>
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

    {{-- 2. MAIN CONTENT (FIXED SLIDER & RANKING) --}}
    <div class="content-wrap content-wrap-home">
        @foreach ($sections as $section)
            @if ($section['slides']->isEmpty())
                @continue
            @endif

            <section class="novel-section">
                <div class="section-header">
                    <div class="section-title">{{ $section['title'] }}</div>

                    <div class="slider-nav-controls" style="display: flex; align-items: center; gap: 15px;">
                        <div class="arrows-wrap" style="display: flex; gap: 8px;">
                            <button class="slider-arrow" onclick="manualSlide('{{ $section['id'] }}', -1)">❮</button>
                            <button class="slider-arrow" onclick="manualSlide('{{ $section['id'] }}', 1)">❯</button>
                        </div>
                        <a class="see-all" href="{{ $section['route'] }}">Lihat Semua →</a>
                    </div>
                </div>

                <div class="novel-slider" id="slider-{{ $section['id'] }}">
                    <div class="novel-slider-window" style="overflow: hidden; width: 100%;">
                        <div class="novel-slider-track" id="track-{{ $section['id'] }}"
                            style="display: flex; transition: transform 0.5s ease-in-out;">
                            @foreach ($section['slides'] as $slideIndex => $slide)
                                <div class="novel-slide" style="min-width: 100%;">
                                    <div class="novel-grid">
                                        @foreach ($slide as $novelIndex => $novel)
                                            <div class="novel-card">
                                                <a href="{{ route('novel.show', $novel->id) }}" class="novel-cover-link">
                                                    <div class="novel-cover">
                                                        {{-- NOMOR URUT: (Slide ke berapa * isi per slide) + (urutan item di slide itu) --}}
                                                        <div class="novel-rank-badge">
                                                            {{ $slideIndex * 5 + $loop->iteration }}
                                                        </div>

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
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </div>

    <style>
        .novel-cover {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
        }

        .novel-rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            background: rgba(15, 23, 42, 0.9);
            color: #fff;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 800;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(4px);
        }

        /* Style khusus buat ranking 1 */
        .novel-section:first-of-type .novel-slide:first-child .novel-card:first-child .novel-rank-badge {
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-color: #fff;
            box-shadow: 0 0 10px rgba(168, 85, 247, 0.5);
        }

        .slider-arrow {
            background: #1e293b;
            color: white;
            border: 1px solid #334155;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
            font-size: 12px;
        }

        .slider-arrow:hover {
            background: #475569;
            border-color: #6366f1;
        }
    </style>

    <script>
        const sliderStates = {};

        function manualSlide(sectionId, direction) {
            const track = document.getElementById('track-' + sectionId);
            if (!track) return;
            const totalSlides = track.children.length;
            if (!sliderStates[sectionId]) sliderStates[sectionId] = 0;
            sliderStates[sectionId] += direction;
            if (sliderStates[sectionId] >= totalSlides) sliderStates[sectionId] = 0;
            if (sliderStates[sectionId] < 0) sliderStates[sectionId] = totalSlides - 1;
            track.style.transform = `translateX(-${sliderStates[sectionId] * 100}%)`;
        }
    </script>
@endsection
