@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --blue: #3d5af1;
            --green: #00c9a7;
            --red: #f1523d;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
            --bg-soft: #f8f9fe;
        }

        .rp {
            font-family: 'Plus Jakarta Sans', sans-serif
        }

        /* card */
        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 28px;
            max-width: 800px;
            margin: auto;
        }

        /* title */
        .title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--ink);
        }

        /* grid */
        .grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 12px 20px;
            align-items: start;
        }

        /* label & value */
        .label {
            font-size: 12px;
            color: var(--ink-3);
            font-weight: 600;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        /* box highlight */
        .box {
            background: var(--bg-soft);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 14px;
            font-size: 13px;
            line-height: 1.6;
            color: var(--ink-2);
        }

        /* badge */
        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .pending {
            background: #fff7e6;
            color: #b45309;
        }

        .reviewed {
            background: #e0faf5;
            color: #00a88a;
        }

        .rejected {
            background: #fef0ee;
            color: #c43020;
        }

        /* divider */
        .divider {
            margin: 20px 0;
            border-top: 1px solid var(--line);
        }

        /* back button */
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            border-radius: 10px;
            background: #f4f6fc;
            text-decoration: none;
            font-weight: 600;
            color: #333;
            transition: .2s;
        }

        .btn-back:hover {
            background: #e8eaf3;
        }
    </style>

    <div class="rp">
        <div class="card">

            <div class="title">📋 Detail Report</div>

            <div class="grid">

                <div class="label">Novel</div>
                <div class="value">{{ $report->novel->judul ?? '-' }}</div>

                @if ($report->chapter)
                    <div class="label">Chapter</div>
                    <div class="value">{{ $report->chapter->judul_chapter }}</div>
                @endif

                <div class="label">Kategori</div>
                <div class="value">{{ $report->alasanLabel() }}</div>

                <div class="label">Status</div>
                <div class="value">
                    @if ($report->status == 'pending')
                        <span class="badge pending">⏳ Pending</span>
                    @elseif($report->status == 'reviewed')
                        <span class="badge reviewed">✅ Sudah direview</span>
                    @elseif($report->status == 'rejected')
                        <span class="badge rejected">❌ Ditolak</span>
                    @endif
                </div>

                <div class="label">Tanggal</div>
                <div class="value">
                    {{ $report->created_at->format('d M Y H:i') }}
                </div>

            </div>

            <div class="divider"></div>

            {{-- Alasan dari user --}}
            <div class="label">🗣 Alasan dari Pembaca</div>
            <div class="box">
                {{ $report->deskripsi ?? 'Tidak ada deskripsi' }}
            </div>

            {{-- Catatan admin --}}
            @if ($report->catatan_admin)
                <div style="margin-top:16px">
                    <div class="label">🛠 Catatan Admin</div>
                    <div class="box">
                        {{ $report->catatan_admin }}
                    </div>
                </div>
            @endif

            <a href="{{ route('author.report.index') }}" class="btn-back">
                ⬅ Kembali
            </a>

        </div>
    </div>
@endsection
