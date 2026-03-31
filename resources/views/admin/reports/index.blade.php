@extends('layouts.admin')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
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
            --purple-lt: #f5f0fe;
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

        @keyframes bar {
            from {
                width: 100%
            }

            to {
                width: 0%
            }
        }

        .a1 {
            animation: up .5s .00s ease both
        }

        .a2 {
            animation: up .5s .07s ease both
        }

        .a3 {
            animation: up .5s .13s ease both
        }

        .a4 {
            animation: up .5s .19s ease both
        }

        /* NOTIFICATION */
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

        /* BANNER */
        .banner {
            background: linear-gradient(130deg, var(--red) 0%, #d4422e 50%, #b83320 100%);
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

        /* STATS */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        @media(max-width:900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr)
            }
        }

        @media(max-width:480px) {
            .stats {
                grid-template-columns: 1fr
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

        .pill-amber {
            background: var(--amber-lt);
            color: #b07010;
        }

        .pill-green {
            background: var(--green-lt);
            color: #00a88a;
        }

        .pill-red {
            background: var(--red-lt);
            color: #c43020;
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

        /* BOX */
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

        /* FILTER TABS */
        .filter-tabs {
            display: flex;
            gap: 6px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--line);
            flex-wrap: wrap;
        }

        .ftab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 99px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--line);
            background: var(--bg);
            color: var(--ink-3);
            transition: .2s;
            text-decoration: none;
        }

        .ftab:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
        }

        .ftab.active {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
        }

        .ftab-count {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .2);
        }

        .ftab:not(.active) .ftab-count {
            background: var(--line);
            color: var(--ink-3);
        }

        /* TABLE */
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
            padding: 14px 20px;
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

        /* TAG STATUS */
        .tag {
            border-radius: 99px;
            padding: 4px 11px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .tag-pending {
            background: var(--amber-lt);
            color: #b07010;
            border: 1px solid rgba(241, 168, 61, .2);
        }

        .tag-reviewed {
            background: var(--green-lt);
            color: #00a08a;
            border: 1px solid rgba(0, 201, 167, .2);
        }

        .tag-rejected {
            background: var(--red-lt);
            color: #c43020;
            border: 1px solid rgba(241, 82, 61, .2);
        }

        /* USER CHIP */
        .user-chip {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .uc-av {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
            color: #fff;
        }

        .uc-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
        }

        .uc-sub {
            font-size: 11px;
            color: var(--ink-3);
        }

        /* ALASAN CHIP */
        .reason-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f4f6fc;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 500;
            color: var(--ink-2);
        }

        /* ACTION GROUP */
        .action-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-action {
            height: 30px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            transition: .15s;
            text-decoration: none;
            padding: 0 10px;
            gap: 4px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            white-space: nowrap;
        }

        .btn-action:hover {
            filter: brightness(.88);
            transform: translateY(-1px);
        }

        .btn-action.detail {
            background: var(--blue-lt);
            color: var(--blue);
        }

        .btn-action.warn {
            background: var(--amber-lt);
            color: #b07010;
        }

        .btn-action.reject-btn {
            background: var(--red-lt);
            color: var(--red);
        }

        .btn-action.delete-btn {
            background: #f0e8ff;
            color: #8b2cf5;
        }

        .btn-action.review-btn {
            background: var(--green-lt);
            color: #00a08a;
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(24, 25, 42, .45);
            z-index: 8000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: .25s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: var(--white);
            border-radius: 20px;
            padding: 28px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(24, 25, 42, .18);
            transform: translateY(20px) scale(.97);
            transition: .3s cubic-bezier(.16, 1, .3, 1);
        }

        .modal-overlay.open .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .modal-sub {
            font-size: 13px;
            color: var(--ink-3);
            margin-bottom: 20px;
        }

        .modal-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--ink-2);
            text-transform: uppercase;
            letter-spacing: .6px;
            display: block;
            margin-bottom: 8px;
        }

        .modal-textarea {
            width: 100%;
            background: #f7f8fc;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            color: var(--ink);
            outline: none;
            resize: vertical;
            min-height: 90px;
            transition: .2s;
        }

        .modal-textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-modal-cancel {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: #f4f6fc;
            color: var(--ink-2);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
        }

        .btn-modal-cancel:hover {
            background: var(--line);
        }

        .btn-modal-submit {
            padding: 10px 22px;
            border-radius: 10px;
            border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
            color: #fff;
        }

        .btn-modal-submit:hover {
            transform: translateY(-1px);
        }

        tr.pending td {
            background: #fff8e6 !important;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 56px 24px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 14px;
        }

        .empty-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--ink-3);
        }

        /* PAGINATION */
        .page-wrap {
            padding: 16px 22px;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-info {
            font-size: 12.5px;
            color: var(--ink-3);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    {{-- NOTIFICATION --}}
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
        });
    </script>

    {{-- MODAL PERINGATAN --}}
    <div class="modal-overlay" id="modalWarn">
        <div class="modal-box">
            <div class="modal-title">⚠️ Kirim Peringatan ke Author</div>
            <div class="modal-sub">Tuliskan pesan peringatan yang akan dicatat untuk laporan ini.</div>
            <form method="POST" id="warnForm">
                @csrf
                <label class="modal-label">Catatan Peringatan</label>
                <textarea name="catatan_admin" class="modal-textarea"
                    placeholder="Contoh: Konten melanggar pedoman komunitas. Harap perbaiki dalam 3 hari." required></textarea>
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('modalWarn')">Batal</button>
                    <button type="submit" class="btn-modal-submit" style="background:var(--amber);">⚠️ Kirim
                        Peringatan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TOLAK --}}
    <div class="modal-overlay" id="modalReject">
        <div class="modal-box">
            <div class="modal-title">✕ Tolak Laporan</div>
            <div class="modal-sub">Laporan akan ditolak. Tambahkan catatan alasan penolakan (opsional).</div>
            <form method="POST" id="rejectForm">
                @csrf
                <label class="modal-label">Catatan (opsional)</label>
                <textarea name="catatan_admin" class="modal-textarea"
                    placeholder="Contoh: Laporan tidak cukup bukti atau tidak melanggar aturan."></textarea>
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeModal('modalReject')">Batal</button>
                    <button type="submit" class="btn-modal-submit" style="background:var(--red);">✕ Tolak Laporan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL HAPUS NOVEL --}}
    <div class="modal-overlay" id="modalDelete">
        <div class="modal-box">
            <div class="modal-title">🗑️ Hapus Novel</div>
            <div class="modal-sub" id="deleteNovelName">Novel ini akan dihapus permanen dan semua laporan terkait akan
                ditutup otomatis.</div>
            <div
                style="background:var(--red-lt);border:1px solid rgba(241,82,61,.2);border-radius:12px;padding:14px 16px;margin-bottom:4px;">
                <div style="font-size:13px;color:#c43020;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">⚠
                    Tindakan ini tidak dapat dibatalkan!</div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalDelete')">Batal</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modal-submit" style="background:#8b2cf5;">🗑️ Hapus Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <div class="dash">

        {{-- BANNER --}}
        <div class="banner a1">
            <div>
                <div class="bn-date" id="bnDate"></div>
                <div class="bn-name">Laporan Novel 🚩</div>
                <div class="bn-sub">Tinjau dan tindak lanjuti laporan dari pengguna.</div>
            </div>
        </div>

        {{-- STATS (SIMPLE) --}}
        <div class="stats a2">
            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:#f4f6fc">🚩</div>
                    <span class="scard-pill pill-gray">Total</span>
                </div>
                <div>
                    <div class="scard-num">{{ $stats['total'] }}</div>
                    <div class="scard-lbl">Total Laporan</div>
                </div>
            </div>

            <div class="scard">
                <div class="scard-top">
                    <div class="scard-ico" style="background:var(--amber-lt)">⏳</div>
                    <span class="scard-pill pill-amber">Pending</span>
                </div>
                <div>
                    <div class="scard-num">{{ $stats['pending'] }}</div>
                    <div class="scard-lbl">Butuh Tindakan</div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="box a3">
            <div class="box-head">
                <div>
                    <div class="box-title">📋 Daftar Laporan</div>
                    <div class="box-sub">{{ $stats['pending'] }} laporan menunggu tindakan</div>
                </div>
                @if ($stats['pending'] > 0)
                    <span
                        style="background:var(--amber-lt);color:#b07010;border:1px solid rgba(241,168,61,.2);font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;">
                        {{ $stats['pending'] }} pending
                    </span>
                @endif
            </div>

            {{-- FILTER TABS --}}
            <div class="filter-tabs">
                <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}"
                    class="ftab {{ !request('status') ? 'active' : '' }}">
                    Semua <span class="ftab-count">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                    class="ftab {{ request('status') === 'pending' ? 'active' : '' }}">
                    ⏳ Pending <span class="ftab-count">{{ $stats['pending'] }}</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'reviewed']) }}"
                    class="ftab {{ request('status') === 'reviewed' ? 'active' : '' }}">
                    ✅ Reviewed <span class="ftab-count">{{ $stats['reviewed'] }}</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}"
                    class="ftab {{ request('status') === 'rejected' ? 'active' : '' }}">
                    ✕ Ditolak <span class="ftab-count">{{ $stats['rejected'] }}</span>
                </a>
            </div>

            <table class="tbl">
                <thead>
                    <tr>
                        <th>Pelapor</th>
                        <th>Novel</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr class="{{ $report->status == 'pending' ? 'pending' : '' }}">

                            {{-- PELAPOR --}}
                            <td>
                                <div class="user-chip">
                                    <div class="uc-av" style="background:var(--blue);">
                                        {{ strtoupper(substr($report->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="uc-name">{{ $report->user->name }}</div>
                                        <div class="uc-sub">{{ $report->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- NOVEL --}}
                            <td>
                                <div style="font-weight:600;">
                                    {{ Str::limit($report->novel->judul, 30) }}
                                </div>
                                <div style="font-size:11px;color:var(--ink-3);">
                                    by {{ $report->novel->author->name ?? '-' }}
                                </div>
                            </td>

                            {{-- ALASAN --}}
                            <td>
                                <span class="reason-chip">{{ $report->alasan }}</span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="tag tag-{{ $report->status }}">
                                    {{ $report->status }}
                                </span>
                            </td>

                            {{-- TANGGAL --}}
                            <td style="font-size:12px;color:var(--ink-3);">
                                {{ $report->created_at->format('d M Y') }}
                            </td>

                            {{-- AKSI (SIMPLE) --}}
                            <td>
                                <div class="action-group">

                                    {{-- Detail --}}
                                    <a href="{{ route('admin.reports.show', $report->id) }}"
                                        class="btn-action detail">Detail</a>

                                    @if ($report->status == 'pending')
                                        {{-- Warning --}}
                                        <button class="btn-action warn"
                                            onclick="openWarn('{{ route('admin.reports.warn', $report->id) }}')">
                                            Warning
                                        </button>

                                        {{-- Tolak --}}
                                        <button class="btn-action reject-btn"
                                            onclick="openReject('{{ route('admin.reports.reject', $report->id) }}')">
                                            Tolak
                                        </button>

                                        {{-- Hapus --}}
                                        <button class="btn-action delete-btn"
                                            onclick="openDelete('{{ route('admin.reports.deleteNovel', $report->id) }}', '{{ addslashes($report->novel->judul) }}')">
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">🎉</div>
                                    <div class="empty-title">Tidak ada laporan</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}
            @if ($reports->hasPages())
                <div class="page-wrap">
                    <div class="page-info">
                        Menampilkan {{ $reports->firstItem() }}–{{ $reports->lastItem() }} dari {{ $reports->total() }}
                        laporan
                    </div>
                    {{ $reports->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>

    <script>
        document.getElementById('bnDate').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        setTimeout(() => {
            document.querySelectorAll('.scard-fill[data-p]').forEach(b => {
                b.style.width = b.dataset.p + '%';
            });
        }, 250);

        // Modal helpers
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        function openWarn(url) {
            document.getElementById('warnForm').action = url;
            document.getElementById('warnForm').querySelector('textarea').value = '';
            openModal('modalWarn');
        }

        function openReject(url) {
            document.getElementById('rejectForm').action = url;
            document.getElementById('rejectForm').querySelector('textarea').value = '';
            openModal('modalReject');
        }

        function openDelete(url, title) {
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteNovelName').textContent =
                `Novel "${title}" akan dihapus permanen dan semua laporan terkait akan ditutup otomatis.`;
            openModal('modalDelete');
        }

        // Tutup modal klik di luar
        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) el.classList.remove('open');
            });
        });

        // Confirm helper (reuse dari template dashboard)
        function confirmAction(msg, cb) {
            if (confirm(msg)) cb();
        }
    </script>
@endsection
