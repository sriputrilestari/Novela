@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --blue: #3d5af1;
            --blue-lt: #eef0fe;
            --blue-md: #dde2fc;
            --green: #00c9a7;
            --green-lt: #e0faf5;
            --amber: #f1a83d;
            --ink: #18192a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
        }

        .rp {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* header */
        .pg-head {
            display: flex;
            justify-content: space-between;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px 26px;
            margin-bottom: 20px;
        }

        .pg-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
        }

        .pg-sub {
            font-size: 12px;
            color: var(--ink-3);
        }

        /* table card */
        .tcard {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            overflow: hidden;
        }

        .tcard-head {
            padding: 14px 22px;
            border-bottom: 1px solid var(--line);
            background: #f8f9fe;
            display: flex;
            justify-content: space-between;
        }

        .tcard-title {
            font-weight: 700;
        }

        /* table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            background: #f8f9fe;
            padding: 10px 16px;
            font-size: 11px;
            color: var(--ink-3);
            border-bottom: 1px solid var(--line);
        }

        td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--line);
        }

        /* badge */
        .alasan-badge {
            background: #f4f6fb;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 3px 9px;
            font-size: 11px;
        }

        /* status */
        .pill {
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
        }

        .pill-pending {
            background: #fff7e6;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .pill-selesai {
            background: var(--green-lt);
            color: #00a88a;
            border: 1px solid #b0ede3;
        }

        /* button */
        .act-btn {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid var(--blue-md);
            background: var(--blue-lt);
            color: var(--blue);
        }

        /* empty */
        .empty-state {
            text-align: center;
            padding: 40px;
        }
    </style>

    <div class="rp">

        {{-- Header --}}
        <div class="pg-head">
            <div>
                <div class="pg-title">🚨 Laporan Masuk</div>
                <div class="pg-sub">Report dari pembaca</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="tcard">
            <div class="tcard-head">
                <div class="tcard-title">📋 Daftar Report</div>
                <span>{{ $reports->total() }} laporan</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Novel</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $i => $r)
                        <tr>
                            <td>{{ $reports->firstItem() + $i }}</td>

                            <td>
                                <strong>{{ $r->novel->judul ?? '-' }}</strong>
                                @if ($r->comment_id)
                                    <div style="font-size:11px;color:#999;">💬 Komentar</div>
                                @endif
                            </td>

                            <td>
                                <span class="alasan-badge">
                                    {{ str_replace('_', ' ', $r->alasan) }}
                                </span>
                            </td>

                            <td>
                                <span class="pill {{ $r->status == 'pending' ? 'pill-pending' : 'pill-selesai' }}">
                                    {{ $r->status == 'pending' ? '⏳ Pending' : '✅ Selesai' }}
                                </span>
                            </td>

                            <td>{{ $r->created_at->format('d M Y') }}</td>

                            <td>
                                <a href="{{ route('author.report.show', $r->id) }}" class="act-btn">
                                    👁
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    🎉 Tidak ada laporan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($reports->hasPages())
                <div style="padding:10px;">
                    {{ $reports->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection
