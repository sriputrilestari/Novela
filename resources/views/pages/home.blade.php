@extends('layouts.app')
@section('title', 'Novela - Beranda')

@php
    $latestSlides = $latestNovels->chunk(5);
    $popularSlides = $popularNovels->chunk(5);
    $featuredSlides = $featuredNovels->chunk(5);
@endphp

@section('content')
    @if (! $hasPublished)
        <div class="content-wrap content-wrap-home" style="padding-bottom:0;">
            <div class="alert alert-warning" style="margin-bottom:20px;">
                Belum ada novel berstatus <strong>published</strong>. Menampilkan semua data sementara.
            </div>
        </div>
    @endif

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
                                <span class="{{ $i <= round($featured->rating) ? 's-on' : 's-off' }}">*</span>
                            @endfor
                        </span>
                        <span class="hero-rating">{{ number_format($featured->rating, 1) }} ({{ $featured->total_rating }})</span>
                        <span class="hero-tag">{{ $featured->genre->nama_genre }}</span>
                        <span class="hero-tag">{{ ucfirst($featured->status) }}</span>
                        <span class="hero-chapter">{{ $featured->chapters_count }} Chapter</span>
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

    <div class="content-wrap content-wrap-home">
        @auth
            @if ($readingHistory->isNotEmpty())
                <div class="section-header">
                    <div class="section-title">Lanjutkan Membaca</div>
                    <a class="see-all" href="{{ route('history') }}">Lihat Semua -></a>
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
                                <div class="reading-author">{{ $history->chapter->judul_chapter }} - {{ $history->chapter->novel->genre->nama_genre }}</div>
                            </div>
                            <div class="reading-right">
                                <span class="text-xs text-muted">{{ $history->last_read_at?->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @endauth

        @php
            $sections = [
                ['id' => 'latest', 'title' => 'Novel Terbaru', 'slides' => $latestSlides, 'route' => route('search'), 'showViews' => false],
                ['id' => 'featured', 'title' => 'Novel Pilihan', 'slides' => $featuredSlides, 'route' => route('search'), 'showViews' => false],
                ['id' => 'popular', 'title' => 'Novel Populer', 'slides' => $popularSlides, 'route' => route('search', ['sort' => 'popular']), 'showViews' => true],
            ];
        @endphp

        @foreach ($sections as $section)
            @if ($section['slides']->isEmpty())
                @continue
            @endif

            <section class="novel-section novel-section-{{ $section['id'] }}">
                <div class="section-header">
                    <div class="section-title">{{ $section['title'] }}</div>
                    <a class="see-all" href="{{ $section['route'] }}">Lihat Semua -></a>
                </div>

                <div class="novel-slider" data-slider-root id="slider-{{ $section['id'] }}">
                    <div class="novel-slider-window">
                        <div class="novel-slider-track" data-slider-track>
                            @foreach ($section['slides'] as $slide)
                                <div class="novel-slide" data-slide>
                                    <div class="novel-grid novel-grid-slider">
                                        @foreach ($slide as $novel)
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
                                                            <span class="{{ $i <= round($novel->rating) ? 'star-filled' : 'star-empty' }}">*</span>
                                                        @endfor
                                                        <span>{{ number_format($novel->rating, 1) }}</span>
                                                    </div>
                                                    <div class="novel-card-footer">
                                                        <span>{{ $novel->chapters_count ?? 0 }} chapter</span>
                                                        @if ($section['showViews'])
                                                            <span>{{ number_format($novel->views) }} views</span>
                                                        @else
                                                            <span>{{ $novel->total_rating }} rating</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($section['slides']->count() > 1)
                        <div class="novel-slider-controls">
                            <button type="button" class="slider-arrow" data-prev aria-label="Slide sebelumnya"><-</button>
                            <div class="slider-dots">
                                @foreach ($section['slides'] as $slideIndex => $unused)
                                    <button type="button" class="slider-dot {{ $slideIndex === 0 ? 'active' : '' }}" data-dot aria-label="Slide {{ $slideIndex + 1 }}">{{ $slideIndex + 1 }}</button>
                                @endforeach
                            </div>
                            <button type="button" class="slider-arrow" data-next aria-label="Slide berikutnya">-></button>
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
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
                    if (!track || slides.length === 0) return;
                    track.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
                    if (prev) prev.disabled = index === 0;
                    if (next) next.disabled = index === slides.length - 1;
                };

                prev?.addEventListener('click', () => {
                    index = Math.max(0, index - 1);
                    render();
                });

                next?.addEventListener('click', () => {
                    index = Math.min(slides.length - 1, index + 1);
                    render();
                });

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        index = i;
                        render();
                    });
                });

                render();
            });
        });
    </script>
@endpush
