@php
    $showViews = $showViews ?? false;
@endphp

<section class="novel-section novel-section-{{ $sectionId }}">
    <div class="section-header">
        <div class="section-title">{{ $title }}</div>
        <a class="see-all" href="{{ $seeAllRoute }}">Lihat Semua →</a>
    </div>

    @if ($slides->isEmpty())
        <div class="empty-state">
            <div class="icon">📚</div>
            <p>{{ $emptyMessage }}</p>
        </div>
    @else
        <div class="novel-slider" data-slider-root id="slider-{{ $sectionId }}">
            <div class="novel-slider-window">
                <div class="novel-slider-track" data-slider-track>
                    @foreach ($slides as $slideIndex => $slide)
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
                                                    <span class="{{ $i <= round($novel->rating) ? 'star-filled' : 'star-empty' }}">★</span>
                                                @endfor
                                                <span>{{ number_format($novel->rating, 1) }}</span>
                                            </div>
                                            <div class="novel-card-footer">
                                                <span>{{ $novel->chapters_count ?? 0 }} chapter</span>
                                                @if ($showViews)
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

            @if ($slides->count() > 1)
                <div class="novel-slider-controls">
                    <button type="button" class="slider-arrow" data-prev aria-label="Slide sebelumnya">←</button>
                    <div class="slider-dots">
                        @foreach ($slides as $slideIndex => $slide)
                            <button
                                type="button"
                                class="slider-dot {{ $slideIndex === 0 ? 'active' : '' }}"
                                data-dot
                                aria-label="Slide {{ $slideIndex + 1 }}">
                                {{ $slideIndex + 1 }}
                            </button>
                        @endforeach
                    </div>
                    <button type="button" class="slider-arrow" data-next aria-label="Slide berikutnya">→</button>
                </div>
            @endif
        </div>
    @endif
</section>
