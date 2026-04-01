@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --blue: #3d5af1;
            --amber: #f1a83d;
            --green: #00c9a7;
            --ink: #18192a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
        }

        .rp {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .label {
            font-size: 12px;
            color: var(--ink-3);
        }

        .value {
            font-weight: 600;
            margin-bottom: 14px;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .pending {
            background: #fff7e6;
            color: #b45309;
        }

        .selesai {
            background: #e0faf5;
            color: #00a88a;
        }

        .btn-back {
            padding: 10px 16px;
            border-radius: 10px;
            background: #eee;
            text-decoration: none;
            font-weight: 600;
            color: #333;
        }
    </style>

    <div class="rp">

        <div class="card">
            <div class="title">📋 Detail Report</div>

            <div class="label">Novel</div>
            <div class="value">{{ $report->novel->judul ?? '-' }}</div>

            @if ($report->chapter)
                <div class="label">Chapter</div>
                <div class="value">{{ $report->chapter->judul }}</div>
            @endif

            @if ($report->comment)
                <div class="label">Komentar yang dilaporkan</div>
                <div class="value" style="font-size:13px;">
                    "{{ $report->comment->isi }}"
                </div>
            @endif

            <div class="label">Alasan Report</div>
            <div class="value">
                {{ str_replace('_', ' ', $report->alasan) }}
            </div>

            <div class="label">Status</div>
            <div class="value">
                <span class="badge {{ $report->status == 'pending' ? 'pending' : 'selesai' }}">
                    {{ $report->status == 'pending' ? '⏳ Pending (menunggu admin)' : '✅ Sudah ditangani admin' }}
                </span>
            </div>

            <div class="label">Tanggal</div>
            <div class="value">
                {{ $report->created_at->format('d M Y H:i') }}
            </div>

        </div>

        <a href="{{ route('author.report.index') }}" class="btn-back">
            ⬅ Kembali
        </a>

    </div>
@endsection
