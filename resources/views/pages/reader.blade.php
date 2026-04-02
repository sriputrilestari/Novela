@extends('layouts.main')

@section('title', 'Chapter ' . ($chapter->urutan ?? 218) . ' – ' . ($chapter->novel->judul ?? 'Moonlit Sorceress'))

@section('extra-css')
    <style>
        body {
            background: #fdf9f5
        }

        .reader-wrap {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 20px 120px
        }

        #reader-content {
            font-family: 'Lora', serif;
            font-size: 1.1rem;
            color: var(--ink);
            line-height: 1.95;
            padding: 32px 0;
            transition: all .3s
        }

        #reader-content p {
            margin-bottom: 1.6em
        }

        .reader-topbar {
            top: 64px;
            padding: 10px 20px
        }
    </style>
@endsection

@section('content')

    <div class="reader-topbar">
        <div class="reader-topbar-inner"
            style="max-width:700px;margin:0 auto;display:flex;align-items:flex-start;justify-content:space-between;gap:12px">
            <div style="min-width:0">
                <a href="{{ route('novel.show', $chapter->novel_id ?? 1) }}"
                    style="display:inline-flex;align-items:center;gap:5px;font-size:.78rem;color:var(--ink-3);background:var(--bg);padding:4px 10px;border-radius:8px;margin-bottom:6px;text-decoration:none;transition:all .15s"
                    onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--ink-3)'">
                    ← Kembali ke Novel
                </a>
                <div class="reader-novel-title">{{ $chapter->novel->judul ?? 'Moonlit Sorceress' }}</div>
                <div class="reader-chapter-title">Chapter {{ $chapter->urutan ?? 218 }}:
                    {{ $chapter->judul_chapter ?? 'Pertempuran Akhir' }}</div>
            </div>
            <div class="reader-controls">
                <button class="icon-btn" onclick="toggleSettings()" title="Pengaturan Tampilan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </button>
                @auth
                    <form action="{{ route('bookmark.toggle', $chapter->novel_id ?? 1) }}" method="POST"
                        style="display:inline">
                        @csrf
                        <button type="submit" class="icon-btn" title="Favorit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                fill="{{ $isBookmarked ?? false ? 'var(--blue)' : 'none' }}" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </form>
                @endauth
                <button class="icon-btn" onclick="openModal('report-modal')" title="Laporkan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

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
            <div class="settings-row mb-16">
                <div class="settings-label">Tema Baca</div>
                <div class="theme-btns">
                    <div class="theme-swatch" style="background:#fdf9f5;border:1.5px solid var(--line)"
                        onclick="setReadTheme('cream',this)" title="Krem"></div>
                    <div class="theme-swatch active" style="background:#ffffff;border:1.5px solid var(--line)"
                        onclick="setReadTheme('white',this)" title="Putih"></div>
                    <div class="theme-swatch" style="background:#1a1a2e" onclick="setReadTheme('midnight',this)"
                        title="Midnight"></div>
                    <div class="theme-swatch" style="background:#04071a" onclick="setReadTheme('dark',this)" title="Gelap">
                    </div>
                </div>
            </div>
            <div class="settings-row">
                <div class="settings-label">Lebar Konten</div>
                <div class="font-size-controls">
                    <button class="font-size-btn" onclick="changeWidth(-40)">←→</button>
                    <span class="font-size-val" id="width-display">700px</span>
                    <button class="font-size-btn" onclick="changeWidth(40)">← →</button>
                </div>
            </div>
        </div>

        {{-- Chapter Content --}}
        <div id="reader-content">
            <h2
                style="font-family:'Lora',serif;font-size:1.5rem;font-weight:700;color:var(--ink);margin-bottom:28px;line-height:1.3">
                Chapter {{ $chapter->urutan ?? 218 }}: {{ $chapter->judul_chapter ?? 'Pertempuran Akhir' }}
            </h2>

            @if (isset($chapter->isi))
                {!! nl2br(e($chapter->isi)) !!}
            @else
                {{-- Demo content --}}
                <p>Malam itu, langit terasa lebih berat dari biasanya. Lunara berdiri di tepi jurang Teluk Bintang,
                    memandang lautan awan di bawahnya yang berputar seperti mimpi buruk yang tak pernah berakhir. Angin
                    membawa bisikan-bisikan yang tidak sepenuhnya terdengar oleh telinga biasa.</p>
                <p>"Kamu tahu mereka akan datang," suara Orion terdengar dari balik bayangannya—tenang, seperti kolam malam
                    yang sempurna. "Kenapa kamu masih diam di sini?"</p>
                <p>Lunara menggenggam tongkat kristalnya lebih erat. Cahaya bulan mengalir melalui ujungnya, membentuk
                    spiral perak yang perlahan-lahan menyebar ke tanah di bawah kakinya. Ini adalah kekuatan yang belum
                    pernah ia rasakan sepenuhnya—terlalu besar, terlalu lapar, terlalu purba untuk dikandung oleh satu tubuh
                    manusia.</p>
                <p>"Karena kalau aku bergerak," jawabnya akhirnya, "mereka akan tahu aku takut."</p>
                <p>Orion melangkah keluar dari bayangan. Di bawah sinar bulan, bekas luka di wajahnya berkilau seperti tanda
                    bintang—pengingat dari perang yang tidak pernah benar-benar berakhir. Matanya—seperti langit dalam malam
                    tanpa bintang—menatapnya dengan intensitas yang membuat Lunara merasa diselami.</p>
                <p>"Takut bukan kelemahan," katanya pelan. "Takut adalah bukti bahwa kamu mengerti apa yang dipertaruhkan."
                </p>
                <p>Di kejauhan, terdengar suara gemuruh. Pasukan Kegelapan telah menemukan mereka. Dan kali ini, tidak ada
                    tempat untuk bersembunyi.</p>
                <p>Lunara menutup matanya. Di balik kelopak matanya, ia melihat semua wajah yang bergantung padanya—penduduk
                    desa yang dilindunginya, anak-anak yang tertawa bebas di bawah langit yang seharusnya aman. Untuk mereka
                    semua, ia harus berdiri.</p>
                <p>Ketika ia membuka matanya kembali, ada api baru yang menyala di dalam iris birunya. Tongkat kristal
                    bersinar lebih terang dari sebelumnya—cahaya bulan yang murni, tidak tergoyahkan, abadi.</p>
                <p>"Baiklah," bisiknya kepada angin. "Aku akan tunjukkan pada mereka apa artinya melawan cahaya bulan."</p>
            @endif
        </div>

        {{-- End of chapter --}}
        <div
            style="text-align:center;padding:32px 0;border-top:2px dashed var(--line);border-bottom:2px dashed var(--line);margin:32px 0">
            <div style="font-size:1.5rem;margin-bottom:8px">✦</div>
            <div style="font-family:'Lora',serif;font-size:1rem;color:var(--ink-3)">Akhir Chapter
                {{ $chapter->urutan ?? 218 }}</div>
        </div>

        {{-- COMMENT SECTION --}}
        <div style="margin-top:32px">
            <div style="font-family:'Lora',serif;font-size:1.1rem;font-weight:700;margin-bottom:16px">💬 Komentar Chapter
            </div>

            @auth
                <div class="comment-box">
                    <form action="/comment" method="POST">
                        @csrf
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id ?? 1 }}" />
                        <textarea class="comment-input" name="komentar" placeholder="Bagaimana pendapatmu tentang chapter ini?..." required></textarea>
                        <div class="comment-actions">
                            <button type="submit" class="btn-primary btn-sm">Kirim Komentar</button>
                        </div>
                    </form>
                </div>
            @else
                <div
                    style="background:var(--blue-lt);border:1px solid var(--blue-md);border-radius:14px;padding:16px;text-align:center;margin-bottom:20px">
                    <a href="{{ route('login') }}" class="btn-primary btn-sm">Login untuk berkomentar</a>
                </div>
            @endauth

            @forelse($comments ?? [] as $comment)
                <div class="comment-item">
                    <div class="comment-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                    <div class="comment-body">
                        <div class="comment-user">{{ $comment->user->name }} <span
                                class="comment-time">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                        </div>
                        <div class="comment-text">{{ $comment->komentar }}</div>
                        <div class="comment-actions-row">
                            <button class="comment-action-btn" onclick="likeComment(this)">👍 <span>0</span></button>
                            <button class="comment-action-btn">💬 Balas</button>
                            <button class="comment-action-btn" style="color:var(--red)">🚩 Laporkan</button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:32px;color:var(--ink-3)">
                    <div style="font-size:2rem;margin-bottom:8px">💬</div>
                    <div class="text-sm">Belum ada komentar. Jadilah yang pertama!</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- READER NAVIGATION --}}
    <div class="reader-nav">
        @if (isset($prevChapter))
            <a href="{{ route('chapter.show', $prevChapter->id) }}" class="btn-outline">
                ← Ch.{{ $prevChapter->urutan }}
            </a>
        @else
            <button class="btn-ghost" disabled style="opacity:.4">← Prev</button>
        @endif

        <div class="reader-progress" style="flex:1">
            <div class="progress-label">Chapter {{ $chapter->urutan ?? 218 }} / {{ $totalChapters ?? 320 }} · <span
                    id="read-pct">0%</span> selesai</div>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill" style="width:0%"></div>
            </div>
        </div>

        @if (isset($nextChapter))
            <a href="{{ route('chapter.show', $nextChapter->id) }}" class="btn-primary">
                Ch.{{ $nextChapter->urutan }} →
            </a>
        @else
            <button class="btn-ghost" disabled style="opacity:.4">Next →</button>
        @endif
    </div>

@endsection

@section('extra-js')
    <script>
        // Reading progress tracker
        let readerWidth = 700;

        function updateProgress() {
            const el = document.getElementById('reader-content');
            if (!el) return;
            const rect = el.getBoundingClientRect();
            const scrolled = window.scrollY;
            const total = el.offsetHeight + rect.top + scrolled - window.innerHeight;
            const pct = Math.min(100, Math.max(0, Math.round((scrolled / (total || 1)) * 100)));
            document.getElementById('read-pct').textContent = pct + '%';
            document.getElementById('progress-fill').style.width = pct + '%';
            // Auto save ke server tiap 10%
            if (pct % 10 === 0 && pct > 0) saveProgress(pct);
        }
        window.addEventListener('scroll', updateProgress, {
            passive: true
        });
        updateProgress();

        function saveProgress(pct) {
            // AJAX save reading history - fire and forget
            fetch('/api/reading-progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    chapter_id: {{ $chapter->id ?? 1 }},
                    progress: pct
                })
            }).catch(() => {});
        }

        function changeWidth(d) {
            readerWidth = Math.min(900, Math.max(500, readerWidth + d));
            document.querySelector('.reader-wrap').style.maxWidth = readerWidth + 'px';
            document.getElementById('width-display').textContent = readerWidth + 'px';
        }
    </script>
@endsection
