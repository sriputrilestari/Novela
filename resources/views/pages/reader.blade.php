@extends('layouts.app')
@section('title', 'Ch.' . $chapter->urutan . ' – ' . $chapter->novel->judul)

@section('content')

    {{-- ═══ READER TOPBAR ═══ --}}
    <div class="reader-topbar"
        style="position:sticky;top:64px;z-index:90;background:rgba(7,12,36,.92);backdrop-filter:blur(16px);border-bottom:1px solid var(--border);padding:10px 40px">
        <div
            style="max-width:760px;margin:0 auto;display:flex;align-items:flex-start;justify-content:space-between;gap:12px">
            <div>
                <a href="{{ route('novel.show', $chapter->novel->id) }}" style="font-size:.78rem;color:var(--text-muted)">←
                    Kembali ke Novel</a>
                <div style="font-size:.8rem;color:var(--text-muted);margin-top:4px">{{ $chapter->novel->judul }}</div>
                <div style="font-family:'Cinzel',serif;font-size:1rem;font-weight:600">
                    Chapter {{ $chapter->urutan }}: {{ $chapter->judul_chapter }}
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;position:relative">
                <button class="icon-btn" onclick="toggleSettings()" title="Pengaturan">⚙</button>
                @auth
                    <form method="POST" action="{{ route('bookmark.toggle', $chapter->novel->id) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="icon-btn" title="{{ $isBookmarked ? 'Hapus Bookmark' : 'Bookmark' }}">
                            {{ $isBookmarked ? '🔖' : '🔗' }}
                        </button>
                    </form>
                @endauth
                {{-- ✅ Trigger modal report --}}
                <button class="icon-btn" onclick="openModal('report-modal')" title="Laporkan Novel">🚩</button>
            </div>
        </div>
    </div>

    {{-- ═══ READER WRAP ═══ --}}
    <div class="reader-wrap">

        {{-- Settings Panel --}}
        <div class="reader-settings-panel" id="settings-panel">
            <div class="settings-row mb-16">
                <div class="settings-label">Ukuran Font</div>
                <div class="font-size-controls">
                    <button class="font-size-btn" onclick="changeFontSize(-1)">A−</button>
                    <span class="font-size-val" id="font-size-display">18px</span>
                    <button class="font-size-btn" onclick="changeFontSize(1)">A+</button>
                </div>
            </div>
            <div class="settings-row">
                <div class="settings-label">Tema Baca</div>
                <div class="theme-btns">
                    <div class="theme-swatch" style="background:#fdf9f5;border:1.5px solid #ddd"
                        onclick="setReadTheme('cream',this)" title="Krem"></div>
                    <div class="theme-swatch active" style="background:#fff;border:1.5px solid #ddd"
                        onclick="setReadTheme('white',this)" title="Putih"></div>
                    <div class="theme-swatch" style="background:#1a1a2e" onclick="setReadTheme('midnight',this)"
                        title="Midnight"></div>
                    <div class="theme-swatch" style="background:#04071a;border:1px solid var(--border)"
                        onclick="setReadTheme('dark',this)" title="Gelap"></div>
                </div>
            </div>
        </div>

        {{-- Flash message --}}
        @if (session('success'))
            <div
                style="background:#e0faf5;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#00a08a;font-weight:600;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                style="background:#fef0ee;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#c43020;font-weight:600;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- ═══ ISI CHAPTER ═══ --}}
        <div id="reader-content"
            style="font-family:'Crimson Pro',serif;font-size:18px;line-height:2;color:var(--text-soft);padding:32px 0;transition:all .3s">
            <h2
                style="font-family:'Cinzel',serif;font-size:1.4rem;font-weight:700;margin-bottom:28px;color:var(--text-white)">
                Chapter {{ $chapter->urutan }}: {{ $chapter->judul_chapter }}
            </h2>
            {!! nl2br(e($chapter->isi)) !!}

            <div
                style="text-align:center;padding:32px 0;border-top:2px dashed var(--border);border-bottom:2px dashed var(--border);margin:32px 0">
                <div style="font-size:1.5rem;margin-bottom:8px">✦</div>
                <div style="font-family:'Crimson Pro',serif;font-size:1rem;color:var(--text-muted)">Akhir Chapter
                    {{ $chapter->urutan }}</div>
            </div>
        </div>

        {{-- ═══ KOMENTAR ═══ --}}
        <div style="margin-top:32px">
            <div style="font-family:'Cinzel',serif;font-size:1rem;font-weight:700;margin-bottom:16px">💬 Komentar
                ({{ $comments->count() }})</div>

            @auth
                <div class="comment-box">
                    <form method="POST" action="/comment">
                        @csrf
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}" />
                        <textarea class="comment-input" name="komentar" placeholder="Bagaimana pendapatmu tentang chapter ini?..." required></textarea>
                        <div class="comment-actions">
                            <button type="submit" class="btn-primary" style="font-size:.82rem;padding:8px 16px">Kirim</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="comment-box">
                    <p class="text-muted text-sm"><a href="{{ route('login') }}" style="color:var(--accent)">Masuk</a> untuk
                        berkomentar.</p>
                </div>
            @endauth

            @forelse($comments as $comment)
                <div class="comment-item">
                    <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                    <div class="comment-body">
                        <div class="comment-user">
                            {{ $comment->user->name }}
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="comment-text">{{ $comment->komentar }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="padding:24px 0">
                    <p>Belum ada komentar. Jadilah yang pertama!</p>
                </div>
            @endforelse
        </div>

    </div>{{-- /reader-wrap --}}

    {{-- ═══ READER NAV (fixed bottom) ═══ --}}
    <div
        style="position:fixed;bottom:0;left:0;right:0;z-index:90;background:rgba(7,12,36,.96);backdrop-filter:blur(16px);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:14px 40px">
        @if ($prevChapter)
            <a href="{{ route('chapter.show', $prevChapter->id) }}" class="btn-outline">←
                Ch.{{ $prevChapter->urutan }}</a>
        @else
            <button class="btn-outline" disabled style="opacity:.4">← Awal</button>
        @endif

        <div style="flex:1;margin:0 24px">
            <div style="font-size:.72rem;color:var(--text-muted);margin-bottom:5px;text-align:center">
                Chapter {{ $chapter->urutan }} / {{ $totalChapters }} · <span id="read-pct">0%</span> selesai
            </div>
            <div style="height:4px;background:var(--bg-mid);border-radius:2px;overflow:hidden">
                <div id="progress-fill"
                    style="height:100%;background:linear-gradient(to right,var(--accent),var(--accent2));border-radius:2px;width:0%;transition:width .3s">
                </div>
            </div>
        </div>

        @if ($nextChapter)
            <a href="{{ route('chapter.show', $nextChapter->id) }}" class="btn-primary">Ch.{{ $nextChapter->urutan }}
                →</a>
        @else
            <button class="btn-primary" disabled style="opacity:.4">Tamat 🎉</button>
        @endif
    </div>

    {{-- padding bawah agar konten tidak tertutup nav --}}
    <div style="height:72px"></div>

    {{-- ✅ Modal Report --}}
    @include('components.modal-report', ['novelId' => $chapter->novel->id])

@endsection

@push('scripts')
    <script>
        /* scroll progress */
        window.addEventListener('scroll', function() {
            var total = document.documentElement.scrollHeight - window.innerHeight;
            var pct = total > 0 ? Math.min(100, Math.round((window.scrollY / total) * 100)) : 0;
            var pctEl = document.getElementById('read-pct');
            var fill = document.getElementById('progress-fill');
            if (pctEl) pctEl.textContent = pct + '%';
            if (fill) fill.style.width = pct + '%';
        }, {
            passive: true
        });

        /* font size */
        var _fontSize = 18;

        function toggleSettings() {
            const panel = document.getElementById('settings-panel');
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function(e) {
            const panel = document.getElementById('settings-panel');
            const settingsBtn = document.querySelector('.icon-btn[onclick="toggleSettings()"]');
            if (panel && settingsBtn && !panel.contains(e.target) && !settingsBtn.contains(e.target)) {
                panel.style.display = 'none';
            }
        });

        /* ✅ Modal helpers */
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) el.classList.remove('open');
            });
        });
    </script>
@endpush
