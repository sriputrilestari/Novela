@extends('layouts.main')
@section('title', 'Profil – Novela')
@section('content')

@php $user = auth()->user(); @endphp

<div class="profile-header">
  <div class="profile-avatar-wrap">
    <div class="profile-avatar">
      @if($user->photo)
        <img src="{{ asset('storage/'.$user->photo) }}" alt="{{ $user->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:999px"/>
      @else
        {{ strtoupper(substr($user->name,0,1)) }}
      @endif
    </div>
    <button class="avatar-change-btn" onclick="document.getElementById('avatar-input').click()">✏</button>
    <input type="file" id="avatar-input" accept="image/*" style="display:none" onchange="showToast('info','Avatar','Fitur ganti avatar segera hadir!')"/>
  </div>
  <div class="profile-name">{{ $user->name }}</div>
  <div class="profile-email">{{ $user->email }}</div>
  <div class="profile-badges">
    <span class="profile-badge">📖 {{ ucfirst($user->role) }}</span>
    <span class="profile-badge" style="color:#fbbf24;background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.3)">⭐ Pembaca Aktif</span>
    @if($user->email_verified_at)
    <span class="profile-badge" style="color:#34d399;background:rgba(52,211,153,.1);border-color:rgba(52,211,153,.25)">✓ Terverifikasi</span>
    @endif
  </div>
</div>

<div class="profile-stats">
  <div class="profile-stat">
    <div class="profile-stat-num">{{ $stats['novels_read'] ?? 48 }}</div>
    <div class="profile-stat-lbl">Novel Dibaca</div>
  </div>
  <div class="profile-stat">
    <div class="profile-stat-num" style="color:var(--green)">{{ $stats['chapters_done'] ?? 284 }}</div>
    <div class="profile-stat-lbl">Chapter Selesai</div>
  </div>
  <div class="profile-stat">
    <div class="profile-stat-num" style="color:var(--amber)">{{ $stats['favorites'] ?? 12 }}</div>
    <div class="profile-stat-lbl">Favorit</div>
  </div>
</div>

<div class="profile-section">

  @if(session('success'))
  <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert alert-error">⚠️ {{ session('error') }}</div>
  @endif

  {{-- DATA DIRI --}}
  <div class="profile-card">
    <div class="profile-card-header">👤 Data Diri</div>
    <div class="profile-card-body">
      <form action="{{ route('reader.profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input class="form-input" name="name" value="{{ old('name', $user->name) }}" required/>
          @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}" required/>
          @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Bio</label>
          <textarea class="form-textarea" name="bio" style="min-height:80px">{{ old('bio', $user->bio) }}</textarea>
        </div>
        <div style="display:flex;justify-content:flex-end">
          <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  {{-- PASSWORD --}}
  <div class="profile-card">
    <div class="profile-card-header">🔒 Keamanan Akun</div>
    <div class="profile-card-body">
      <form action="{{ route('reader.profile.password') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Password Lama</label>
          <input class="form-input" type="password" name="current_password" placeholder="••••••••" required/>
          @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Password Baru</label>
          <input class="form-input" type="password" name="password" placeholder="Min. 8 karakter" required/>
          @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Password Baru</label>
          <input class="form-input" type="password" name="password_confirmation" placeholder="Ulangi password baru" required/>
        </div>
        <div style="display:flex;justify-content:flex-end">
          <button type="submit" class="btn-primary">🔑 Ubah Password</button>
        </div>
      </form>
    </div>
  </div>

  {{-- STATISTIK --}}
  <div class="profile-card">
    <div class="profile-card-header">📊 Statistik Bacaan</div>
    <div class="profile-card-body">
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:20px">
        @foreach([
          ['num'=>$stats['chapters_done']??284,'label'=>'Chapter Dibaca','color'=>'var(--blue)'],
          ['num'=>$stats['novels_read']??48,'label'=>'Novel Disentuh','color'=>'var(--green)'],
          ['num'=>$stats['favorites']??12,'label'=>'Novel Favorit','color'=>'var(--amber)'],
          ['num'=>$stats['comments']??7,'label'=>'Komentar Dibuat','color'=>'var(--purple)'],
        ] as $stat)
        <div style="background:var(--bg);border-radius:12px;padding:16px;text-align:center;border:1px solid var(--line)">
          <div style="font-size:1.6rem;font-family:'Lora',serif;font-weight:800;color:{{ $stat['color'] }}">{{ $stat['num'] }}</div>
          <div class="text-muted text-xs mt-4">{{ $stat['label'] }}</div>
        </div>
        @endforeach
      </div>
      <div>
        <div class="text-sm text-soft mb-8">Genre Favorit</div>
        <div class="genre-scroll" style="margin-bottom:0">
          <div class="genre-pill active" style="cursor:default">⚔️ Fantasy 42%</div>
          <div class="genre-pill active" style="cursor:default">💕 Romance 28%</div>
          <div class="genre-pill active" style="cursor:default;opacity:.75">😱 Horror 18%</div>
          <div class="genre-pill active" style="cursor:default;opacity:.55">🔥 Action 12%</div>
        </div>
      </div>
    </div>
  </div>

  {{-- JADI PENULIS --}}
  @if($user->role === 'reader')
  <div style="background:linear-gradient(135deg,#1e2f9e,#3d5af1);border-radius:var(--radius);padding:24px;color:white">
    <div class="flex items-center gap-12 mb-12">
      <span style="font-size:2rem">✍️</span>
      <div>
        <div style="font-family:'Lora',serif;font-size:1.1rem;font-weight:700">Ingin Jadi Penulis?</div>
        <div style="opacity:.8;font-size:.85rem;margin-top:4px">Bagikan ceritamu kepada jutaan pembaca</div>
      </div>
    </div>
    <a href="{{ route('reader.author-request') }}" style="display:inline-flex;align-items:center;gap:6px;background:white;color:var(--blue);padding:10px 22px;border-radius:999px;font-weight:700;font-size:.875rem;transition:all .2s" onmouseover="this.style.background='var(--blue-lt)'" onmouseout="this.style.background='white'">
      🚀 Daftar Jadi Penulis
    </a>
  </div>
  @endif

  {{-- PREFERENSI --}}
  <div class="profile-card">
    <div class="profile-card-header">⚙️ Preferensi</div>
    <div class="profile-card-body">
      <div class="settings-row mb-16">
        <div><div class="font-700 text-sm">Notifikasi Update Novel</div><div class="text-muted text-xs mt-4">Terima notifikasi saat novel favoritmu update</div></div>
        <label class="switch"><input type="checkbox" checked/><span class="switch-slider"></span></label>
      </div>
      <hr class="divider"/>
      <div class="settings-row mb-16">
        <div><div class="font-700 text-sm">Email Newsletter</div><div class="text-muted text-xs mt-4">Rekomendasi novel mingguan via email</div></div>
        <label class="switch"><input type="checkbox"/><span class="switch-slider"></span></label>
      </div>
      <hr class="divider"/>
      <div class="settings-row">
        <div><div class="font-700 text-sm">Auto Save Riwayat</div><div class="text-muted text-xs mt-4">Simpan posisi bacaan secara otomatis</div></div>
        <label class="switch"><input type="checkbox" checked/><span class="switch-slider"></span></label>
      </div>
    </div>
  </div>

  {{-- DANGER ZONE --}}
  <div class="profile-card" style="border-color:rgba(241,82,61,.3)">
    <div class="profile-card-header" style="color:var(--red)">⚠️ Zona Bahaya</div>
    <div class="profile-card-body">
      <div class="flex items-center justify-between">
        <div><div class="font-700 text-sm">Hapus Akun</div><div class="text-muted text-xs mt-4">Tindakan ini tidak dapat dibatalkan</div></div>
        <button class="btn-danger" onclick="showToast('error','Peringatan','Hubungi support untuk menghapus akun')">Hapus Akun</button>
      </div>
    </div>
  </div>

</div>
@endsection