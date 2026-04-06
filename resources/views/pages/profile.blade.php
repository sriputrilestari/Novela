@extends('layouts.app')
@section('title', 'Profil – Novela')

@section('content')
    <div class="pf-wrap">

        {{-- ═══ HERO ═══ --}}
        <div class="pf-hero">
            <div class="pf-av-wrap">
                <div class="pf-av">
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt=""
                            style="width:100%;height:100%;object-fit:cover" />
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
            </div>

            <div class="pf-info">
                <div class="pf-name">{{ $user->name }}</div>
                <div class="pf-email">{{ $user->email }}</div>
                <div class="pf-badges">
                    <span class="pf-badge pf-badge-blue">📖 {{ ucfirst($user->role) }}</span>
                    @if ($stats['novels_read'] >= 10)
                        <span class="pf-badge pf-badge-gold">⭐ Pembaca Aktif</span>
                    @endif
                    @if ($user->email_verified_at)
                        <span class="pf-badge pf-badge-green">✓ Terverifikasi</span>
                    @endif
                </div>
            </div>

            @if ($user->role === 'reader')
                <div class="pf-writer-box">
                    <div>
                        <div class="pf-writer-title">✍️ Ingin jadi penulis?</div>
                        <div class="pf-writer-sub">Bagikan ceritamu kepada jutaan pembaca</div>
                    </div>
                    <a href="{{ route('reader.author-request') }}" class="pf-writer-btn">🚀 Daftar</a>
                </div>
            @endif
        </div>

        {{-- ═══ STATS ═══ --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:20px 32px">
            <div class="stat-card">
                <div class="stat-num">{{ $stats['novels_read'] }}</div>
                <div class="stat-lbl">Novel Dibaca</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:var(--green)">{{ $stats['favorites'] }}</div>
                <div class="stat-lbl">Favorit</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:var(--orange)">{{ $stats['chapters_done'] }}</div>
                <div class="stat-lbl">Chapter Selesai</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#b094f5">{{ $stats['comments'] }}</div>
                <div class="stat-lbl">Komentar</div>
            </div>
        </div>

        {{-- ═══ FORM GRID ═══ --}}
        <div class="pf-grid">

            {{-- DATA DIRI --}}
            <div class="pf-card">
                <div class="pf-card-head">👤 Data Diri</div>
                <div class="pf-card-body">
                    <form method="POST" action="{{ route('reader.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-error mb-16">{{ $errors->first() }}</div>
                        @endif
                        <div class="pf-row2" style="margin-bottom:10px">
                            <div class="pf-field">
                                <label class="pf-lbl">Nama Lengkap</label>
                                <input class="pf-input" name="name" value="{{ old('name', $user->name) }}" required />
                            </div>
                            <div class="pf-field">
                                <label class="pf-lbl">Email</label>
                                <input class="pf-input" type="email" name="email"
                                    value="{{ old('email', $user->email) }}" required />
                            </div>
                        </div>
                        <div class="pf-field" style="margin-bottom:10px">
                            <label class="pf-lbl">Bio</label>
                            <textarea class="pf-textarea" name="bio">{{ old('bio', $user->bio ?? '') }}</textarea>
                        </div>
                        <div class="pf-field" style="margin-bottom:12px">
                            <label class="pf-lbl">Foto Profil</label>
                            <input type="file" name="photo" accept="image/*" class="pf-input" style="padding:6px" />
                        </div>
                        <div class="pf-row-end">
                            <button type="submit" class="pf-btn">💾 Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- KEAMANAN --}}
            <div class="pf-card">
                <div class="pf-card-head">🔒 Keamanan Akun</div>
                <div class="pf-card-body">
                    <form method="POST" action="{{ route('reader.profile.password') }}">
                        @csrf
                        <div class="pf-field" style="margin-bottom:10px">
                            <label class="pf-lbl">Password Lama</label>
                            <input class="pf-input" type="password" name="current_password" placeholder="••••••••"
                                required />
                            @error('current_password')
                                <div class="pf-form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pf-field" style="margin-bottom:10px">
                            <label class="pf-lbl">Password Baru</label>
                            <input class="pf-input" type="password" name="password" placeholder="Min. 8 karakter"
                                required />
                        </div>
                        <div class="pf-field" style="margin-bottom:12px">
                            <label class="pf-lbl">Konfirmasi Password</label>
                            <input class="pf-input" type="password" name="password_confirmation" placeholder="Ulangi"
                                required />
                        </div>
                        <div class="pf-row-end">
                            <button type="submit" class="pf-btn">🔑 Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>{{-- /pf-grid --}}

        {{-- ═══ LOGOUT / DANGER ═══ --}}
        <div class="pf-grid-bottom">
            <div class="pf-card">
                <div class="pf-card-head">⚙️ Sesi</div>
                <div class="pf-card-body">
                    <div class="pf-danger-row">
                        <div>
                            <div class="pf-sw-lbl">Keluar dari Akun</div>
                            <div class="pf-sw-sub">Akhiri sesi login kamu sekarang</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="pf-btn">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="pf-card pf-card-danger">
                <div class="pf-card-head">⚠️ Zona Bahaya</div>
                <div class="pf-card-body">
                    <div class="pf-danger-row">
                        <div>
                            <div class="pf-danger-title">Hapus Akun</div>
                            <div class="pf-danger-sub">Semua data akan dihapus permanen dan tidak dapat dikembalikan.</div>
                        </div>
                        <button class="pf-btn pf-btn-danger"
                            onclick="showToast('danger','Peringatan','Hubungi support untuk menghapus akun')">
                            Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /pf-wrap --}}
@endsection

@push('styles')
    <style>
        .alert-error {
            background: rgba(232, 68, 90, .1);
            border: 1px solid rgba(232, 68, 90, .25);
            color: var(--red);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: .875rem;
        }
    </style>
@endpush
