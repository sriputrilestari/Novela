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
            --red: #f1523d;
            --red-lt: #fef0ee;
            --amber: #f1a83d;
            --amber-lt: #fef6e6;
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

        /* ── Notif Toast ── */
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

        /* ── Page Header ── */
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

        .btn-add {
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
            cursor: pointer;
            text-decoration: none;
            transition: .2s;
        }

        .btn-add:hover {
            background: #2d48e0;
            transform: translateY(-1px);
            color: #fff;
            text-decoration: none;
        }

        /* ── Stat Cards ── */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
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

        .si-green {
            background: var(--green-lt);
        }

        .si-gray {
            background: #f4f6fb;
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

        /* ── Table Card ── */
        .tcard {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(24, 25, 42, .06);
            overflow: hidden;
            animation: up .4s .1s ease both;
        }

        .tcard-head {
            padding: 16px 24px;
            border-bottom: 1px solid var(--line);
            background: #f8f9fe;
        }

        .tcard-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            background: #f8f9fe;
            padding: 11px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: var(--ink-3);
            letter-spacing: .5px;
            text-transform: uppercase;
            border-bottom: 1px solid var(--line);
        }

        th.tc {
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid var(--line);
            transition: background .15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f8f9fe;
        }

        td {
            padding: 13px 16px;
            vertical-align: middle;
        }

        td.tc {
            text-align: center;
        }

        .num-badge {
            background: #f4f6fb;
            border: 1.5px solid var(--line);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-2);
            display: inline-block;
        }

        .ch-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
        }

        .ch-time {
            font-size: 11.5px;
            color: var(--ink-3);
            margin-top: 2px;
        }

        /* ── Pills ── */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 999px;
            padding: 4px 11px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .pill-pub {
            background: var(--green-lt);
            color: #00a88a;
        }

        .pill-dft {
            background: #f4f6fb;
            color: var(--ink-3);
            border: 1.5px solid var(--line);
        }

        /* ── Action Buttons ── */
        .acts {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .act-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 11px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
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
            text-decoration: none;
        }

        .btn-view {
            background: var(--blue-lt);
            color: var(--blue);
            border-color: var(--blue-md);
        }

        .btn-view:hover {
            background: var(--blue-md);
            color: var(--blue);
        }

        .btn-edit {
            background: var(--amber-lt);
            color: #c48020;
            border-color: #fde5b0;
        }

        .btn-edit:hover {
            background: #fde5b0;
            color: #c48020;
        }

        .btn-pub {
            background: var(--green-lt);
            color: #00a88a;
            border-color: #b0ede3;
        }

        .btn-pub:hover {
            background: #b0ede3;
            color: #00a88a;
        }

        .btn-dft {
            background: #f4f6fb;
            color: var(--ink-3);
            border-color: var(--line);
        }

        .btn-dft:hover {
            background: var(--line);
            color: var(--ink-2);
        }

        .btn-del {
            background: var(--red-lt);
            color: var(--red);
            border-color: #fcd0ca;
        }

        .btn-del:hover {
            background: #fcd0ca;
            color: var(--red);
        }

        /* ── Empty State ── */
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

        /* ── Modal ── */
        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(24, 25, 42, .45);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-bg.show {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--line);
            padding: 2rem 1.75rem;
            max-width: 350px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(24, 25, 42, .18);
        }

        .modal-ico {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .modal-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .modal-msg {
            font-size: 13px;
            color: var(--ink-2);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .modal-btns {
            display: flex;
            gap: 10px;
        }

        .modal-btn {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid var(--line);
            font-family: inherit;
            transition: .18s;
        }

        .mbtn-cancel {
            background: #f4f6fb;
            color: var(--ink-2);
        }

        .mbtn-cancel:hover {
            background: var(--line);
        }

        .mbtn-del {
            background: var(--red);
            color: #fff;
            border-color: var(--red);
        }

        .mbtn-del:hover {
            background: #d43020;
        }
    </style>

    {{-- ── Notif Toast ── --}}
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
        });
    </script>

    <div class="ch">

        {{-- ── Header ── --}}
        <div class="pg-head">
            <div>
                <a href="{{ route('author.novel.index') }}" class="pg-back">← Kembali ke Novel</a>
               <div class="pg-title">📖 {{ $novel->judul }}</div>
                <div class="pg-sub">Kelola chapter novelmu di sini</div>
            </div>
            <a href="{{ route('author.chapter.create', $novel->id) }}" class="btn-add">
                + Tambah Chapter
            </a>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="stats">
            <div class="stat-card">
                <div class="stat-ico si-green">✅</div>
                <div>
                    <div class="stat-lbl">Published</div>
                    <div class="stat-num">{{ $published }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-ico si-gray">📝</div>
                <div>
                    <div class="stat-lbl">Draft</div>
                    <div class="stat-num">{{ $draft }}</div>
                </div>
            </div>
        </div>

        {{-- ── Table Card ── --}}
        <div class="tcard">
            <div class="tcard-head">
                <div class="tcard-title">📋 Daftar Chapter</div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th width="70">No.</th>
                            <th>Judul Chapter</th>
                            <th width="130">Status</th>
                            <th width="290" class="tc">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($chapters as $index => $chapter)
                            <tr>
                                <td>
                                    <span class="num-badge">{{ $chapter->urutan }}</span>
                                </td>

                                <td>
                                  <div class="ch-title">{{ $chapter->judul_chapter }}</div>
                                    <div class="ch-time">Diupdate {{ $chapter->updated_at->diffForHumans() }}</div>
                                </td>

                                <td>
                                    @if ($chapter->status === 'published')
                                        <span class="pill pill-pub">🟢 Published</span>
                                    @else
                                        <span class="pill pill-dft">⬜ Draft</span>
                                    @endif
                                </td>

                                <td class="tc">
                                    <div class="acts">

                                        <a href="{{ route('author.chapter.show', [$novel->id, $chapter->id]) }}"
                                            class="act-btn btn-view">👁 View</a>

                                        <a href="{{ route('author.chapter.edit', [$novel->id, $chapter->id]) }}"
                                            class="act-btn btn-edit">✏️ Edit</a>

                                        {{-- Toggle --}}
                                        <form action="{{ route('author.chapter.toggle', [$novel->id, $chapter->id]) }}"
                                            method="POST" class="toggle-form" style="margin:0;">
                                            @csrf
                                            @method('PATCH')
                                            @if ($chapter->status === 'published')
                                                <button type="submit" class="act-btn btn-dft">Draft</button>
                                            @else
                                                <button type="submit" class="act-btn btn-pub">🚀 Publish</button>
                                            @endif
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('author.chapter.destroy', [$novel->id, $chapter->id]) }}"
                                            method="POST" class="del-form" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="act-btn btn-del"
                                                onclick="openModal(this)">🗑</button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-ico">📭</div>
                                        <div class="empty-txt">Belum ada chapter</div>
                                        <div class="empty-sub">Klik "+ Tambah Chapter" untuk mulai menulis</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ── Modal Delete ── --}}
    <div class="modal-bg" id="delModal">
        <div class="modal-box">
            <div class="modal-ico">🗑️</div>
            <div class="modal-title">Hapus Chapter?</div>
            <div class="modal-msg">
                Tindakan ini tidak bisa dibatalkan.<br>
                Chapter akan dihapus permanen.
            </div>
            <div class="modal-btns">
                <button class="modal-btn mbtn-cancel" onclick="closeModal()">Batal</button>
                <button class="modal-btn mbtn-del" id="delConfirm">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- ── Script ── --}}
    <script>
        let pendingForm = null;

        function openModal(btn) {
            const row = btn.closest('tr');
            pendingForm = row.querySelector('form.del-form');
            document.getElementById('delModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('delModal').classList.remove('show');
            pendingForm = null;
        }

        document.getElementById('delConfirm').onclick = function() {
            if (pendingForm) pendingForm.submit();
        };

        document.getElementById('delModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endsection
