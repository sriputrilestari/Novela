@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --blue: #3d5af1;
            --blue-lt: #eef0fe;
            --blue-md: #dde2fc;
            --green: #00c9a7;
            --green-lt: #e0faf5;
            --amber: #f1a83d;
            --amber-lt: #fef6e6;
            --red: #f1523d;
            --red-lt: #fef0ee;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
        }

        .ch {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes nIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(.96)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        @keyframes nOut {
            to {
                opacity: 0;
                transform: translateY(8px) scale(.94);
                max-height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden
            }
        }

        @keyframes nBar {
            from {
                width: 100%
            }

            to {
                width: 0%
            }
        }

        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(10px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        #ns {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
            pointer-events: none;
        }

        .nt {
            pointer-events: all;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .97);
            backdrop-filter: blur(20px);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px 16px;
            min-width: 300px;
            max-width: 350px;
            box-shadow: 0 8px 28px rgba(24, 25, 42, .12);
            animation: nIn .4s cubic-bezier(.16, 1, .3, 1) both;
        }

        .nt.out {
            animation: nOut .28s ease forwards;
        }

        .nt-ico {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nt-ttl {
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        .nt-msg {
            font-size: 12px;
            color: var(--ink-2);
            margin-top: 1px;
        }

        .nt-x {
            margin-left: auto;
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: #f4f6fc;
            border: 1px solid var(--line);
            color: var(--ink-3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            transition: .18s;
        }

        .nt-x:hover {
            background: var(--line);
            color: var(--ink);
        }

        .nt-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2.5px;
            border-radius: 99px;
            animation: nBar 4.5s linear forwards;
        }

        /* header */
        .pg-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px 26px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(24, 25, 42, .06);
            animation: up .4s ease both;
        }

        .pg-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-3);
            text-decoration: none;
            margin-bottom: 6px;
        }

        .pg-back:hover {
            color: var(--blue);
        }

        .pg-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
        }

        .pg-sub {
            font-size: 12.5px;
            color: var(--ink-3);
            margin-top: 3px;
        }

        .pg-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* buttons */
        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
            white-space: nowrap;
        }

        .btn-edit:hover {
            background: #2d48e0;
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f4f6fc;
            color: var(--ink-2);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 18px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .btn-back:hover {
            background: var(--line);
            color: var(--ink);
        }

        /* meta bar */
        .meta-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(24, 25, 42, .06);
            animation: up .4s .05s ease both;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-ico {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .meta-lbl {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--ink-3);
        }

        .meta-val {
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        .meta-sep {
            width: 1px;
            height: 28px;
            background: var(--line);
        }

        .pill {
            border-radius: 99px;
            padding: 4px 12px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .pill-pub {
            background: var(--green-lt);
            color: #00a08a;
            border: 1px solid rgba(0, 201, 167, .18);
        }

        .pill-dft {
            background: #f4f6fc;
            color: var(--ink-3);
            border: 1px solid var(--line);
        }

        /* content card */
        .ccard {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(24, 25, 42, .06);
            overflow: hidden;
            animation: up .4s .1s ease both;
        }

        .ccard-head {
            padding: 16px 24px;
            border-bottom: 1px solid var(--line);
            background: #f8f9fe;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ccard-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }

        .word-count {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-3);
        }

        .ccard-body {
            padding: 28px 32px;
        }

        /* chapter content */
        .chapter-text {
            font-size: 15px;
            line-height: 1.95;
            color: #2a2b3a;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* timestamps */
        .ts-bar {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        .ts-item {
            font-size: 12px;
            color: var(--ink-3);
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>

    <div id="ns"></div>
    <script>
        const NC = {
            success: {
                b: '#00c9a7',
                i: '#e0faf5',
                t: '#00a88a',
                ic: '✓'
            },
            error: {
                b: '#f1523d',
                i: '#fef0ee',
                t: '#c43020',
                ic: '✗'
            },
            warn: {
                b: '#f1a83d',
                i: '#fef6e6',
                t: '#c48020',
                ic: '!'
            },
            info: {
                b: '#3d5af1',
                i: '#eef0fe',
                t: '#2d48e0',
                ic: 'ℹ'
            }
        };

        function showN(type, title, msg) {
            const c = NC[type] || NC.info,
                el = document.createElement('div');
            el.className = 'nt';
            el.innerHTML =
                `<div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div><div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div><button class="nt-x" onclick="closeN(this.parentElement)">✕</button>`;
            const bar = document.createElement('div');
            bar.className = 'nt-bar';
            bar.style.background = c.b;
            el.appendChild(bar);
            document.getElementById('ns').appendChild(el);
            setTimeout(() => closeN(el), 4500);
        }

        function closeN(el) {
            if (!el || el.classList.contains('out')) return;
            el.classList.add('out');
            setTimeout(() => el && el.remove(), 300);
        }
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showN('success', 'Berhasil', @json(session('success')));
            @endif
            @if (session('error'))
                showN('error', 'Gagal', @json(session('error')));
            @endif

            // word count
            const text = document.getElementById('chapterText');
            if (text) {
                const words = text.textContent.trim().split(/\s+/).filter(w => w).length;
                const el = document.getElementById('wordCount');
                if (el) el.textContent = words.toLocaleString('id-ID') + ' kata';
            }
        });
    </script>

    <div class="ch">

        {{-- HEADER --}}
        <div class="pg-head">
            <div>
                <a href="{{ route('author.chapter.index', $novel->id) }}" class="pg-back">← Daftar Chapter</a>
                <div class="pg-title">{{ $chapter->judul_chapter }}</div>
                <div class="pg-sub">{{ $novel->judul }}</div>
            </div>
        </div>

        {{-- META BAR --}}
        <div class="meta-bar">
            <div class="meta-item">
                <div class="meta-ico" style="background:var(--blue-lt);color:var(--blue)">🔢</div>
                <div>
                    <div class="meta-lbl">Urutan</div>
                    <div class="meta-val">Chapter {{ $chapter->urutan }}</div>
                </div>
            </div>
            <div class="meta-sep"></div>
            <div class="meta-item">
                <div class="meta-ico" style="background:var(--green-lt);color:#00a08a">📌</div>
                <div>
                    <div class="meta-lbl">Status</div>
                    <div style="margin-top:3px;">
                        @if ($chapter->status === 'published')
                            <span class="pill pill-pub">Published</span>
                        @else
                            <span class="pill pill-dft">Draft</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="meta-sep"></div>
            <div class="meta-item">
                <div class="meta-ico" style="background:var(--amber-lt);color:var(--amber)">📖</div>
                <div>
                    <div class="meta-lbl">Jumlah Kata</div>
                    <div class="meta-val" id="wordCount">— kata</div>
                </div>
            </div>
        </div>

        {{-- CONTENT CARD --}}
        <div class="ccard">
            <div class="ccard-head">
                <div class="ccard-title">📄 Isi Chapter</div>
            </div>
            <div class="ccard-body">
                <div class="chapter-content" id="chapterText">
                    {!! nl2br(e($chapter->isi)) !!}
                </div>

                <div class="ts-bar">
                    <span class="ts-item">🕐 Dibuat: {{ $chapter->created_at->format('d M Y, H:i') }}</span>
                    <span class="ts-item">🔄 Diupdate: {{ $chapter->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <script>
            // Tunggu halaman sepenuhnya dimuat
            document.addEventListener('DOMContentLoaded', function() {
                const chapterEl = document.getElementById('chapterText');
                const wordCountEl = document.getElementById('wordCount');

                if (chapterEl && wordCountEl) {
                    // Ambil text mentah tanpa tag HTML
                    const text = chapterEl.textContent || '';
                    // Hitung kata
                    const words = text.trim().split(/\s+/).filter(w => w.length > 0);
                    wordCountEl.textContent = `${words.length} kata`;
                }
            });
        </script>
    @endsection
