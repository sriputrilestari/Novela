@extends('layouts.app')
@section('title', $novel->judul . ' - Novela')

@section('content')
    <div class="detail-hero">
        <div class="detail-inner">
            <div class="detail-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card));overflow:hidden">
                @if ($novel->cover)
                    <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->judul }}"
                        style="width:100%;height:100%;object-fit:cover" />
                @else
                    <span class="detail-cover-fallback">Book</span>
                @endif
            </div>

            <div class="detail-info">
                <div class="detail-genre-row">
                    <span class="tag">{{ $novel->genre->nama_genre }}</span>
                    <span class="tag {{ $novel->status === 'completed' ? 'tag-green' : 'tag-gold' }}">
                        {{ $novel->status === 'completed' ? 'Tamat' : 'Ongoing' }}
                    </span>
                </div>

                <div class="detail-title">{{ $novel->judul }}</div>

                <div class="detail-author-row">
                    <div class="detail-author-avatar">{{ strtoupper(substr($novel->author->name, 0, 1)) }}</div>
                    <span>oleh <strong style="color:white">{{ $novel->author->name }}</strong></span>
                </div>

                <div class="detail-stats-row">
                    <div class="detail-stat detail-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($novel->rating) ? 's-on' : 's-off' }}">★</span>
                        @endfor
                        <span>{{ number_format($novel->rating, 1) }} ({{ $novel->total_rating }})</span>
                    </div>
                    <div class="detail-stat">Views {{ number_format($novel->views) }}</div>
                    <div class="detail-stat">Chapter {{ $chapters->count() }}</div>
                    <div class="detail-stat">Favorit {{ $bookmarkCount }}</div>
                    <div class="detail-stat">Komentar {{ $commentCount }}</div>
                </div>

                <div class="detail-actions">
                    @if ($firstChapter)
                        @if ($lastReadChapter)
                            <a href="{{ route('chapter.show', $lastReadChapter->id) }}" class="btn-primary">
                                Lanjutkan Ch.{{ $lastReadChapter->urutan }}
                            </a>
                            <a href="{{ route('chapter.show', $firstChapter->id) }}" class="btn-secondary">Dari Awal</a>
                        @else
                            <a href="{{ route('chapter.show', $firstChapter->id) }}" class="btn-primary">Baca Sekarang</a>
                        @endif
                    @else
                        <button class="btn-primary" disabled>Belum Ada Chapter</button>
                    @endif

                    @auth
                        <form method="POST" action="{{ route('bookmark.toggle', $novel->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                {{ $isBookmarked ? 'Hapus Favorit' : 'Tambah Favorit' }}
                            </button>
                        </form>
                    @endauth

                    <button class="btn-secondary" onclick="openModal('report-modal')">Laporkan</button>
                </div>

                @if (session('success'))
                    <div class="detail-flash detail-flash-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="detail-flash detail-flash-error">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="content-wrap detail-content">
        <div class="tabs-row">
            <button class="tab-btn active" onclick="switchTab(this,'tab-synopsis')">Sinopsis</button>
            <button class="tab-btn" onclick="switchTab(this,'tab-chapters')">Chapter</button>
            <!-- <button class="tab-btn" onclick="switchTab(this,'tab-comments')">Komentar</button> -->
            @auth
                <button class="tab-btn" onclick="switchTab(this,'tab-rating')">Beri Rating</button>
            @endauth
        </div>

        <div class="tab-pane active" id="tab-synopsis">
            <p class="synopsis-text">{{ $novel->sinopsis }}</p>
        </div>

        <div class="tab-pane" id="tab-chapters">
            @if ($chapters->isEmpty())
                <div class="empty-state">
                    <div class="icon">...</div>
                    <p>Belum ada chapter.</p>
                </div>
            @else
                <div class="chapter-list">
                    @foreach ($chapters as $chapter)
                        <a href="{{ route('chapter.show', $chapter->id) }}" class="chapter-item">
                            <div class="chapter-num">{{ $chapter->urutan }}</div>
                            <div class="chapter-info">
                                <div class="chapter-title-text">{{ $chapter->judul_chapter }}</div>
                                <div class="chapter-meta">{{ $chapter->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="tab-pane" id="tab-comments">
            <div class="empty-state">
                <div class="icon">...</div>
                <p>Komentar tersedia di halaman tiap chapter.</p>
            </div>
        </div>

        @auth
            <div class="tab-pane" id="tab-rating">
                <form method="POST" action="{{ route('novel.rate', $novel->id) }}" class="rating-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Beri Rating (1-5)</label>
                        <div class="rating-stars" data-initial-rating="{{ $userRating ?? 0 }}">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="rating-star-option">
                                    <input type="radio" name="rating" value="{{ $i }}" style="display:none"
                                        {{ (int) $userRating === $i ? 'checked' : '' }} />
                                    <span class="rating-star-icon" aria-hidden="true">☆</span>
                                </label>
                            @endfor
                        </div>
                        <div class="text-muted text-sm mb-16">
                            {{ $userRating ? 'Rating kamu saat ini: ' . $userRating . '/5' : 'Pilih bintang lalu kirim rating.' }}
                        </div>
                        @error('rating')
                            <div class="text-red text-sm mb-12">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn-primary">Kirim Rating</button>
                    </div>
                </form>
            </div>
        @endauth
    </div>

    @include('layouts.componen_reader.modal_report', ['novelId' => $novel->id])
@endsection

@push('scripts')
    <script>
        const ratingContainer = document.querySelector('.rating-stars');

        if (ratingContainer) {
            const labels = Array.from(ratingContainer.querySelectorAll('.rating-star-option'));
            const initialRating = Number(ratingContainer.dataset.initialRating || 0);

            const paintStars = rating => {
                labels.forEach((label, index) => {
                    const icon = label.querySelector('.rating-star-icon');
                    if (icon) {
                        icon.textContent = index < rating ? '★' : '☆';
                    }
                });
            };

            const checkedInput = ratingContainer.querySelector('input[name="rating"]:checked');
            paintStars(checkedInput ? Number(checkedInput.value) : initialRating);

            labels.forEach((label, index) => {
                const input = label.querySelector('input[name="rating"]');

                label.addEventListener('mouseenter', () => paintStars(index + 1));
                label.addEventListener('click', () => {
                    if (!input) {
                        return;
                    }

                    input.checked = true;
                    paintStars(Number(input.value));
                });
            });

            ratingContainer.addEventListener('mouseleave', () => {
                const selectedInput = ratingContainer.querySelector('input[name="rating"]:checked');
                paintStars(selectedInput ? Number(selectedInput.value) : initialRating);
            });
        }

        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) {
                    el.classList.remove('open');
                }
            });
        });
    </script>
@endpush
