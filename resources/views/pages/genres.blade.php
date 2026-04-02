@extends('layouts.main')
@section('title', 'Genre – Novela')
@section('content')
    <div class="content-wrap">
        <div class="section-title mb-8" style="font-size:1.3rem">📚 Semua Genre</div>
        <p class="text-muted text-sm mb-24">Temukan novel sesuai genre favoritmu</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px">
            @foreach ($genres as $genre)
                <a href="{{ route('search') }}?genre={{ urlencode($genre->nama_genre) }}" class="novel-card"
                    style="background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow);text-decoration:none;overflow:hidden;display:flex;flex-direction:column">

                    <div
                        style="background:linear-gradient(135deg,#1e2f9e,#3d5af1);padding:24px;text-align:center;font-size:2rem">
                        📚
                    </div>

                    <div style="padding:14px;text-align:center">
                        <div style="font-weight:700;color:var(--ink)">
                            {{ $genre->nama_genre }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
