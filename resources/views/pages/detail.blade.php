@extends('layouts.app')
@section('title', $novel->judul . ' – Novela')

@section('content')

    {{-- ═══ DETAIL HERO ═══ --}}
    <div class="detail-hero">
        <div class="detail-inner">
            <div class="detail-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card));overflow:hidden">
                @if ($novel->cover)
                    <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->judul }}"
                        style="width:100%;height:100%;object-fit:cover" />
                @else
                    📖
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
                    <div class="detail-stat">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= round($novel->rating) ? '★' : '☆' }}
                        @endfor
                        <span>{{ number_format($novel->rating, 1) }} ({{ $novel->total_rating }})</span>
                    </div>
                    <div class="detail-stat">👁 {{ number_format($novel->views) }}</div>
                    <div class="detail-stat">📖 {{ $chapters->count() }} Ch</div>
                    <div class="detail-stat">❤️ {{ $bookmarkCount }}</div>
                    <div class="detail-stat">💬 {{ $commentCount }}</div>
                </div>
                <div class="detail-actions">
                    @if ($firstChapter)
                        @if ($lastReadChapter)
                            <a href="{{ route('chapter.show', $lastReadChapter->id) }}" class="btn-primary">▶ Lanjutkan
                                Ch.{{ $lastReadChapter->urutan }}</a>
                            <a href="{{ route('chapter.show', $firstChapter->id) }}" class="btn-secondary">Dari Awal</a>
                        @else
                            <a href="{{ route('chapter.show', $firstChapter->id) }}" class="btn-primary">▶ Baca
                                Sekarang</a>
                        @endif
                    @else
                        <button class="btn-primary" disabled>Belum Ada Chapter</button>
                    @endif

                    @auth
                        <form method="POST" action="{{ route('bookmark.toggle', $novel->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                {{ $isBookmarked ? '❤️ Hapus Favorit' : '🤍 Favorit' }}
                            </button>
                        </form>
                    @endauth

                    {{-- ✅ Trigger modal report --}}
                    <button class="btn-secondary" onclick="openModal('report-modal')">🚩 Laporkan</button>
                </div>

                {{-- ✅ Flash message --}}
                @if(session('success'))
                    <div style="margin-top:12px;padding:10px 14px;background:#e0faf5;border-radius:10px;font-size:13px;color:#00a08a;font-weight:600;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="margin-top:12px;padding:10px 14px;background:#fef0ee;border-radius:10px;font-size:13px;color:#c43020;font-weight:600;">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ TABS ═══ --}}
    <div class="content-wrap" style="padding-top:48px">
        <div class="tabs-row">
            <button class="tab-btn active" onclick="switchTab(this,'tab-synopsis')">📋 Sinopsis</button>
            <button class="tab-btn" onclick="switchTab(this,'tab-chapters')">📖 Chapter</button>
            <button class="tab-btn" onclick="switchTab(this,'tab-comments')">💬 Komentar</button>
            @auth
                <button class="tab-btn" onclick="switchTab(this,'tab-rating')">⭐ Beri Rating</button>
            @endauth
        </div>

        {{-- SINOPSIS --}}
        <div class="tab-pane active" id="tab-synopsis">
            <p class="synopsis-text">{{ $novel->sinopsis }}</p>
        </div>

        {{-- CHAPTER LIST --}}
        <div class="tab-pane" id="tab-chapters">
            @if ($chapters->isEmpty())
                <div class="empty-state">
                    <div class="icon">📭</div>
                    <p>Belum ada chapter.</p>
                </div>
            @else
                <div class="chapter-list">
                    @foreach ($chapters as $chapter)
                        <a href="{{ route('chapter.show', $chapter->id) }}" class="chapter-item"
                            style="text-decoration:none">
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

        {{-- KOMENTAR --}}
        <div class="tab-pane" id="tab-comments">
            <div class="empty-state">
                <div class="icon">💬</div>
                <p>Komentar tersedia di halaman tiap chapter.</p>
            </div>
        </div>

        {{-- RATING --}}
        @auth
            <div class="tab-pane" id="tab-rating">
                <form method="POST" action="{{ route('novel.rate', $novel->id) }}" style="max-width:400px">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Beri Rating (1–5)</label>
                        <div style="display:flex;gap:8px;margin-bottom:16px">
                            @for ($i = 1; $i <= 5; $i++)
                                <label style="cursor:pointer;font-size:2rem;color:var(--star)">
                                    <input type="radio" name="rating" value="{{ $i }}" style="display:none" />
                                    ☆
                                </label>
                            @endfor
                        </div>
                        <button type="submit" class="btn-primary">Kirim Rating</button>
                    </div>
                </form>
            </div>
        @endauth

    </div>

    {{-- ✅ Modal Report --}}
    @include('layouts.componen_reader.modal_report', ['novelId' => $novel->id])

@endsection

@push('scripts')
    <script>
        /* Highlight bintang rating saat hover */
        document.querySelectorAll('#tab-rating label').forEach((lbl, idx, all) => {
            lbl.addEventListener('mouseenter', () => {
                all.forEach((l, i) => l.textContent = i <= idx ? '★' : '☆');
            });
            lbl.addEventListener('mouseleave', () => {
                all.forEach(l => l.textContent = '☆');
            });
            lbl.addEventListener('click', () => {
                all.forEach((l, i) => l.textContent = i <= idx ? '★' : '☆');
            });
        });

        /* ✅ Modal helpers */
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
        // Klik luar modal = tutup
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => { if (e.target === el) el.classList.remove('open'); });
        });
    </script>
@endpush