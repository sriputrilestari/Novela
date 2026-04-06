@extends('layouts.app')
@section('title', 'Novela – Riwayat')

@section('content')
    <div class="content-wrap">

        <div class="flex items-center justify-between mb-24">
            <div class="section-title" style="font-size:1.3rem">🕐 Riwayat Bacaan</div>
        </div>

        @if ($histories->isEmpty())
            <div class="empty-state">
                <div class="icon">📖</div>
                <p>Kamu belum membaca novel apapun.</p>
                <a href="{{ route('search') }}" class="btn-primary" style="display:inline-flex;margin-top:16px">Mulai
                    Membaca</a>
            </div>
        @else
            {{-- Group by tanggal --}}
            @php
                $grouped = $histories->groupBy(
                    fn($h) => $h->last_read_at?->isToday()
                        ? 'Hari Ini'
                        : ($h->last_read_at?->isYesterday()
                            ? 'Kemarin'
                            : $h->last_read_at?->format('d M Y')),
                );
            @endphp

            @foreach ($grouped as $label => $items)
                <div
                    style="color:var(--text-muted);font-size:.73rem;text-transform:uppercase;letter-spacing:1px;margin:16px 0 8px">
                    {{ $label }}
                </div>

                @foreach ($items as $history)
                    <div class="reading-item mb-8">
                        <div class="reading-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card))">
                            @if ($history->chapter->novel->cover)
                                <img src="{{ asset('storage/' . $history->chapter->novel->cover) }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover;border-radius:8px" />
                            @else
                                📖
                            @endif
                        </div>
                        <div class="reading-info">
                            <div class="reading-title">{{ $history->chapter->novel->judul }}</div>
                            <div class="reading-author">{{ $history->chapter->novel->author->name }}</div>
                            <div class="text-muted text-xs mt-4">
                                Chapter {{ $history->chapter->urutan }}: {{ $history->chapter->judul_chapter }}
                            </div>
                        </div>
                        <div class="reading-right">
                            <span class="text-xs text-muted">{{ $history->last_read_at?->diffForHumans() }}</span>
                            <a href="{{ route('chapter.show', $history->chapter->id) }}" class="btn-sm">Lanjutkan</a>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif

    </div>
@endsection
