@extends('layouts.app')
@section('title', 'Profil – Novela')

@section('content')
<div class="pf-wrap">

    {{-- ═══ HERO ═══ --}}
    <div class="pf-hero" style="display:flex; align-items:center; gap:24px; padding:28px 32px; border-bottom:1px solid var(--border);">

        {{-- Avatar --}}
        <div class="pf-av"
             style="width:80px; height:80px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:700; color:#fff; flex-shrink:0; overflow:hidden;">
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="" style="width:100%; height:100%; object-fit:cover;" />
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>

        {{-- Info --}}
        <div style="flex:1; min-width:0;">
            <div style="font-size:1.2rem; font-weight:700; margin-bottom:2px;">{{ $user->name }}</div>
            <div style="font-size:.85rem; color:var(--text-muted); margin-bottom:8px;">{{ $user->email }}</div>
            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                <span class="pf-badge pf-badge-blue">📖 {{ ucfirst($user->role) }}</span>
                @if ($stats['novels_read'] >= 10)
                    <span class="pf-badge pf-badge-gold">⭐ Pembaca Aktif</span>
                @endif
                @if ($user->email_verified_at)
                    <span class="pf-badge pf-badge-green">✓ Terverifikasi</span>
                @endif
            </div>
        </div>

        {{-- Ingin jadi penulis --}}
        @if ($user->role === 'reader')
            <div style="display:flex; align-items:center; gap:16px; background:rgba(255,255,255,.04); border:1px solid var(--border); border-radius:12px; padding:14px 18px; flex-shrink:0;">
                <div>
                    <div style="font-size:.85rem; font-weight:600; margin-bottom:2px;">✍️ Ingin jadi penulis?</div>
                    <div style="font-size:.78rem; color:var(--text-muted);">Bagikan ceritamu kepada jutaan pembaca</div>
                </div>
                <a href="{{ route('reader.author-request') }}" class="pf-btn" style="white-space:nowrap;">🚀 Daftar</a>
            </div>
        @endif

    </div>

    {{-- ═══ STATS ═══ --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:12px; padding:20px 32px;">
        @foreach ([
            ['val' => $stats['novels_read'],   'lbl' => 'Novel Dibaca',    'color' => 'var(--accent)'],
            ['val' => $stats['favorites'],     'lbl' => 'Favorit',         'color' => 'var(--green)'],
            ['val' => $stats['chapters_done'], 'lbl' => 'Chapter Selesai', 'color' => 'var(--orange)'],
            ['val' => $stats['comments'],      'lbl' => 'Komentar',        'color' => '#b094f5'],
        ] as $s)
            <div class="stat-card" style="text-align:center; padding:16px; border-radius:12px; background:var(--bg-card);">
                <div class="stat-num" style="font-size:1.6rem; font-weight:700; color:{{ $s['color'] }};">{{ $s['val'] }}</div>
                <div class="stat-lbl" style="font-size:.78rem; color:var(--text-muted); margin-top:4px;">{{ $s['lbl'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ═══ FORM GRID ═══ --}}
    <div class="pf-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:0 32px 16px;">

        {{-- DATA DIRI --}}
        <div class="pf-card" style="border-radius:14px; background:var(--bg-card); border:1px solid var(--border); overflow:hidden;">
            <div class="pf-card-head" style="padding:14px 20px; font-size:.85rem; font-weight:600; border-bottom:1px solid var(--border);">
                👤 Data Diri
            </div>
            <div class="pf-card-body" style="padding:20px;">
                <form method="POST" action="{{ route('reader.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div style="background:rgba(232,68,90,.1); border:1px solid rgba(232,68,90,.25); color:var(--red); padding:10px 14px; border-radius:8px; font-size:.85rem; margin-bottom:14px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                        <div>
                            <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Nama Lengkap</label>
                            <input class="pf-input" name="name" value="{{ old('name', $user->name) }}" required
                                   style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem;" />
                        </div>
                        <div>
                            <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Email</label>
                            <input class="pf-input" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem;" />
                        </div>
                    </div>

                    <div style="margin-bottom:12px;">
                        <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Bio</label>
                        <textarea class="pf-textarea" name="bio" rows="3"
                                  style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem; resize:vertical;">{{ old('bio', $user->bio ?? '') }}</textarea>
                    </div>

                    {{-- Foto profil custom --}}
                    <div style="margin-bottom:16px;">
                        <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Foto Profil</label>
                        <label for="photoInput"
                               style="display:inline-flex; align-items:center; gap:8px; padding:8px 14px; border-radius:8px; border:1px dashed var(--border); cursor:pointer; font-size:.82rem; color:var(--text-muted); transition:border-color .15s;">
                            📷 <span id="photoLabel">Pilih foto…</span>
                        </label>
                        <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;"
                               onchange="document.getElementById('photoLabel').textContent = this.files[0]?.name || 'Pilih foto…'" />
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" class="pf-btn">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- KEAMANAN --}}
        <div class="pf-card" style="border-radius:14px; background:var(--bg-card); border:1px solid var(--border); overflow:hidden;">
            <div class="pf-card-head" style="padding:14px 20px; font-size:.85rem; font-weight:600; border-bottom:1px solid var(--border);">
                🔒 Keamanan Akun
            </div>
            <div class="pf-card-body" style="padding:20px;">
                <form method="POST" action="{{ route('reader.profile.password') }}">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Password Lama</label>
                        <input class="pf-input" type="password" name="current_password" placeholder="••••••••" required
                               style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem;" />
                        @error('current_password')
                            <div style="font-size:.78rem; color:var(--red); margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom:12px;">
                        <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Password Baru</label>
                        <input class="pf-input" type="password" name="password" placeholder="Min. 8 karakter" required
                               style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem;" />
                    </div>

                    <div style="margin-bottom:16px;">
                        <label class="pf-lbl" style="font-size:.78rem; color:var(--text-muted); display:block; margin-bottom:5px;">Konfirmasi Password</label>
                        <input class="pf-input" type="password" name="password_confirmation" placeholder="Ulangi" required
                               style="width:100%; padding:9px 12px; border-radius:8px; border:1px solid var(--border); background:var(--bg-mid); color:inherit; font-size:.88rem;" />
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" class="pf-btn">🔑 Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- /pf-grid --}}

    {{-- ═══ SESI & ZONA BAHAYA ═══ --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:0 32px 32px;">

        {{-- SESI --}}
        <div style="border-radius:14px; background:var(--bg-card); border:1px solid var(--border); overflow:hidden;">
            <div style="padding:14px 20px; font-size:.85rem; font-weight:600; border-bottom:1px solid var(--border);">
                ⚙️ Sesi
            </div>
            <div style="padding:20px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
                <div>
                    <div style="font-size:.88rem; font-weight:600; margin-bottom:3px;">Keluar dari Akun</div>
                    <div style="font-size:.78rem; color:var(--text-muted);">Akhiri sesi login kamu sekarang</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="flex-shrink:0;">
                    @csrf
                    <button type="submit" class="pf-btn" style="white-space:nowrap;">🚪 Logout</button>
                </form>
            </div>
        </div>

        {{-- ZONA BAHAYA --}}
        <div style="border-radius:14px; background:rgba(232,68,90,.06); border:1px solid rgba(232,68,90,.25); overflow:hidden;">
            <div style="padding:14px 20px; font-size:.85rem; font-weight:600; border-bottom:1px solid rgba(232,68,90,.2); color:var(--red);">
                ⚠️ Zona Bahaya
            </div>
            <div style="padding:20px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
                <div>
                    <div style="font-size:.88rem; font-weight:600; margin-bottom:3px;">Hapus Akun</div>
                    <div style="font-size:.78rem; color:var(--text-muted);">Semua data akan dihapus permanen dan tidak dapat dikembalikan.</div>
                </div>
                <button class="pf-btn pf-btn-danger" style="flex-shrink:0; white-space:nowrap;"
                        onclick="showToast('danger','Peringatan','Hubungi support untuk menghapus akun')">
                    Hapus Akun
                </button>
            </div>
        </div>

    </div>

</div>{{-- /pf-wrap --}}
@endsection
