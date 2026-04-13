<nav class="topbar">
 <a class="topbar-logo" href="{{ route('home') }}" style="color: #18192a; font-family: 'DM Serif Display', serif; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 6px;">
    <span class="logo-star" style="color: #3d5af1;">✦</span> Novela
  </a>

  <div class="topbar-nav">
    <a href="{{ route('home') }}" class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-4 0H7m5 0h2"/></svg>
      Beranda
    </a>
    <a href="{{ route('search') }}" class="nav-btn {{ request()->routeIs('search') ? 'active' : '' }}">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      Jelajahi
    </a>
    <!-- <a href="{{ route('genres') }}" class="nav-btn {{ request()->routeIs('genres') ? 'active' : '' }}">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
      Genre
    </a> -->
    <a href="{{ route('favorites') }}" class="nav-btn {{ request()->routeIs('favorites') ? 'active' : '' }}">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      Favorit
    </a>
    <a href="{{ route('history') }}" class="nav-btn {{ request()->routeIs('history') ? 'active' : '' }}">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Riwayat
    </a>
  </div>

  <div class="topbar-right">
    <div class="search-wrap">
      <svg class="search-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <form action="{{ route('search') }}" method="GET">
        <input class="search-input" name="q" placeholder="Cari novel..." value="{{ request('q') }}"/>
      </form>
    </div>
    <button class="icon-btn" title="Notifikasi" onclick="showToast('info','Notifikasi','Tidak ada notifikasi baru')">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
      <span class="badge">3</span>
    </button>
  </div>
</nav>
