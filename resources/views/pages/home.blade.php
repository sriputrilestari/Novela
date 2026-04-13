@extends('layouts.app')
@section('title', 'Novela - Beranda')

@php
    $featuredSlides = $featuredNovels->chunk(5);
    $latestSlides = $latestNovels->chunk(5);
    $popularSlides = $popularNovels->chunk(5);
@endphp

@section('content')
    @if ($featured)
        <section class="hero-home-shell">
        <div class="hero-banner hero-banner-home">
            <div class="hero-copy-home">
                <div class="hero-badge">Novel Pilihan</div>
                <div class="hero-title">{{ $featured->judul }}</div>
                <div class="hero-author">oleh <strong>{{ $featured->author->name }}</strong></div>
                <div class="hero-desc">{{ \Illuminate\Support\Str::limit($featured->sinopsis, 180) }}</div>

                <div class="hero-meta">
                    <span class="hero-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($featured->rating) ? 's-on' : 's-off' }}">★</span>
                        @endfor
                    </span>
                    <span class="hero-rating">{{ number_format($featured->rating, 1) }} ({{ $featured->total_rating }})</span>
                    <span class="hero-tag">{{ $featured->genre->nama_genre }}</span>
                    <span class="hero-tag">{{ ucfirst($featured->status) }}</span>
                    <span class="hero-chapter">{{ $featured->chapters_count }} Chapter</span>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('reader.read', $featured->id) }}" class="btn-primary">▶ Mulai Baca</a>
                    <a href="{{ route('novel.show', $featured->id) }}" class="btn-secondary">ⓘ Detail Novel</a>
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

    <div class="content-wrap content-wrap-home">
        @auth
            @if ($readingHistory->isNotEmpty())
                <div class="section-header">
                    <div class="section-title">Lanjutkan Membaca</div>
                    <a class="see-all" href="{{ route('history') }}">Lihat Semua →</a>
                </div>

                <div class="reading-history-strip mb-32">
                    @foreach ($readingHistory as $history)
                        <a href="{{ route('chapter.show', $history->chapter->id) }}" class="reading-item">
                            <div class="reading-cover">
                                @if ($history->chapter->novel->cover)
                                    <img src="{{ asset('storage/' . ltrim($history->chapter->novel->cover, '/')) }}" alt="{{ $history->chapter->novel->judul }}" />
                                @else
                                    <div class="hero-cover-placeholder">Cover</div>
                                @endif
                            </div>
                            <div class="reading-info">
                                <div class="reading-title">{{ $history->chapter->novel->judul }}</div>
                                <div class="reading-author">{{ $history->chapter->judul_chapter }} · {{ $history->chapter->novel->genre->nama_genre }}</div>
                            </div>
                            <div class="reading-right">
                                <span class="text-xs text-muted">{{ $history->last_read_at?->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @endauth

        {{-- @include('pages.partials.novel-slider-section', [
            'sectionId' => 'featured',
            'title' => 'Novel Pilihan',
            'seeAllRoute' => route('search'),
            'slides' => $featuredSlides,
            'emptyMessage' => 'Belum ada novel pilihan.',
        ]) --}}

        @include('pages.partials.novel-slider-section', [
            'sectionId' => 'latest',
            'title' => 'Novel Terbaru',
            'seeAllRoute' => route('search'),
            'slides' => $latestSlides,
            'emptyMessage' => 'Belum ada novel terbaru.',
        ])
{{-- 
        @include('pages.partials.novel-slider-section', [
            'sectionId' => 'popular',
            'title' => 'Novel Populer',
            'seeAllRoute' => route('search', ['sort' => 'popular']),
            'slides' => $popularSlides,
            'emptyMessage' => 'Belum ada novel populer.',
            'showViews' => true,
        ]) --}}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-slider-root]').forEach(function (root) {
                const track = root.querySelector('[data-slider-track]');
                const slides = Array.from(root.querySelectorAll('[data-slide]'));
                const prev = root.querySelector('[data-prev]');
                const next = root.querySelector('[data-next]');
                const dots = Array.from(root.querySelectorAll('[data-dot]'));
                let index = 0;

                const render = () => {
                    track.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, dotIndex) => {
                        dot.classList.toggle('active', dotIndex === index);
                    });
                    if (prev) prev.disabled = index === 0;
                    if (next) next.disabled = index === slides.length - 1;
                };

                prev?.addEventListener('click', function () {
                    index = Math.max(0, index - 1);
                    render();
                });

                next?.addEventListener('click', function () {
                    index = Math.min(slides.length - 1, index + 1);
                    render();
                });

                dots.forEach((dot, dotIndex) => {
                    dot.addEventListener('click', function () {
                        index = dotIndex;
                        render();
                    });
                });

                render();
            });
        });
    </script>
@endpush
