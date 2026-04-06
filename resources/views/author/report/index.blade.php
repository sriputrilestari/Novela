@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* Biar ga nabrak layout lain */
        .rp {
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 20px;
        }

        /* HEADER */
        .rp .pg-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #e8eaf3;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }

        .rp .pg-title {
            font-size: 20px;
            font-weight: 800;
        }

        .rp .pg-sub {
            font-size: 12px;
            color: #9698ae;
        }

        /* CARD */
        .rp .tcard {
            background: #fff;
            border: 1px solid #e8eaf3;
            border-radius: 16px;
            overflow: hidden;
        }

        .rp .tcard-head {
            padding: 14px 20px;
            border-bottom: 1px solid #e8eaf3;
            background: #f8f9fe;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .rp .tcard-title {
            font-weight: 700;
        }

        /* BADGE TOTAL */
        .rp .total-badge {
            background: #eef0fe;
            color: #3d5af1;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        /* TABLE */
        .rp table {
            width: 100%;
            border-collapse: collapse;
        }

        .rp thead th {
            background: #f8f9fe;
            padding: 12px 16px;
            font-size: 11px;
            color: #9698ae;
            text-align: left;
        }

        .rp td {
            padding: 14px 16px;
            border-top: 1px solid #eee;
        }

        .rp tr:hover {
            background: #fafbff;
        }

        /* NOVEL */
        .rp .novel-title {
            font-weight: 700;
        }

        .rp .comment-tag {
            font-size: 11px;
            color: #999;
        }

        /* BADGE */
        .rp .badge {
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
        }

        .rp .pending {
            background: #fff7e6;
            color: #b45309;
        }

        .rp .reviewed {
            background: #e0faf5;
            color: #00a88a;
        }

        .rp .rejected {
            background: #fef0ee;
            color: #c43020;
        }

        /* BUTTON */
        .rp .act-btn {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            text-decoration: none;
            background: #eef0fe;
            color: #3d5af1;
            font-weight: 700;
        }

        .rp .act-btn:hover {
            background: #3d5af1;
            color: #fff;
        }

        /* EMPTY */
        .rp .empty {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>

    <div class="rp">

        {{-- HEADER --}}
        <div class="pg-head">
            <div>
                <div class="pg-title">🚨 Laporan Masuk</div>
                <div class="pg-sub">Report dari pembaca novel kamu</div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="tcard">
            <div class="tcard-head">
                <div class="tcard-title">📋 Daftar Report</div>

                {{-- FIX BAGUS --}}
                <div class="total-badge">
                    {{ $reports->total() }} Laporan
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
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
                                <div class="novel-title">
                                    {{ optional($r->novel)->judul ?? '-' }}
                                </div>

                                @if ($r->comment_id)
                                    <div class="comment-tag">💬 Komentar dilaporkan</div>
                                @endif
                            </td>

                            <td>
                                <span class="badge">
                                    {{ $r->alasanLabel() }}
                                </span>
                            </td>

                            <td>
                                @if ($r->status == 'pending')
                                    <span class="badge pending">⏳ Pending</span>
                                @elseif($r->status == 'reviewed')
                                    <span class="badge reviewed">✅ Direview</span>
                                @elseif($r->status == 'rejected')
                                    <span class="badge rejected">❌ Ditolak</span>
                                @endif
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
                                <div class="empty">
                                    🎉 Tidak ada laporan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($reports->hasPages())
                <div style="padding:12px;">
                    {{ $reports->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection
