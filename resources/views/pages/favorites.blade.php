@extends('layouts.app')
@section('title', 'Novela – Favorit')

@section('content')
    <div class="content-wrap">

        <div class="section-title mb-24" style="font-size:1.3rem">❤️ Koleksi Saya</div>

        @if ($bookmarks->isEmpty())
            <div class="empty-state">
                <div class="icon">❤️</div>
                <p>Kamu belum menambahkan novel ke favorit.</p>
                <a href="{{ route('search') }}" class="btn-primary" style="display:inline-flex;margin-top:16px">Temukan
                    Novel</a>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:12px">
                @foreach ($bookmarks as $bookmark)
                    <div class="reading-item">
                        <div class="reading-cover" style="background:linear-gradient(135deg,var(--bg-mid),var(--bg-card))">
                            @if ($bookmark->novel->cover)
                                <img src="{{ asset('storage/' . $bookmark->novel->cover) }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover;border-radius:8px" />
                            @else
                                📖
                            @endif
                        </div>
                        <div class="reading-info">
                            <div class="reading-title">{{ $bookmark->novel->judul }}</div>
                            <div class="reading-author">
                                {{ $bookmark->novel->author->name }} · {{ $bookmark->novel->genre->nama_genre }}
                            </div>
                            <div style="display:flex;gap:6px;margin-top:8px">
                                <span class="tag">{{ ucfirst($bookmark->novel->status) }}</span>
                                <span class="tag tag-gold">★ {{ number_format($bookmark->novel->rating, 1) }}</span>
                            </div>
                        </div>
                        <div class="reading-right" style="gap:8px">
                            <a href="{{ route('novel.show', $bookmark->novel->id) }}" class="btn-sm">Baca</a>
                            <form method="POST" action="{{ route('bookmark.toggle', $bookmark->novel->id) }}">
                                @csrf
                                <button type="submit" class="btn-sm"
                                    style="border-color:var(--red);color:var(--red)">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
