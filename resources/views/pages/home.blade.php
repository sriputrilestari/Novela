@extends('layouts.main')

@section('title', 'Beranda – Novela')

@section('content')

{{-- Hero Banner --}}
<div class="hero-banner">
  <div class="hero-bg-img">📖</div>
  <div class="hero-content">
    <div class="hero-badge">✦ Novel Pilihan Minggu Ini</div>
    <div class="hero-title">Moonlit Sorceress</div>
    <div class="hero-author">oleh <strong>Bianca Giger</strong> &nbsp;·&nbsp; Fantasy · Romance</div>
    <div class="hero-desc">Ketika bulan purnama menyinari Tanah Larangan, seorang penyihir terakhir bangkit untuk menghadapi takdirnya yang paling kelam…</div>
    <div class="hero-meta">
      <span class="hero-stars">★★★★☆</span>
      <span style="opacity:.85;font-size:.85rem">4.2 (12.4K)</span>
      <span class="hero-tag">Fantasy</span>
      <span class="hero-tag" style="color:#fbbf24;background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.3)">Romance</span>
      <span style="opacity:.7;font-size:.82rem">320 Chapter</span>
    </div>
    <div class="hero-actions">
      <a href="{{ route('chapter.show', 1) }}" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        Mulai Baca
      </a>
      <a href="{{ route('novel.show', 1) }}" class="btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
        Detail Novel
      </a>
      <button class="btn-secondary" onclick="toggleFav(this)">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Favorit
      </button>
    </div>
  </div>
</div>

<div class="content-wrap">

  @auth
  {{-- Quick Stats --}}
  <div class="stats-strip">
    <div class="stat-card">
      <div class="stat-num">{{ $stats['novels_read'] ?? 48 }}</div>
      <div class="stat-lbl">Novel Dibaca</div>
    </div>
    <div class="stat-card">
      <div class="stat-num" style="color:var(--green)">{{ $stats['favorites'] ?? 12 }}</div>
      <div class="stat-lbl">Favorit</div>
    </div>
    <div class="stat-card">
      <div class="stat-num" style="color:var(--amber)">{{ $stats['chapters_done'] ?? 284 }}</div>
      <div class="stat-lbl">Chapter Selesai</div>
    </div>
    <div class="stat-card">
      <div class="stat-num" style="color:var(--purple)">{{ $stats['comments'] ?? 7 }}</div>
      <div class="stat-lbl">Komentar</div>
    </div>
  </div>

  {{-- Lanjutkan Membaca --}}
  @if(isset($readingHistory) && $readingHistory->count())
  <div class="section-header">
    <div class="section-title">Lanjutkan Membaca</div>
    <a href="{{ route('history') }}" class="see-all">Lihat Semua →</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px;margin-bottom:32px">
    @foreach($readingHistory->take(2) as $h)
    <a href="{{ route('chapter.show', $h->chapter_id) }}" class="reading-item" style="text-decoration:none">
      <div class="reading-cover" style="background:linear-gradient(135deg,#1e2f9e,#3d5af1)">📚</div>
      <div class="reading-info">
        <div class="reading-title">{{ $h->chapter->novel->judul ?? '-' }}</div>
        <div class="reading-author">{{ $h->chapter->novel->author->name ?? '-' }}</div>
        <div class="text-muted text-xs mt-4">Chapter {{ $h->chapter->urutan }}: {{ $h->chapter->judul_chapter }}</div>
        <div class="reading-actions"><span class="btn-sm">▶ Lanjutkan</span></div>
      </div>
      <div class="reading-right">
        <span class="text-xs text-muted">{{ \Carbon\Carbon::parse($h->last_read_at)->diffForHumans() }}</span>
      </div>
    </a>
    @endforeach
  </div>
  @else
  {{-- Dummy jika belum ada riwayat --}}
  <div class="section-header">
    <div class="section-title">Lanjutkan Membaca</div>
    <a href="{{ route('history') }}" class="see-all">Lihat Semua →</a>
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:12px;margin-bottom:32px">
    @foreach([
      ['title'=>'Moonlit Sorceress','author'=>'Bianca Giger','genre'=>'Fantasy','bg'=>'linear-gradient(135deg,#1a2a6c,#2d4a9c)','icon'=>'📚','ch'=>218,'total'=>320,'pct'=>68,'ago'=>'2j lalu'],
      ['title'=>'Shadow of the Dragon','author'=>'Kira Morales','genre'=>'Action','bg'=>'linear-gradient(135deg,#2d1a6c,#6c3da0)','icon'=>'🐉','ch'=>42,'total'=>120,'pct'=>35,'ago'=>'1h lalu'],
    ] as $item)
    <a href="{{ route('chapter.show', 1) }}" class="reading-item" style="text-decoration:none">
      <div class="reading-cover" style="background:{{ $item['bg'] }}">{{ $item['icon'] }}</div>
      <div class="reading-info">
        <div class="reading-title">{{ $item['title'] }}</div>
        <div class="reading-author">{{ $item['author'] }} · {{ $item['genre'] }}</div>
        <div class="reading-progress-row">
          <div class="reading-progress-bar"><div class="reading-progress-fill" style="width:{{ $item['pct'] }}%"></div></div>
          <span class="reading-progress-text">Ch.{{ $item['ch'] }} / {{ $item['total'] }}</span>
        </div>
        <div class="reading-actions"><span class="btn-sm">▶ Lanjutkan</span></div>
      </div>
      <div class="reading-right">
        <span class="text-xs text-muted">{{ $item['ago'] }}</span>
        <span class="badge badge-blue">{{ $item['pct'] }}%</span>
      </div>
    </a>
    @endforeach
  </div>
  @endif
  @endauth

  {{-- Genre Pills --}}
  <div class="section-header"><div class="section-title">Pilih Genre</div></div>
  <div class="genre-scroll">
    @foreach(['🌟 Semua','⚔️ Fantasy','💕 Romance','🔥 Action','😱 Horror','🕵️ Mystery','🚀 Sci-Fi','🏫 School Life','🧘 Slice of Life','🌸 Isekai','⚡ System'] as $genre)
    <div class="genre-pill {{ $loop->first ? 'active' : '' }}" onclick="toggleGenre(this)">{{ $genre }}</div>
    @endforeach
  </div>

  {{-- Novel Terbaru --}}
  <div class="section-header">
    <div class="section-title">Novel Terbaru</div>
    <a href="{{ route('search') }}" class="see-all">Lihat Semua →</a>
  </div>
  <div class="novel-grid mb-32">
    @forelse($latestNovels ?? [] as $novel)
    <a href="{{ route('novel.show', $novel->id) }}" class="novel-card" style="text-decoration:none">
      <div class="novel-cover" style="background:linear-gradient(135deg,#1e2f9e,#3d5af1)">
        @if($novel->cover)<img src="{{ asset('storage/'.$novel->cover) }}" alt="{{ $novel->judul }}"/>@else 📚@endif
        <div class="novel-cover-overlay"></div>
      </div>
      <div class="novel-info">
        <div class="novel-title">{{ $novel->judul }}</div>
        <div class="novel-author">{{ $novel->author->name }}</div>
        <div class="novel-genre">{{ $novel->genre->nama_genre }}</div>
        <div class="novel-stars">★★★★☆ <span>4.2</span></div>
      </div>
    </a>
    @empty
    @foreach([
      ['title'=>'Moonlit Sorceress','author'=>'Bianca Giger','genre'=>'Fantasy','bg'=>'linear-gradient(135deg,#1a2a6c,#2d4a9c)','icon'=>'🌙','rating'=>'4.2','stars'=>'★★★★☆'],
      ['title'=>'Shadow of the Dragon','author'=>'Kira Morales','genre'=>'Action','bg'=>'linear-gradient(135deg,#1a3a2c,#2d6c4a)','icon'=>'🐉','rating'=>'4.8','stars'=>'★★★★★'],
      ['title'=>'Enchanted Realms','author'=>'Nadia Storm','genre'=>'Romance','bg'=>'linear-gradient(135deg,#3a1a2a,#6c2d4a)','icon'=>'💎','rating'=>'4.0','stars'=>'★★★★☆'],
      ['title'=>'System Lord','author'=>'Zion Bright','genre'=>'Isekai','bg'=>'linear-gradient(135deg,#2a2a1a,#4a4a2d)','icon'=>'⚡','rating'=>'4.4','stars'=>'★★★★☆'],
      ['title'=>'Galactic Empire','author'=>'Leo Vance','genre'=>'Sci-Fi','bg'=>'linear-gradient(135deg,#1a2a3a,#2d4a6c)','icon'=>'🌌','rating'=>'3.9','stars'=>'★★★☆☆'],
      ['title'=>'Crimson Veil','author'=>'Sera Black','genre'=>'Horror','bg'=>'linear-gradient(135deg,#3a1a1a,#8c2a2a)','icon'=>'🩸','rating'=>'4.7','stars'=>'★★★★★'],
    ] as $novel)
    <a href="{{ route('novel.show', 1) }}" class="novel-card" style="text-decoration:none">
      <div class="novel-cover" style="background:{{ $novel['bg'] }}">{{ $novel['icon'] }}<div class="novel-cover-overlay"></div></div>
      <div class="novel-info">
        <div class="novel-title">{{ $novel['title'] }}</div>
        <div class="novel-author">{{ $novel['author'] }}</div>
        <div class="novel-genre">{{ $novel['genre'] }}</div>
        <div class="novel-stars">{{ $novel['stars'] }} <span>{{ $novel['rating'] }}</span></div>
      </div>
    </a>
    @endforeach
    @endforelse
  </div>

  {{-- Novel Populer --}}
  <div class="section-header">
    <div class="section-title">🔥 Novel Populer</div>
    <a href="{{ route('search') }}" class="see-all">Lihat Semua →</a>
  </div>
  <div class="novel-list mb-32">
    @foreach([
      ['rank'=>'1','rankBg'=>'background:linear-gradient(135deg,var(--amber),#e09030)','title'=>'Moonlit Sorceress','author'=>'Bianca Giger','ch'=>320,'day'=>'Senin','tags'=>[['label'=>'Fantasy'],['label'=>'Romance','class'=>'tag-purple'],['label'=>'★ Top','class'=>'tag-gold']],'views'=>'1.2M','bg'=>'linear-gradient(135deg,#1a2a6c,#2d4a9c)','icon'=>'🌙'],
      ['rank'=>'2','rankBg'=>'background:linear-gradient(135deg,#a0a0a0,#606060)','title'=>'Shadow of the Dragon','author'=>'Kira Morales','ch'=>120,'day'=>'Rabu','tags'=>[['label'=>'Action'],['label'=>'Adventure','class'=>'tag-purple']],'views'=>'892K','bg'=>'linear-gradient(135deg,#1a3a2c,#2d6c4a)','icon'=>'🐉'],
      ['rank'=>'3','rankBg'=>'background:linear-gradient(135deg,#c87941,#8b4a1e)','title'=>'Enchanted Realms','author'=>'Nadia Storm','ch'=>185,'day'=>'Jumat','tags'=>[['label'=>'Romance'],['label'=>'Fantasy']],'views'=>'756K','bg'=>'linear-gradient(135deg,#3a1a2a,#6c2d4a)','icon'=>'💎'],
    ] as $item)
    <div class="novel-list-item" onclick="window.location='{{ route('novel.show', 1) }}'">
      <div class="rank-badge" style="{{ $item['rankBg'] }}">{{ $item['rank'] }}</div>
      <div class="list-cover" style="background:{{ $item['bg'] }}">{{ $item['icon'] }}</div>
      <div class="list-info">
        <div class="list-title">{{ $item['title'] }}</div>
        <div class="list-meta">{{ $item['author'] }} · {{ $item['ch'] }} Chapter · Update tiap {{ $item['day'] }}</div>
        <div class="list-tags">
          @foreach($item['tags'] as $tag)
          <span class="tag {{ $tag['class'] ?? '' }}">{{ $tag['label'] }}</span>
          @endforeach
        </div>
      </div>
      <div class="list-right">
        <span class="text-muted text-sm">{{ $item['views'] }} views</span>
        <a href="{{ route('chapter.show', 1) }}" class="btn-sm" onclick="event.stopPropagation()">Baca</a>
      </div>
    </div>
    @endforeach
  </div>

</div>
@endsection