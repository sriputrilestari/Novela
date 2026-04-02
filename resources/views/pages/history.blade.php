{{-- resources/views/pages/history.blade.php --}}
@extends('layouts.main')
@section('title', 'Riwayat – Novela')
@section('content')
<div class="content-wrap">
  <div class="flex items-center justify-between mb-24">
    <div class="section-title" style="font-size:1.3rem">🕐 Riwayat Bacaan</div>
    <button class="btn-danger btn-sm" onclick="if(confirm('Hapus semua riwayat?'))showToast('success','Riwayat','Riwayat berhasil dihapus')">🗑 Hapus Semua</button>
  </div>

  @forelse($histories ?? [] as $h)
  <a href="{{ route('chapter.show', $h->chapter_id) }}" class="reading-item mb-10" style="text-decoration:none;display:flex">
    <div class="reading-cover" style="background:linear-gradient(135deg,#1a2a6c,#3d5af1)">📚</div>
    <div class="reading-info">
      <div class="reading-title">{{ $h->chapter->novel->judul ?? '-' }}</div>
      <div class="reading-author">{{ $h->chapter->novel->author->name ?? '-' }}</div>
      <div class="text-muted text-xs mt-4">Chapter {{ $h->chapter->urutan }}: {{ $h->chapter->judul_chapter }}</div>
      <div class="reading-progress-row mt-8">
        <div class="reading-progress-bar"><div class="reading-progress-fill" style="width:70%"></div></div>
        <span class="reading-progress-text">70%</span>
      </div>
    </div>
    <div class="reading-right">
      <span class="text-xs text-muted">{{ \Carbon\Carbon::parse($h->last_read_at)->diffForHumans() }}</span>
      <span class="btn-sm">Lanjutkan</span>
    </div>
  </a>
  @empty
  {{-- Demo data --}}
  <div style="color:var(--ink-3);font-size:.75rem;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Hari Ini</div>
  @foreach([
    ['title'=>'Moonlit Sorceress','author'=>'Bianca Giger','ch'=>'Chapter 218: Pertempuran Akhir','pct'=>68,'ago'=>'2j lalu','bg'=>'linear-gradient(135deg,#1a2a6c,#2d4a9c)','icon'=>'🌙'],
    ['title'=>'Shadow of the Dragon','author'=>'Kira Morales','ch'=>'Chapter 42: Api Naga Hitam','pct'=>35,'ago'=>'5j lalu','bg'=>'linear-gradient(135deg,#1a3a2c,#2d6c4a)','icon'=>'🐉'],
  ] as $item)
  <a href="{{ route('chapter.show', 1) }}" class="reading-item" style="text-decoration:none;margin-bottom:10px;display:flex">
    <div class="reading-cover" style="background:{{ $item['bg'] }}">{{ $item['icon'] }}</div>
    <div class="reading-info">
      <div class="reading-title">{{ $item['title'] }}</div>
      <div class="reading-author">{{ $item['author'] }}</div>
      <div class="text-muted text-xs mt-4">{{ $item['ch'] }}</div>
      <div class="reading-progress-row mt-8">
        <div class="reading-progress-bar"><div class="reading-progress-fill" style="width:{{ $item['pct'] }}%"></div></div>
        <span class="reading-progress-text">{{ $item['pct'] }}%</span>
      </div>
    </div>
    <div class="reading-right">
      <span class="text-xs text-muted">{{ $item['ago'] }}</span>
      <span class="btn-sm">Lanjutkan</span>
    </div>
  </a>
  @endforeach

  <div style="color:var(--ink-3);font-size:.75rem;text-transform:uppercase;letter-spacing:1px;margin:16px 0 8px">Kemarin</div>
  <a href="{{ route('chapter.show', 1) }}" class="reading-item" style="text-decoration:none;display:flex">
    <div class="reading-cover" style="background:linear-gradient(135deg,#3a1a1a,#8c2a2a)">🩸</div>
    <div class="reading-info">
      <div class="reading-title">Crimson Veil</div>
      <div class="reading-author">Sera Black</div>
      <div class="text-muted text-xs mt-4">Chapter 78: Bayangan di Cermin</div>
      <div class="reading-progress-row mt-8">
        <div class="reading-progress-bar"><div class="reading-progress-fill" style="width:85%"></div></div>
        <span class="reading-progress-text">85%</span>
      </div>
    </div>
    <div class="reading-right">
      <span class="text-xs text-muted">Kemarin</span>
      <span class="btn-sm">Lanjutkan</span>
    </div>
  </a>
  @endforelse
</div>
@endsection