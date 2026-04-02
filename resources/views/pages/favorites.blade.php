@extends('layouts.main')
@section('title', 'Favorit – Novela')
@section('content')
<div class="content-wrap">
  <div class="section-title mb-24" style="font-size:1.3rem">❤️ Koleksi Saya</div>
  <div class="fav-tabs">
    <button class="fav-tab active" onclick="switchFavTab(this,'fav-novels')">❤️ Novel Favorit</button>
    <button class="fav-tab" onclick="switchFavTab(this,'fav-chapters')">🔖 Bookmark Chapter</button>
  </div>

  <div id="fav-novels">
    @forelse($bookmarks ?? [] as $bookmark)
    <div class="reading-item mb-10" style="display:flex">
      <div class="reading-cover" style="background:linear-gradient(135deg,#1a2a6c,#3d5af1)">📚</div>
      <div class="reading-info">
        <div class="reading-title">{{ $bookmark->novel->judul }}</div>
        <div class="reading-author">{{ $bookmark->novel->author->name }} · {{ $bookmark->novel->genre->nama_genre }}</div>
        <div class="flex gap-6 mt-8">
          <span class="badge badge-blue">{{ $bookmark->novel->chapters_count ?? '-' }} Ch</span>
          <span class="badge badge-amber">★ 4.2</span>
          <span class="badge {{ $bookmark->novel->status === 'completed' ? 'badge-green' : 'badge-amber' }}">{{ $bookmark->novel->status === 'completed' ? 'TAMAT' : 'ONGOING' }}</span>
        </div>
      </div>
      <div class="reading-right">
        <a href="{{ route('chapter.show', 1) }}" class="btn-sm">Lanjutkan</a>
        <form action="{{ route('bookmark.toggle', $bookmark->novel_id) }}" method="POST">
          @csrf
          <button type="submit" class="btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-lt)">Hapus</button>
        </form>
      </div>
    </div>
    @empty
    @foreach([
      ['title'=>'Moonlit Sorceress','author'=>'Bianca Giger · Fantasy · Romance','bg'=>'linear-gradient(135deg,#1a2a6c,#2d4a9c)','icon'=>'🌙','ch'=>320,'rating'=>'4.2','status'=>'TAMAT','statusBadge'=>'badge-green'],
      ['title'=>'Crimson Veil','author'=>'Sera Black · Horror','bg'=>'linear-gradient(135deg,#3a1a1a,#8c2a2a)','icon'=>'🩸','ch'=>92,'rating'=>'4.7','status'=>'ONGOING','statusBadge'=>'badge-amber'],
      ['title'=>'System Lord','author'=>'Zion Bright · Isekai','bg'=>'linear-gradient(135deg,#2a2a1a,#4a4a2d)','icon'=>'⚡','ch'=>156,'rating'=>'4.4','status'=>'ONGOING','statusBadge'=>'badge-amber'],
    ] as $fav)
    <div class="reading-item mb-10" style="display:flex">
      <div class="reading-cover" style="background:{{ $fav['bg'] }}">{{ $fav['icon'] }}</div>
      <div class="reading-info">
        <div class="reading-title">{{ $fav['title'] }}</div>
        <div class="reading-author">{{ $fav['author'] }}</div>
        <div class="flex gap-6 mt-8">
          <span class="badge badge-blue">{{ $fav['ch'] }} Ch</span>
          <span class="badge badge-amber">★ {{ $fav['rating'] }}</span>
          <span class="badge {{ $fav['statusBadge'] }}">{{ $fav['status'] }}</span>
        </div>
      </div>
      <div class="reading-right">
        <a href="{{ route('chapter.show', 1) }}" class="btn-sm">Lanjutkan</a>
        <button class="btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-lt)" onclick="showToast('info','Favorit','Novel dihapus dari favorit')">Hapus</button>
      </div>
    </div>
    @endforeach
    @endforelse
  </div>

  <div id="fav-chapters" style="display:none">
    <div class="chapter-list">
      @foreach([
        ['num'=>218,'title'=>'Moonlit Sorceress · Ch.218: Pertempuran Akhir','time'=>'2 jam lalu'],
        ['num'=>42,'title'=>'Shadow of the Dragon · Ch.42: Api Naga Hitam','time'=>'kemarin'],
      ] as $bm)
      <a href="{{ route('chapter.show', 1) }}" class="chapter-item" style="text-decoration:none">
        <div class="chapter-num">{{ $bm['num'] }}</div>
        <div class="chapter-info">
          <div class="chapter-title-text">{{ $bm['title'] }}</div>
          <div class="chapter-meta">Ditandai {{ $bm['time'] }}</div>
        </div>
        <button class="btn-sm" style="border-color:var(--red);color:var(--red);background:var(--red-lt)" onclick="event.preventDefault();showToast('info','Bookmark','Bookmark dihapus')">Hapus</button>
      </a>
      @endforeach
    </div>
  </div>
</div>
@endsection