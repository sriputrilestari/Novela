@extends('layouts.admin')

@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
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
            --purple: #a855f7;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
            --bg: #f4f6fc;
            --white: #ffffff;
            --radius: 16px;
            --shadow: 0 2px 16px rgba(24, 25, 42, .07);
            --shadow-h: 0 8px 32px rgba(24, 25, 42, .13);
        }

        * {
            box-sizing: border-box;
        }

        .dash {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            padding-bottom: 72px;
        }

        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes bar {
            from {
                width: 100%
            }

            to {
                width: 0%
            }
        }

        @keyframes notIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(.96)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        @keyframes notOt {
            to {
                opacity: 0;
                transform: translateY(8px) scale(.94);
                max-height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden
            }
        }

        .a1 {
            animation: up .5s .00s ease both;
        }

        .a2 {
            animation: up .5s .07s ease both;
        }

        .a3 {
            animation: up .5s .13s ease both;
        }

        .a4 {
            animation: up .5s .19s ease both;
        }

        /* ════ NOTIFICATION ════ */
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
            animation: notIn .4s cubic-bezier(.16, 1, .3, 1) both;
        }

        .nt.out {
            animation: notOt .28s ease forwards;
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
            line-height: 1.4;
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
            animation: bar 4.5s linear forwards;
        }

        /* ════ BANNER ════ */
        .banner {
            background: linear-gradient(130deg, var(--blue) 0%, #2d48e0 50%, #1e3bce 100%);
            border-radius: 20px;
            padding: 30px 36px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 80% 50%, rgba(255, 255, 255, .08) 0%, transparent 60%);
            pointer-events: none;
        }

        .bn-date {
            font-size: 11.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, .55);
            letter-spacing: .4px;
            margin-bottom: 8px;
        }

        .bn-name {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .bn-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .6);
            margin-top: 8px;
        }

        .bn-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 10px;
            padding: 10px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            color: #fff;
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .24);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-white {
            background: #fff;
            border: 1px solid #fff;
            color: var(--blue);
        }

        .btn-white:hover {
            background: #eef0fe;
            color: var(--blue);
            transform: translateY(-1px);
        }

        /* ════ ALERT PENDING ════ */
        .alert-pending {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--amber-lt);
            border: 1px solid rgba(241, 168, 61, .3);
            border-left: 4px solid var(--amber);
            color: #92650a;
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-bottom: 20px;
        }

        .alert-pending strong {
            color: #7a5008;
        }

        .alert-pending .btn-review {
            margin-left: auto;
            background: var(--amber);
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s;
        }

        .alert-pending .btn-review:hover {
            background: #d4922a;
            color: #fff;
            transform: translateY(-1px);
        }

        /* ════ STATS ════ */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:480px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }

        .scard {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: var(--shadow);
            transition: .22s;
            cursor: default;
        }

        .scard:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-h);
        }

        .scard-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .scard-ico {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        .scard-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 99px;
        }

        .pill-blue {
            background: var(--blue-lt);
            color: #2d48e0;
        }

        .pill-green {
            background: var(--green-lt);
            color: #00a88a;
        }

        .pill-amber {
            background: var(--amber-lt);
            color: #b07010;
        }

        .pill-gray {
            background: #f4f6fc;
            color: var(--ink-3);
        }

        .scard-num {
            font-size: 32px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
        }

        .scard-lbl {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-3);
            margin-top: 3px;
        }

        .scard-track {
            height: 4px;
            background: #eef1f7;
            border-radius: 99px;
            overflow: hidden;
        }

        .scard-fill {
            height: 100%;
            border-radius: 99px;
            width: 0;
            transition: width 1.3s cubic-bezier(.16, 1, .3, 1);
        }

        /* ════ STATUS PANEL ════ */
        .status-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 18px 22px;
        }

        @media(max-width:600px) {
            .status-grid {
                grid-template-columns: 1fr;
            }
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8f9fe;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px 16px;
            transition: .2s;
        }

        .status-item:hover {
            border-color: var(--blue);
            background: var(--blue-lt);
        }

        .si-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
        }

        .si-sub {
            font-size: 11.5px;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .si-num {
            font-size: 18px;
            font-weight: 800;
            flex-shrink: 0;
            margin-left: 12px;
        }

        /* ════ BOX SHELL ════ */
        .box {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .box-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--line);
        }

        .box-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--ink);
        }

        .box-sub {
            font-size: 12px;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .box-link {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--blue);
            text-decoration: none;
            white-space: nowrap;
        }

        .box-link:hover {
            text-decoration: underline;
        }

        /* ════ MAIN GRID ════ */
        .main {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
        }

        @media(max-width:960px) {
            .main {
                grid-template-columns: 1fr;
            }
        }

        .col-l {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .col-r {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ════ TABLE ════ */
        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .tbl thead th {
            padding: 10px 20px;
            font-size: 11px;
            letter-spacing: .7px;
            text-transform: uppercase;
            color: var(--ink-3);
            font-weight: 700;
            background: #f8f9fe;
            border-bottom: 1px solid var(--line);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .tbl tbody td {
            padding: 13px 20px;
            border-bottom: 1px solid #f2f4fb;
            color: var(--ink);
            vertical-align: middle;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .tbl tbody tr:hover td {
            background: #fafbff;
        }

        .tag {
            border-radius: 99px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .tag-pend {
            background: var(--amber-lt);
            color: #b07010;
            border: 1px solid rgba(241, 168, 61, .2);
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: .15s;
            text-decoration: none;
        }

        .btn-action:hover {
            filter: brightness(.88);
            transform: translateY(-1px);
        }

        .btn-action.approve {
            background: var(--green-lt);
            color: #00a08a;
        }

        .btn-action.reject {
            background: var(--red-lt);
            color: var(--red);
        }

        .btn-action.detail {
            background: var(--blue-lt);
            color: var(--blue);
        }

        /* ════ DONUT ════ */
        .donut-wrap {
            padding: 20px 24px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .donut-pie {
            position: relative;
            height: 200px;
            width: 100%;
        }

        .chart-legend {
            display: flex;
            flex-direction: column;
            gap: 9px;
            margin-top: 16px;
            width: 100%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 13px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .legend-label {
            color: var(--ink-3);
            flex: 1;
        }

        .legend-value {
            font-weight: 700;
            color: var(--ink);
        }

        .action-group form {
            display: inline;
        }
    </style>

    {{-- NOTIFICATION --}}
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
            info: {
                b: '#3d5af1',
                i: '#eef0fe',
                t: '#2d48e0',
                ic: 'ℹ'
            },
            warn: {
                b: '#f1a83d',
                i: '#fef6e6',
                t: '#c48020',
                ic: '!'
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
            @if (session('warning'))
                showN('warn', 'Perhatian', @json(session('warning')));
            @endif
            @if (session('info'))
                showN('info', 'Info', @json(session('info')));
            @endif
        });
    </script>

    <div class="dash">

        {{-- BANNER --}}
        <div class="banner a1">
            <div>
                <div class="bn-date" id="bnDate"></div>
                <div class="bn-name">Halo, Admin 👋</div>
                <div class="bn-sub">Pantau dan kelola platform novelmu hari ini.</div>
            </div>
            <div class="bn-btns">
                <a href="{{ route('admin.novels.index') }}" class="btn btn-white">📚 Kelola Novel</a>
                <a href="{{ route('admin.reader.index') }}" class="btn btn-ghost">👥 Kelola User</a>
            </div>
        </div>

        {{-- ALERT PENDING --}}
        @if ($novelPending > 0)
            <div class="alert-pending a2">
                <span>⚠️</span>
                Ada <strong style="margin:0 4px;">{{ $novelPending }}</strong> novel menunggu persetujuan
                <a href="#pending" class="btn-review">Review Sekarang</a>
            </div>
        @endif

        {{-- STATS --}}
        <div class="stats a2">

            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:#eef0fe">📚</div>
                    <span class="scard-pill pill-blue">Total</span>
                </div>
                <div>
                    <div class="scard-num ctr" data-v="{{ $totalNovel }}">0</div>
                    <div class="scard-lbl">Total Novel</div>
                </div>
                <div class="scard-track">
                    <div class="scard-fill" style="background:var(--blue)" data-p="{{ min(100, $totalNovel * 10) }}"></div>
                </div>
            </div>

            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:#e0faf5">✍️</div>
                    <span class="scard-pill pill-green">Aktif</span>
                </div>
                <div>
                    <div class="scard-num ctr" data-v="{{ $totalAuthor }}">0</div>
                    <div class="scard-lbl">Total Author</div>
                </div>
                <div class="scard-track">
                    <div class="scard-fill" style="background:var(--green)" data-p="{{ min(100, $totalAuthor * 10) }}">
                    </div>
                </div>
            </div>

            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:#f5f0fe">👥</div>
                    <span class="scard-pill pill-gray">Total</span>
                </div>
                <div>
                    <div class="scard-num ctr" data-v="{{ $totalReader }}">0</div>
                    <div class="scard-lbl">Total Reader</div>
                </div>
                <div class="scard-track">
                    <div class="scard-fill" style="background:var(--purple)" data-p="{{ min(100, $totalReader * 10) }}">
                    </div>
                </div>
            </div>

            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:#fef6e6">⏳</div>
                    <span class="scard-pill pill-amber">Review</span>
                </div>
                <div>
                    <div class="scard-num ctr" data-v="{{ $novelPending }}">0</div>
                    <div class="scard-lbl">Novel Pending</div>
                </div>
                <div class="scard-track">
                    <div class="scard-fill" style="background:var(--amber)"
                        data-p="{{ $totalNovel > 0 ? min(100, ($novelPending / $totalNovel) * 100) : 0 }}"></div>
                </div>
            </div>

        </div>

        {{-- STATUS RINGKASAN --}}
        <div class="box a3" style="margin-bottom:16px;">
            <div class="box-head">
                <div>
                    <div class="box-title">📋 Ringkasan Platform</div>
                    <div class="box-sub">Status keseluruhan konten dan pengguna</div>
                </div>
            </div>
            <div class="status-grid">
                <div class="status-item">
                    <div>
                        <div class="si-label">✅ Novel Published</div>
                        <div class="si-sub">Novel yang sudah tayang</div>
                    </div>
                    <div class="si-num" style="color:var(--green)">{{ $publishedNovel ?? 0 }}</div>
                </div>
                <div class="status-item">
                    <div>
                        <div class="si-label">⏳ Novel Pending</div>
                        <div class="si-sub">Menunggu persetujuan admin</div>
                    </div>
                    <div class="si-num" style="color:var(--amber)">{{ $novelPending }}</div>
                </div>
                <div class="status-item">
                    <div>
                        <div class="si-label">✍️ Total Author</div>
                        <div class="si-sub">Penulis terdaftar</div>
                    </div>
                    <div class="si-num" style="color:var(--blue)">{{ $totalAuthor }}</div>
                </div>
                <div class="status-item">
                    <div>
                        <div class="si-label">👥 Total Reader</div>
                        <div class="si-sub">Pembaca terdaftar</div>
                    </div>
                    <div class="si-num" style="color:var(--purple)">{{ $totalReader }}</div>
                </div>
            </div>
        </div>

        {{-- MAIN GRID --}}
        <div class="main a4">

            {{-- KIRI: Tabel Pending --}}
            <div class="col-l">
                <div id="pending" class="box">
                    <div class="box-head">
                        <div>
                            <div class="box-title">📝 Novel Menunggu Persetujuan</div>
                            <div class="box-sub">{{ $novelPending }} novel perlu direview</div>
                        </div>
                        @if ($novelPending > 0)
                            <span
                                style="background:var(--amber-lt);color:#b07010;border:1px solid rgba(241,168,61,.2);font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;">
                                {{ $novelPending }} pending
                            </span>
                        @endif
                    </div>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingNovels as $novel)
                                <tr>
                                    <td style="font-weight:600;">{{ $novel->judul }}</td>
                                    <td style="color:var(--ink-2);">{{ $novel->author->name }}</td>
                                    <td><span class="tag tag-pend">⏳ Pending</span></td>
                                    <td>
                                        <div class="action-group">

                                            {{-- APPROVE --}}
                                            <form action="{{ route('admin.novels.updateStatus', $novel->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="approval_status" value="published">
                                                <button type="button" class="btn-action approve"
                                                    onclick="confirmAction('Setujui novel ini?', () => this.closest('form').submit())">
                                                    ✓
                                                </button>
                                            </form>

                                            {{-- REJECT --}}
                                            <form action="{{ route('admin.novels.updateStatus', $novel->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="approval_status" value="rejected">
                                                <button type="button" class="btn-action reject"
                                                    onclick="confirmAction('Tolak novel ini?', () => this.closest('form').submit())">
                                                    ✕
                                                    </button>
                                            </form>

                                            {{-- DETAIL --}}
                                            <a href="{{ route('admin.novels.show', $novel->id) }}"
                                                class="btn-action detail">◉</a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        style="text-align:center;padding:36px;color:var(--ink-3);font-size:13px;">
                                        <div style="font-size:36px;margin-bottom:10px;">🎉</div>
                                        Semua novel sudah diproses!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- KANAN: Donut Chart --}}
            <div class="col-r">
                <div class="box">
                    <div class="box-head">
                        <div>
                            <div class="box-title">📊 Perbandingan Data</div>
                            <div class="box-sub">Distribusi konten platform</div>
                        </div>
                    </div>
                    <div class="donut-wrap">
                        <div class="donut-pie">
                            <canvas id="donutChart"></canvas>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-dot" style="background:#3d5af1"></div>
                                <span class="legend-label">Total Novel</span>
                                <span class="legend-value">{{ $totalNovel }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background:#00c9a7"></div>
                                <span class="legend-label">Author</span>
                                <span class="legend-value">{{ $totalAuthor }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background:#a855f7"></div>
                                <span class="legend-label">Reader</span>
                                <span class="legend-value">{{ $totalReader }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background:#f1a83d"></div>
                                <span class="legend-label">Pending</span>
                                <span class="legend-value">{{ $novelPending }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById('bnDate').textContent =
                new Date().toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

            // counter animasi
            document.querySelectorAll('.ctr').forEach(el => {
                const max = parseInt(el.dataset.v) || 0;
                let n = 0,
                    step = Math.max(1, Math.ceil(max / 50));
                const t = setInterval(() => {
                    n = Math.min(n + step, max);
                    el.textContent = n.toLocaleString('id-ID');
                    if (n >= max) clearInterval(t);
                }, 28);
            });

            // progress bars
            setTimeout(() => {
                document.querySelectorAll('.scard-fill[data-p]').forEach(b => {
                    b.style.width = b.dataset.p + '%';
                });
            }, 250);

            // donut chart
            const ctx = document.getElementById('donutChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Novel', 'Author', 'Reader', 'Pending'],
                        datasets: [{
                            data: [
                                {{ $totalNovel }},
                                {{ $totalAuthor }},
                                {{ $totalReader }},
                                {{ $novelPending }}
                            ],
                            backgroundColor: ['#3d5af1', '#00c9a7', '#a855f7', '#f1a83d'],
                            hoverBackgroundColor: ['#2d48e0', '#00a88a', '#9333ea', '#d4922a'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverBorderColor: '#ffffff',
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#18192a',
                                titleColor: '#fff',
                                bodyColor: '#9698ae',
                                padding: 11,
                                cornerRadius: 9,
                                callbacks: {
                                    label: c => '  ' + c.label + ': ' + c.raw.toLocaleString('id-ID')
                                }
                            }
                        }
                    }
                });
            }

        });
    </script>
@endsection
