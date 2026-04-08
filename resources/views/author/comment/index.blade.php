@extends('author.layouts.app')

@section('title', 'Komentar & Feedback')

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
            --red: #f1523d;
            --red-lt: #fef0ee;
            --amber: #f1a83d;
            --amber-lt: #fef6e6;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
        }

        * {
            box-sizing: border-box;
        }

        .cm {
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

        /* notif */
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

        /* stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 20px;
            animation: up .4s .05s ease both;
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 8px rgba(24, 25, 42, .05);
        }

        .stat-ico {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .si-blue {
            background: var(--blue-lt);
        }

        .si-red {
            background: var(--red-lt);
        }

        .stat-lbl {
            font-size: 11px;
            font-weight: 700;
            color: var(--ink-3);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-num {
            font-size: 26px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1.2;
        }

        /* card */
        .tcard {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(24, 25, 42, .06);
            overflow: hidden;
            animation: up .4s .1s ease both;
        }

        .tcard-head {
            padding: 14px 22px;
            border-bottom: 1px solid var(--line);
            background: #f8f9fe;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-tab {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            border: 1.5px solid var(--line);
            background: #fff;
            color: var(--ink-2);
            transition: .18s;
            font-family: inherit;
        }

        .filter-tab:hover {
            background: #f4f6fb;
            text-decoration: none;
        }

        .filter-tab.active-all {
            background: var(--blue-lt);
            color: var(--blue);
            border-color: var(--blue-md);
        }

        .filter-tab.active-toxic {
            background: var(--red-lt);
            color: var(--red);
            border-color: #fcd0ca;
        }

        /* comment row */
        .cm-row {
            padding: 18px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition: background .15s;
        }

        .cm-row:last-child {
            border-bottom: none;
        }

        .cm-row:hover {
            background: #fafbfe;
        }

        .cm-row.toxic {
            background: #fff8f8;
        }

        .cm-row.hidden {
            background: #fffdf0;
        }

        /* strip */
        .cm-strip {
            width: 4px;
            min-height: 80px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        /* avatar */
        .cm-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue), #2d48e0);
        }

        /* content */
        .cm-content {
            flex: 1;
            min-width: 0;
        }

        .cm-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .cm-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
        }

        .cm-info {
            font-size: 11.5px;
            color: var(--ink-3);
        }

        /* pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
        }

        .pill-publik {
            background: var(--green-lt);
            color: #00a88a;
            border: 1px solid #b0ede3;
        }

        .pill-toxic {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid #fcd0ca;
        }

        .pill-hidden {
            background: var(--amber-lt);
            color: #c48020;
            border: 1px solid #fde5b0;
        }

        /* comment bubble */
        .cm-bubble {
            background: #f8f9fe;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13.5px;
            color: var(--ink-2);
            line-height: 1.75;
            margin-bottom: 10px;
        }

        /* replies */
        .cm-replies {
            border-left: 2.5px solid var(--line);
            padding-left: 14px;
            margin-bottom: 10px;
        }

        .reply-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 8px;
        }

        .reply-item:last-child {
            margin-bottom: 0;
        }

        .reply-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .reply-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-2);
        }

        .reply-text {
            font-size: 12.5px;
            color: var(--ink-3);
            line-height: 1.5;
        }

        .more-replies {
            font-size: 12px;
            font-weight: 600;
            color: var(--blue);
            text-decoration: none;
        }

        .more-replies:hover {
            text-decoration: underline;
        }

        /* reply form */
        .reply-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .reply-input {
            flex: 1;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 9px 14px;
            font-family: inherit;
            font-size: 13px;
            color: var(--ink);
            background: #fff;
            outline: none;
            transition: .2s;
        }

        .reply-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .btn-reply {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 9px 16px;
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-reply:hover {
            background: #2d48e0;
        }

        /* action buttons (right) */
        .cm-acts {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex-shrink: 0;
        }

        .act-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            border: 1.5px solid var(--line);
            background: #fff;
            color: var(--ink-2);
            transition: .18s;
            font-family: inherit;
        }

        .act-btn:hover {
            background: #f4f6fb;
        }

        .btn-view {
            background: var(--blue-lt);
            border-color: var(--blue-md);
        }

        .btn-view:hover {
            background: var(--blue-md);
        }

        .btn-warn {
            background: var(--amber-lt);
            border-color: #fde5b0;
        }

        .btn-warn:hover {
            background: #fde5b0;
        }

        .btn-del {
            background: var(--red-lt);
            border-color: #fcd0ca;
        }

        .btn-del:hover {
            background: #fcd0ca;
        }

        /* empty */
        .empty-state {
            padding: 3.5rem 1rem;
            text-align: center;
        }

        .empty-ico {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .empty-txt {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink-3);
        }

        .empty-sub {
            font-size: 12.5px;
            color: var(--ink-3);
            margin-top: 4px;
        }

        /* pagination */
        .pg-nav {
            padding: 14px 20px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: flex-end;
        }
    </style>

    {{-- Notif --}}
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
            }
        };

        function showN(type, title, msg) {
            const c = NC[type] || NC.success,
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
        });
    </script>

    <div class="cm">

        {{-- Header --}}
        <div class="pg-head">
            <div>
                <div class="pg-title">💬 Komentar & Feedback</div>
                <div class="pg-sub">Kelola komentar reader dari semua novel kamu</div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats">
            <div class="stat-card">
                <div class="stat-ico si-blue">💬</div>
                <div>
                    <div class="stat-lbl">Total Komentar</div>
                    <div class="stat-num">{{ $totalAll }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-ico si-red">☣️</div>
                <div>
                    <div class="stat-lbl">Komentar Toxic</div>
                    <div class="stat-num">{{ $totalToxic }}</div>
                </div>
            </div>
        </div>

        {{-- Card --}}
        <div class="tcard">
            {{-- Filter tabs --}}
            <div class="tcard-head">
                <a href="{{ route('author.comment.index', ['filter' => 'all']) }}"
                    class="filter-tab {{ $filter === 'all' ? 'active-all' : '' }}">
                    📋 Semua
                </a>
                <a href="{{ route('author.comment.index', ['filter' => 'toxic']) }}"
                    class="filter-tab {{ $filter === 'toxic' ? 'active-toxic' : '' }}">
                    ☣️ Toxic
                </a>
            </div>

            {{-- List --}}
            @forelse($comments as $comment)
                @php
                    $isToxic = $comment->is_toxic;
                    $isHidden = $comment->is_hidden;
                @endphp
                <div class="cm-row {{ $isToxic ? 'toxic' : ($isHidden ? 'hidden' : '') }}">

                    {{-- Strip --}}
                    <div class="cm-strip"
                        style="background:{{ $isToxic ? 'var(--red)' : ($isHidden ? 'var(--amber)' : 'var(--blue)') }}">
                    </div>

                    {{-- Avatar --}}
                    <div class="cm-avatar"
                        style="background:{{ $isToxic ? 'linear-gradient(135deg,var(--red),#c43020)' : ($isHidden ? 'linear-gradient(135deg,var(--amber),#c48020)' : 'linear-gradient(135deg,var(--blue),#2d48e0)') }}">
                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                    </div>

                    {{-- Content --}}
                    <div class="cm-content">

                        {{-- Meta --}}
                        <div class="cm-meta">
                            <span class="cm-name">{{ $comment->user->name ?? 'Pengguna' }}</span>

                            @if ($isToxic)
                                <span class="pill pill-toxic">☣️ Toxic</span>
                            @elseif($isHidden)
                                <span class="pill pill-hidden">🙈 Tersembunyi</span>
                            @else
                                <span class="pill pill-publik">✅ Publik</span>
                            @endif

                            <span class="cm-info">
                                📖 <strong>{{ $comment->chapter->novel->judul ?? '-' }}</strong>
                                · Bab {{ $comment->chapter->urutan ?? '-' }}
                                · {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>

                        @if ($comment->hidden_reason)
                            <div style="margin-bottom:8px;">
                                <span class="pill pill-hidden" style="font-size:11.5px;">
                                    ℹ️ Alasan: {{ $comment->hidden_reason }}
                                </span>
                            </div>
                        @endif

                        {{-- Bubble --}}
                        <div class="cm-bubble" style="{{ $isHidden ? 'opacity:.6' : '' }}">
                            {{ $comment->komentar }}
                        </div>

                        {{-- Replies preview --}}
                        @if ($comment->replies->count() > 0)
                            <div class="cm-replies">
                                @foreach ($comment->replies->take(2) as $reply)
                                    <div class="reply-item">
                                        <div class="reply-avatar"
                                            style="background:{{ $reply->user_id === Auth::id() ? '#00c9a7' : 'var(--ink-3)' }}">
                                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="reply-name">
                                                {{ $reply->user->name ?? 'User' }}
                                                @if ($reply->user_id === Auth::id())
                                                    <span class="pill pill-publik"
                                                        style="font-size:10px;padding:2px 7px;">Kamu</span>
                                                @endif
                                            </div>
                                            <div class="reply-text">{{ Str::limit($reply->komentar, 90) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($comment->replies->count() > 2)
                                    <a href="{{ route('author.comment.show', $comment->id) }}" class="more-replies">
                                        +{{ $comment->replies->count() - 2 }} balasan lainnya →
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Quick reply --}}
                        <form method="POST" action="{{ route('author.comment.reply', $comment->id) }}" class="reply-form">
                            @csrf
                            <input type="text" name="komentar" class="reply-input" placeholder="Tulis balasan..."
                                required maxlength="1000">
                            <button type="submit" class="btn-reply">↩ Balas</button>
                        </form>

                    </div>

                    {{-- Action buttons --}}
                    <div class="cm-acts">
                        {{-- <a href="{{ route('author.comment.show', $comment->id) }}" class="act-btn btn-view"
                            title="Detail">👁</a> --}}

                        @if (!$isToxic)
                            <form method="POST" action="{{ route('author.comment.toxic', $comment->id) }}"
                                onsubmit="return confirm('Tandai komentar ini sebagai toxic?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="act-btn btn-warn" title="Tandai toxic">☣️</button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('author.comment.destroy', $comment->id) }}"
                            onsubmit="return confirm('Hapus komentar ini permanen?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn btn-del" title="Hapus">🗑</button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-ico">💬</div>
                    <div class="empty-txt">Belum ada komentar</div>
                    <div class="empty-sub">Komentar dari reader akan muncul di sini</div>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($comments->hasPages())
                <div class="pg-nav">{{ $comments->links() }}</div>
            @endif
        </div>

    </div>
@endsection
