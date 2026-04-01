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

        * {
            box-sizing: border-box;
        }

        .nv {
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        /* stats */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
            animation: up .4s .05s ease both;
        }

        @media(max-width:768px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
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

        .si-amber {
            background: var(--amber-lt);
        }

        .si-green {
            background: var(--green-lt);
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

        /* filter bar */
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
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tcard-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .filter-select {
            appearance: none;
            border: 1.5px solid var(--line);
            background: #fff;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-2);
            cursor: pointer;
            transition: .2s;
            font-family: inherit;
            outline: none;
        }

        .filter-select:hover {
            border-color: var(--blue);
        }

        .filter-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .filter-reset {
            border: none;
            background: var(--blue-lt);
            color: var(--blue);
            font-weight: 700;
            font-size: 12px;
            padding: 7px 14px;
            border-radius: 999px;
            cursor: pointer;
            transition: .2s;
            font-family: inherit;
            text-decoration: none;
        }

        .filter-reset:hover {
            background: var(--blue);
            color: #fff;
        }

        /* table */
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

        /* novel cell */
        .novel-cover {
            width: 38px;
            height: 52px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .novel-cover-placeholder {
            width: 38px;
            height: 52px;
            border-radius: 6px;
            background: #f4f6fb;
            border: 1.5px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .novel-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--ink);
        }

        .novel-meta {
            font-size: 11.5px;
            color: var(--ink-3);
            margin-top: 3px;
        }

        /* pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 999px;
            padding: 4px 11px;
            font-size: 11.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .pill-ongoing {
            background: var(--blue-lt);
            color: var(--blue);
            border: 1px solid var(--blue-md);
        }

        .pill-completed {
            background: var(--green-lt);
            color: #00a88a;
            border: 1px solid #b0ede3;
        }

        .pill-pending {
            background: var(--amber-lt);
            color: #c48020;
            border: 1px solid #fde5b0;
        }

        .pill-published {
            background: var(--green-lt);
            color: #00a88a;
            border: 1px solid #b0ede3;
        }

        .pill-rejected {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid #fcd0ca;
        }

        /* action buttons */
        .acts {
            display: flex;
            align-items: center;
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

        .btn-chapter {
            background: var(--blue-lt);
            color: var(--blue);
            border-color: var(--blue-md);
        }

        .btn-chapter:hover {
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

        .btn-del {
            background: var(--red-lt);
            color: var(--red);
            border-color: #fcd0ca;
        }

        .btn-del:hover {
            background: #fcd0ca;
            color: var(--red);
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
    </style>

    <div class="nv">

        {{-- Header --}}
        <div class="pg-head">
            <div>
                <div class="pg-title">📚 Novel Saya</div>
                <div class="pg-sub">Kelola novel kamu dengan mudah</div>
            </div>
            <a href="{{ route('author.novel.create') }}" class="btn-add">+ Tambah Novel</a>
        </div>

        {{-- Stats --}}
        @php
            $total = $novels->count();
            $published = $novels->where('approval_status', 'published')->count();
            $pending = $novels->where('approval_status', 'pending')->count();
            $rejected = $novels->where('approval_status', 'rejected')->count();
        @endphp
        <div class="stats">
            <div class="stat-card">
                <div class="stat-ico si-blue">📚</div>
                <div>
                    <div class="stat-lbl">Total</div>
                    <div class="stat-num">{{ $total }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-ico si-amber">⏳</div>
                <div>
                    <div class="stat-lbl">Pending</div>
                    <div class="stat-num">{{ $pending }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-ico si-green">✅</div>
                <div>
                    <div class="stat-lbl">Published</div>
                    <div class="stat-num">{{ $published }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-ico si-red">❌</div>
                <div>
                    <div class="stat-lbl">Rejected</div>
                    <div class="stat-num">{{ $rejected }}</div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="tcard">
            <div class="tcard-head">
                <div class="tcard-title">📋 Daftar Novel</div>
                <form method="GET" class="filter-bar">
                    <select name="status" class="filter-select" onchange="this.form.submit()">
                        <option value="">Status Cerita</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <select name="approval" class="filter-select" onchange="this.form.submit()">
                        <option value="">Approval</option>
                        <option value="pending" {{ request('approval') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ request('approval') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="rejected" {{ request('approval') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <select name="genre" class="filter-select" onchange="this.form.submit()">
                        <option value="">Genre</option>
                        @foreach ($genres as $g)
                            <option value="{{ $g->id }}" {{ request('genre') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama_genre }}</option>
                        @endforeach
                    </select>
                    @if (request('status') || request('approval') || request('genre'))
                        <a href="{{ route('author.novel.index') }}" class="filter-reset">✕ Reset</a>
                    @endif
                </form>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th width="40">No</th>
                            <th>Judul</th>
                            <th width="120">Genre</th>
                            <th width="110">Status</th>
                            <th width="110">Approval</th>
                            <th width="200" style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($novels as $novel)
                            <tr>
                                <td style="color:var(--ink-3);font-weight:600;">{{ $loop->iteration }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        @if ($novel->cover)
                                            <img src="{{ asset('storage/' . $novel->cover) }}" class="novel-cover">
                                        @else
                                            <div class="novel-cover-placeholder">📖</div>
                                        @endif
                                        <div>
                                            <div class="novel-title">{{ $novel->judul }}</div>
                                            <div class="novel-meta">
                                                👁 {{ $novel->views ?? 0 }}
                                                &nbsp;·&nbsp;
                                                🔖 {{ $novel->bookmarks_count ?? 0 }}
                                                &nbsp;·&nbsp;
                                                📖 {{ $novel->chapters_count ?? 0 }} chapter
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--ink-2);font-weight:600;">
                                    {{ $novel->genre->nama_genre ?? '-' }}</td>
                                <td><span class="pill pill-{{ $novel->status }}">{{ ucfirst($novel->status) }}</span></td>
                                <td>
                                    @php $ap = $novel->approval_status; @endphp
                                    <span class="pill pill-{{ $ap }}">
                                        @if ($ap === 'pending')
                                            ⏳
                                        @elseif($ap === 'published')
                                            ✅
                                        @else
                                            ❌
                                        @endif
                                        {{ ucfirst($ap) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="acts" style="justify-content:center;">
                                        <a href="{{ route('author.chapter.index', $novel->id) }}"
                                            class="act-btn btn-chapter">📖 Chapter</a>
                                        <a href="{{ route('author.novel.edit', $novel->id) }}" class="act-btn btn-edit">✏️
                                            Edit</a>
                                        <form id="del-{{ $novel->id }}"
                                            action="{{ route('author.novel.destroy', $novel->id) }}" method="POST"
                                            style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="act-btn btn-del"
                                                onclick="if(confirm('Hapus novel ini?')) document.getElementById('del-{{ $novel->id }}').submit()">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-ico">📭</div>
                                        <div class="empty-txt">Belum ada novel</div>
                                        <div class="empty-sub">Klik "+ Tambah Novel" untuk mulai menulis</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
