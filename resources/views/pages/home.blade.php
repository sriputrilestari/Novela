    @extends('layouts.app')
    @section('title', 'Novela - Beranda')

    @php
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

        @if (!$featured && $latestNovels->isEmpty() && $popularNovels->isEmpty())
            <div
                style="
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
    ">
                <div style="font-size: 40px; margin-bottom: 12px;">📚</div>
                <h2 style="font-size: 22px; font-weight: 600; margin-bottom: 6px;">
                    Belum Ada Novel
                </h2>
                <p style="color: #aaa;">
                    Saat ini belum ada novel yang dipublikasikan.
                    Silakan kembali lagi nanti ✨
                </p>
            </div>
        @endif

        {{-- ─── HERO ─────────────────────────────────────────────────── --}}
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
                            <img src="{{ asset('storage/' . ltrim($featured->cover, '/')) }}"
                                alt="{{ $featured->judul }}" />
                        @else
                            <div class="hero-cover-placeholder">Cover Novel</div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- ─── MAIN CONTENT ────────────────────────────────────────── --}}
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

                                                    <a href="{{ route('novel.show', $novel->id) }}"
                                                        class="novel-cover-link">
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
                                                            <span
                                                                class="novel-genre">{{ $novel->genre->nama_genre }}</span>
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
                                                            data-user-rating="{{ auth()->check() ? auth()->user()->ratings()->where('novel_id', $novel->id)->value('rating') ?? 0 : 0 }}"
                                                            aria-label="Beri rating untuk {{ $novel->judul }}">
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
                                <button type="button" class="slider-arrow" data-prev
                                    aria-label="Slide sebelumnya">←</button>
                                <div class="slider-dots">
                                    @foreach ($section['slides'] as $slideIndex => $unused)
                                        <button type="button" class="slider-dot {{ $slideIndex === 0 ? 'active' : '' }}"
                                            data-dot aria-label="Slide {{ $slideIndex + 1 }}"></button>
                                    @endforeach
                                </div>
                                <button type="button" class="slider-arrow" data-next
                                    aria-label="Slide berikutnya">→</button>
                            </div>
                        @endif
                    </div>
                </section>
            @endforeach

        </div>

        {{-- ─── RATING MODAL ────────────────────────────────────────── --}}
        <div id="ratingModalOverlay"
            style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:999; align-items:center; justify-content:center;"
            aria-hidden="true">

            <div role="dialog" aria-modal="true" aria-labelledby="ratingModalTitle"
                style="background:var(--bg-card,#fff); border-radius:12px; border:0.5px solid rgba(0,0,0,.1); padding:1.5rem; width:320px; max-width:90vw; position:relative;">

                <button id="ratingModalClose"
                    style="position:absolute; top:12px; right:14px; background:none; border:none; font-size:20px; cursor:pointer; color:inherit; line-height:1;"
                    aria-label="Tutup">&times;</button>

                {{-- Form state --}}
                <div id="ratingFormState">
                    <div style="display:flex; gap:12px; align-items:center; margin-bottom:16px;">
                        <div id="ratingModalCover"
                            style="width:52px; height:72px; border-radius:6px; background:#eee; flex-shrink:0; overflow:hidden; display:flex; align-items:center; justify-content:center; font-size:9px; color:#999;">
                        </div>
                        <div>
                            <div style="font-size:11px; color:#888; margin-bottom:2px;">Beri Rating</div>
                            <div id="ratingModalTitle" style="font-size:14px; font-weight:500; line-height:1.3;"></div>
                            <div id="ratingModalAuthor" style="font-size:12px; color:#888; margin-top:2px;"></div>
                        </div>
                    </div>

                    <div id="starPicker" style="display:flex; gap:6px; justify-content:center; margin-bottom:8px;"
                        role="group" aria-label="Pilih rating bintang">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}"
                                style="font-size:28px; background:none; border:none; cursor:pointer; color:#ddd; padding:0; line-height:1; transition:color .1s, transform .1s;"
                                aria-label="{{ $i }} bintang">★</button>
                        @endfor
                    </div>

                    <div id="starLabel"
                        style="text-align:center; font-size:12px; color:#888; margin-bottom:16px; min-height:18px;">
                        Pilih bintang…
                    </div>

                    <form id="ratingForm" method="POST">
                        @csrf
                        <input type="hidden" name="rating" id="ratingInput" value="">
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <button type="button" id="ratingCancelBtn"
                                style="font-size:13px; padding:7px 14px; border-radius:8px; background:transparent; border:0.5px solid #ccc; cursor:pointer;">
                                Batal
                            </button>
                            <button type="submit" id="ratingSubmitBtn" disabled
                                style="font-size:13px; font-weight:500; padding:7px 14px; border-radius:8px; background:#111; color:#fff; border:none; cursor:pointer; opacity:.4;">
                                Kirim Rating
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Sukses state --}}
                <div id="ratingSuccessState" style="display:none; text-align:center; padding:1rem 0;">
                    <div id="ratingSuccessStars" style="font-size:28px; margin-bottom:8px; line-height:1;"></div>
                    <div id="ratingSuccessLabel" style="font-size:15px; font-weight:500; margin-bottom:6px;"></div>
                    <div id="ratingSuccessSub" style="font-size:12px; color:#888;"></div>
                    <button type="button" id="ratingDoneBtn"
                        style="margin-top:16px; font-size:13px; font-weight:500; padding:8px 20px; border-radius:8px; background:#111; color:#fff; border:none; cursor:pointer;">
                        Tutup
                    </button>
                </div>

            </div>
        </div>

    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /* ──────────────────────────────────────────────────
                SLIDER
                ────────────────────────────────────────────────── */
                document.querySelectorAll('[data-slider-root]').forEach(function(root) {
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
                    dots.forEach((dot, i) => dot.addEventListener('click', () => {
                        index = i;
                        render();
                    }));
                    render();
                });

                /* ──────────────────────────────────────────────────
                RATING MODAL
                ────────────────────────────────────────────────── */
                const starLabels = ['', 'Sangat Buruk', 'Kurang Baik', 'Cukup', 'Bagus', 'Sangat Bagus'];
                const overlay = document.getElementById('ratingModalOverlay');
                const formState = document.getElementById('ratingFormState');
                const successState = document.getElementById('ratingSuccessState');
                const starBtns = Array.from(document.querySelectorAll('.star-btn'));
                const starLabel = document.getElementById('starLabel');
                const ratingInput = document.getElementById('ratingInput');
                const submitBtn = document.getElementById('ratingSubmitBtn');
                const ratingForm = document.getElementById('ratingForm');
                let picked = 0;

                function renderStars(val) {
                    starBtns.forEach((btn, i) => {
                        btn.style.color = i < val ? '#F59E0B' : '#ddd';
                        btn.style.transform = i < val ? 'scale(1.1)' : 'scale(1)';
                    });
                    starLabel.textContent = val ? starLabels[val] : 'Pilih bintang…';
                }

                function openModal(novelId, novelTitle, novelAuthor, coverUrl, existingRating) {
                    picked = existingRating || 0;
                    ratingInput.value = picked || '';
                    submitBtn.disabled = !picked;
                    submitBtn.style.opacity = picked ? '1' : '.4';
                    formState.style.display = '';
                    successState.style.display = 'none';
                    submitBtn.textContent = 'Kirim Rating';

                    document.getElementById('ratingModalTitle').textContent = novelTitle;
                    document.getElementById('ratingModalAuthor').textContent = novelAuthor;

                    const coverEl = document.getElementById('ratingModalCover');
                    coverEl.innerHTML = coverUrl ?
                        `<img src="${coverUrl}" alt="${novelTitle}" style="width:100%;height:100%;object-fit:cover;">` :
                        'Cover';

                    ratingForm.action = '{{ url('/novel') }}/' + novelId + '/rate';
                    renderStars(picked);

                    overlay.style.display = 'flex';
                    overlay.setAttribute('aria-hidden', 'false');
                }

                function closeModal() {
                    overlay.style.display = 'none';
                    overlay.setAttribute('aria-hidden', 'true');
                }

                // Hover & klik bintang
                starBtns.forEach((btn, i) => {
                    btn.addEventListener('mouseover', () => renderStars(i + 1));
                    btn.addEventListener('mouseout', () => renderStars(picked));
                    btn.addEventListener('click', () => {
                        picked = i + 1;
                        ratingInput.value = picked;
                        submitBtn.disabled = false;
                        submitBtn.style.opacity = '1';
                        renderStars(picked);
                    });
                });

                // Submit via AJAX
                ratingForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!picked) return;

                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Mengirim…';

                    fetch(ratingForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(ratingForm),
                        })
                        .then(res => {
                            if (res.status === 401) {
                                window.location.href = '{{ route('login') }}';
                                return null;
                            }
                            if (!res.ok) throw new Error('Gagal');
                            return res.json().catch(() => ({}));
                        })
                        .then(data => {
                            if (!data) return;

                            // Update bintang & nilai di card tanpa reload
                            if (data.rating !== undefined) {
                                document.querySelectorAll(`.novel-card[data-novel-id="${data.novel_id}"]`)
                                    .forEach(card => {
                                        const ratingEl = card.querySelector('.novel-rating-val');
                                        if (ratingEl) ratingEl.textContent = parseFloat(data.rating)
                                            .toFixed(1);
                                        card.querySelectorAll('.novel-star').forEach((s, i) => {
                                            s.className = 'novel-star ' + (i < Math.round(data
                                                .rating) ? 'star-filled' : 'star-empty');
                                        });
                                    });
                            }

                            // Tampilkan state sukses
                            formState.style.display = 'none';
                            successState.style.display = '';

                            document.getElementById('ratingSuccessStars').innerHTML = [1, 2, 3, 4, 5].map(
                                i =>
                                `<span style="color:${i <= picked ? '#F59E0B' : '#ddd'}">★</span>`
                            ).join('');
                            document.getElementById('ratingSuccessLabel').textContent = starLabels[picked] +
                                '!';
                            document.getElementById('ratingSuccessSub').textContent =
                                data.message || 'Rating kamu sudah tersimpan.';
                        })
                        .catch(() => {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Kirim Rating';
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });

                // Tutup modal
                document.getElementById('ratingModalClose').addEventListener('click', closeModal);
                document.getElementById('ratingCancelBtn').addEventListener('click', closeModal);
                document.getElementById('ratingDoneBtn').addEventListener('click', closeModal);
                overlay.addEventListener('click', e => {
                    if (e.target === overlay) closeModal();
                });
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') closeModal();
                });

                // Delegasi klik tombol rating di card
                document.addEventListener('click', function(e) {
                        const btn = e.target.closest('[data-rate-novel]');
                        if (!btn) return;

                        @auth
                        openModal(
                            btn.dataset.novelId,
                            btn.dataset.novelTitle,
                            btn.dataset.novelAuthor,
                            btn.dataset.coverUrl || '',
                            parseInt(btn.dataset.userRating) || 0
                        );
                    @else
                        window.location.href = '{{ route('login') }}';
                    @endauth
                });

            });
        </script>
    @endpush
