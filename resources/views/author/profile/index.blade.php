@extends('author.layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
  --bg: #eef1f7;
  --white: #ffffff;
  --surface: #f7f8fc;
  --border: #e0e4ef;
  --text: #18192a;
  --text-soft: #5a5f7a;
  --text-muted: #9698ae;
  --primary: #3d5af1;
  --primary-light: #eef0fe;
  --primary-glow: rgba(61,90,241,.2);
  --primary-dim: rgba(61,90,241,.1);
  --teal: #00c9a7;
  --teal-light: #e0faf5;
  --red: #f1523d;
  --red-light: #fef0ee;
  --amber: #f1a83d;
  --amber-light: #fef6e6;
  --radius: 18px;
  --radius-sm: 11px;
}

.profile-wrap {
  max-width: 780px;
  margin: 0 auto;
  padding: 32px 16px 64px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  color: var(--text);
}

/* ── NOTIFICATION ── */
.notif-stack {
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 9999;
  display: flex;
  flex-direction: column-reverse;
  gap: 10px;
  pointer-events: none;
}

.notif {
  pointer-events: all;
  display: flex;
  align-items: center;
  gap: 12px;
  background: rgba(255,255,255,.94);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,.8);
  border-radius: 14px;
  padding: 14px 16px;
  min-width: 300px;
  max-width: 360px;
  box-shadow: 0 8px 32px rgba(24,25,42,.14), 0 2px 8px rgba(24,25,42,.08);
  animation: popUp .4s cubic-bezier(.16,1,.3,1) both;
  position: relative;
  overflow: hidden;
}

.notif.hide {
  animation: popDown .3s ease forwards;
}

.notif-icon-wrap {
  width: 38px; height: 38px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px;
  font-weight: 700;
  flex-shrink: 0;
}

.notif-content { flex: 1; }
.notif-title { font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.2; }
.notif-msg   { font-size: 12px; color: var(--text-soft); margin-top: 2px; }

.notif-close {
  width: 26px; height: 26px;
  border-radius: 7px;
  background: var(--surface);
  border: 1px solid var(--border);
  color: var(--text-muted);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700;
  transition: all .2s;
  flex-shrink: 0;
}
.notif-close:hover { background: var(--border); color: var(--text); }

.notif-progress {
  position: absolute;
  bottom: 0; left: 0;
  height: 3px;
  border-radius: 99px;
  animation: shrinkBar 4.5s linear forwards;
}

@keyframes popUp {
  from { opacity: 0; transform: translateY(20px) scale(.95); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes popDown {
  to { opacity: 0; transform: translateY(10px) scale(.9); max-height: 0; margin: 0; padding: 0; }
}
@keyframes shrinkBar {
  from { width: 100%; }
  to   { width: 0%; }
}

/* ── TOP BAR ── */
.topbar {
  display: flex; align-items: center; justify-content: space-between;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px 24px;
  margin-bottom: 20px;
  box-shadow: 0 2px 12px rgba(24,25,42,.05);
  animation: fadeUp .4s ease both;
}

.topbar-left { display: flex; align-items: center; gap: 16px; }

.topbar-avatar {
  width: 48px; height: 48px;
  border-radius: 12px;
  background: var(--primary-light);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px;
  border: 2px solid rgba(61,90,241,.15);
  overflow: hidden;
  cursor: pointer;
  position: relative;
  transition: transform .2s;
  flex-shrink: 0;
  text-decoration: none;
}
.topbar-avatar:hover { transform: scale(1.08); }
.topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }
.avatar-cam-overlay {
  position: absolute; inset: 0;
  background: rgba(61,90,241,.45);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .2s;
  border-radius: 10px;
  color: white; font-size: 18px;
}
.topbar-avatar:hover .avatar-cam-overlay { opacity: 1; }

.topbar-name { font-size: 16px; font-weight: 700; color: var(--text); }
.topbar-email { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

.badge-online {
  display: inline-flex; align-items: center; gap: 6px;
  background: var(--teal-light);
  color: #00a88a;
  border: 1px solid rgba(0,201,167,.2);
  border-radius: 99px;
  padding: 6px 14px;
  font-size: 12px; font-weight: 600;
  font-family: 'Plus Jakarta Sans', sans-serif;
}

.online-dot {
  width: 7px; height: 7px;
  background: var(--teal);
  border-radius: 50%;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%,100% { opacity:1; box-shadow: 0 0 0 0 rgba(0,201,167,.5); }
  50%      { opacity:.7; box-shadow: 0 0 0 5px rgba(0,201,167,0); }
}

/* ── TABS ── */
.tabs {
  display: flex; gap: 6px;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 6px;
  margin-bottom: 24px;
  box-shadow: 0 2px 12px rgba(24,25,42,.04);
  animation: fadeUp .4s .06s ease both;
}

.tab-btn {
  flex: 1;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  padding: 11px;
  border-radius: 10px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13.5px; font-weight: 600;
  color: var(--text-muted);
  cursor: pointer;
  transition: all .25s;
  border: none;
  background: transparent;
}
.tab-btn.active {
  background: var(--primary);
  color: white;
  box-shadow: 0 4px 16px var(--primary-glow);
}
.tab-btn:not(.active):hover {
  background: var(--surface);
  color: var(--text);
}

/* ── SECTIONS ── */
.tab-section { display: none; animation: fadeUp .35s ease both; }
.tab-section.active { display: block; }

/* ── CARD ── */
.profile-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(24,25,42,.05);
  transition: box-shadow .25s;
}
.profile-card:hover { box-shadow: 0 8px 32px rgba(24,25,42,.09); }

.card-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 24px 28px 20px;
  border-bottom: 1px solid var(--border);
}
.card-head-left { display: flex; align-items: center; gap: 14px; }

.head-dots { display: flex; flex-direction: column; gap: 4px; }
.hd { width: 12px; height: 12px; border-radius: 50%; display: block; }

.head-title { font-size: 16px; font-weight: 700; color: var(--text); }
.head-sub   { font-size: 12.5px; color: var(--text-muted); margin-top: 2px; }
.head-step  { font-size: 12px; color: var(--text-muted); }

.card-body { padding: 26px 28px 28px; }

/* ── UPLOAD ZONE ── */
.upload-zone {
  border: 2px dashed var(--border);
  border-radius: var(--radius-sm);
  padding: 24px;
  text-align: center;
  margin-bottom: 24px;
  cursor: pointer;
  transition: all .2s;
}
.upload-zone:hover {
  border-color: var(--primary);
  background: var(--primary-dim);
}

.upload-avatar {
  width: 72px; height: 72px;
  border-radius: 16px;
  background: var(--primary-light);
  display: flex; align-items: center; justify-content: center;
  font-size: 28px;
  margin: 0 auto 12px;
  border: 2px solid rgba(61,90,241,.15);
  overflow: hidden;
}
.upload-avatar img { width: 100%; height: 100%; object-fit: cover; }

.upload-title { font-size: 14px; font-weight: 600; color: var(--text); }
.upload-hint  { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
.upload-hint b { color: var(--primary); }

/* ── INFO CHIPS ── */
.info-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 22px; }
.chip {
  display: flex; align-items: center; gap: 6px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 7px 12px;
  font-size: 12px; font-weight: 500;
  color: var(--text-soft);
}

/* ── FORM ── */
.form-group { margin-bottom: 20px; }
.form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }

@media (max-width: 560px) {
  .form-row { grid-template-columns: 1fr; }
}

.form-label {
  font-size: 12px; font-weight: 700;
  color: var(--text-soft);
  text-transform: uppercase;
  letter-spacing: .8px;
  display: block;
  margin-bottom: 8px;
}

.form-control {
  width: 100%;
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 13px 16px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px;
  color: var(--text);
  outline: none;
  transition: all .2s;
  -webkit-appearance: none;
}
.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px var(--primary-dim);
  background: var(--white);
}
.form-control::placeholder { color: var(--text-muted); }
textarea.form-control { resize: vertical; min-height: 105px; }

@if($errors->any())
.form-control-error {
  border-color: var(--red) !important;
  box-shadow: 0 0 0 4px rgba(241,82,61,.1) !important;
}
.field-error {
  font-size: 12px; color: var(--red);
  margin-top: 6px; display: block;
}
@endif

.input-wrap { position: relative; }
.input-wrap .form-control { padding-right: 50px; }

.toggle-eye {
  position: absolute; right: 12px; top: 50%;
  transform: translateY(-50%);
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 7px;
  width: 30px; height: 30px;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
  color: var(--text-muted); cursor: pointer;
  transition: all .2s;
}
.toggle-eye:hover { background: var(--border); color: var(--text); }

/* ── STRENGTH ── */
.strength-wrap {
  display: flex; align-items: center; gap: 8px;
  margin-top: 8px;
}
.strength-track {
  flex: 1; height: 5px;
  background: var(--border);
  border-radius: 99px;
  overflow: hidden;
}
.strength-fill {
  height: 100%; width: 0%;
  border-radius: 99px;
  transition: width .4s ease, background .4s ease;
}
.strength-wrap > span {
  font-size: 11.5px; color: var(--text-muted);
  min-width: 80px; text-align: right;
  font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── CARD FOOTER ── */
.card-footer {
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;
  padding: 18px 28px;
  border-top: 1px solid var(--border);
  background: var(--surface);
}
.card-footer small { font-size: 12px; color: var(--text-muted); }

/* ── BUTTONS ── */
.btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--primary);
  color: white;
  border: none;
  border-radius: var(--radius-sm);
  padding: 12px 26px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px; font-weight: 700;
  cursor: pointer;
  transition: all .2s;
  letter-spacing: .2px;
}
.btn-primary:hover {
  background: #2d48e0;
  transform: translateY(-1px);
  box-shadow: 0 6px 24px var(--primary-glow);
}
.btn-primary:active { transform: translateY(0); }

.btn-teal {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--teal);
  color: #0d1a18;
  border: none;
  border-radius: var(--radius-sm);
  padding: 12px 26px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px; font-weight: 700;
  cursor: pointer;
  transition: all .2s;
}
.btn-teal:hover {
  background: #00b094;
  transform: translateY(-1px);
  box-shadow: 0 6px 24px rgba(0,201,167,.3);
}
.btn-teal:active { transform: translateY(0); }

/* ── VALIDATION ERRORS ── */
.error-box {
  display: flex; align-items: flex-start; gap: 10px;
  background: var(--red-light);
  border: 1.5px solid rgba(241,82,61,.25);
  border-radius: var(--radius-sm);
  padding: 14px 16px;
  margin-bottom: 20px;
  font-size: 13px; color: #c43020;
}
.error-box ul { margin: 4px 0 0 16px; }
.error-box li { margin-bottom: 2px; }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}
</style>

{{-- NOTIFICATION STACK --}}
<div class="notif-stack" id="notifStack"></div>

<div class="profile-wrap">

  {{-- TOP BAR --}}
  <div class="topbar">
    <div class="topbar-left">

      {{-- Avatar (klik untuk ganti foto) --}}
      <div class="topbar-avatar" id="topbarAvatar" onclick="document.getElementById('photoFileInput').click()" title="Klik untuk ganti foto">
        @if(auth()->user()->photo)
          <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" id="avatarImg">
        @else
          <span id="avatarEmoji">👤</span>
        @endif
        <div class="avatar-cam-overlay">📷</div>
      </div>

      <div>
        <div class="topbar-name">{{ auth()->user()->name }}</div>
        <div class="topbar-email">{{ auth()->user()->email }}</div>
      </div>
    </div>

    <div class="badge-online">
      <span class="online-dot"></span>
      Aktif
    </div>
  </div>

  {{-- TABS --}}
  <div class="tabs">
    <button type="button" class="tab-btn active" id="tab-profile" onclick="switchTab('profile')">
      🪪 Informasi Profil
    </button>
    <button type="button" class="tab-btn" id="tab-password" onclick="switchTab('password')">
      🔐 Keamanan
    </button>
  </div>

  {{-- ── SECTION: PROFILE ── --}}
  <div class="tab-section active" id="sec-profile">
    <div class="profile-card">

      <div class="card-head">
        <div class="card-head-left">
          <div class="head-dots">
            <span class="hd" style="background:#f1523d"></span>
            <span class="hd" style="background:#f1a83d"></span>
            <span class="hd" style="background:#00c9a7"></span>
          </div>
          <div>
            <div class="head-title">Informasi Profil</div>
            <div class="head-sub">Tampil di halaman publik penulis</div>
          </div>
        </div>
        <div class="head-step">01 / 02</div>
      </div>

      <div class="card-body">

        @if($errors->has('photo') || $errors->has('bio'))
          <div class="error-box">
            <span>⚠</span>
            <ul>
              @foreach($errors->only(['photo','bio']) as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('author.profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              id="profileForm">
          @csrf

          {{-- Photo Upload Zone --}}
          <div class="upload-zone" onclick="document.getElementById('photoFileInput').click()">
            <div class="upload-avatar" id="uploadAvatarPreview">
              @if(auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Profil" id="uploadAvatarImg">
              @else
                <span id="uploadAvatarEmoji">👤</span>
              @endif
            </div>
            <div class="upload-title">Klik untuk ubah foto profil</div>
            <div class="upload-hint">Mendukung <b>JPG, PNG, WEBP</b> · Maks. <b>2 MB</b></div>
            <input type="file"
                   name="photo"
                   id="photoFileInput"
                   accept="image/*"
                   style="display:none"
                   onchange="previewPhoto(event)">
          </div>

          {{-- Info Chips --}}
          <div class="info-chips">
            <div class="chip">💡 Bio 2–3 kalimat</div>
            <div class="chip">🎯 Sebutkan topik keahlian</div>
            <div class="chip">👁 Terlihat publik</div>
          </div>

          {{-- Bio --}}
          <div class="form-group">
            <label class="form-label" for="bioInput">Bio Penulis</label>
            <textarea name="bio"
                      id="bioInput"
                      rows="4"
                      class="form-control {{ $errors->has('bio') ? 'form-control-error' : '' }}"
                      placeholder="Ceritakan siapa kamu dan apa yang kamu tulis…">{{ old('bio', auth()->user()->bio) }}</textarea>
            @error('bio')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="card-footer" style="margin: 0 -28px -28px; padding: 18px 28px;">
            <small>⏱ Perubahan langsung terlihat</small>
            <button type="submit" class="btn-primary">
              → Simpan Perubahan
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  {{-- ── SECTION: PASSWORD ── --}}
  <div class="tab-section" id="sec-password">
    <div class="profile-card">

      <div class="card-head">
        <div class="card-head-left">
          <div class="head-dots">
            <span class="hd" style="background:#3d5af1"></span>
            <span class="hd" style="background:#6b7ff5"></span>
            <span class="hd" style="background:#9ba8f8"></span>
          </div>
          <div>
            <div class="head-title">Keamanan Akun</div>
            <div class="head-sub">Perbarui password secara berkala</div>
          </div>
        </div>
        <div class="head-step">02 / 02</div>
      </div>

      <div class="card-body">

        @if($errors->has('current_password') || $errors->has('password'))
          <div class="error-box">
            <span>⚠</span>
            <ul>
              @foreach($errors->only(['current_password','password']) as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('author.profile.password') }}" method="POST" id="passwordForm">
          @csrf

          {{-- Password Lama --}}
          <div class="form-group">
            <label class="form-label" for="pw_current">Password Lama</label>
            <div class="input-wrap">
              <input type="password"
                     name="current_password"
                     id="pw_current"
                     class="form-control {{ $errors->has('current_password') ? 'form-control-error' : '' }}"
                     placeholder="Masukkan password saat ini"
                     autocomplete="current-password">
              <button type="button" class="toggle-eye" onclick="togglePw('pw_current', this)">👁</button>
            </div>
            @error('current_password')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password Baru & Konfirmasi (2 kolom) --}}
          <div class="form-row">
            <div>
              <label class="form-label" for="pw_new">Password Baru</label>
              <div class="input-wrap">
                <input type="password"
                       name="password"
                       id="pw_new"
                       class="form-control {{ $errors->has('password') ? 'form-control-error' : '' }}"
                       placeholder="Min. 8 karakter"
                       autocomplete="new-password"
                       oninput="checkStrength(this.value)">
                <button type="button" class="toggle-eye" onclick="togglePw('pw_new', this)">👁</button>
              </div>
              <div class="strength-wrap">
                <div class="strength-track">
                  <div class="strength-fill" id="strengthBar"></div>
                </div>
                <span id="strengthLabel">—</span>
              </div>
              @error('password')
                <span class="field-error">{{ $message }}</span>
              @enderror
            </div>

            <div>
              <label class="form-label" for="pw_confirm">Konfirmasi Password</label>
              <div class="input-wrap">
                <input type="password"
                       name="password_confirmation"
                       id="pw_confirm"
                       class="form-control"
                       placeholder="Ulangi password baru"
                       autocomplete="new-password">
                <button type="button" class="toggle-eye" onclick="togglePw('pw_confirm', this)">👁</button>
              </div>
            </div>
          </div>

          <div class="card-footer" style="margin: 0 -28px -28px; padding: 18px 28px;">
            <small>🔒 Setelah diganti, login ulang diperlukan</small>
            <button type="submit" class="btn-teal">
              ✓ Update Password
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

</div>

<script>
// ── AUTO-SHOW FLASH NOTIFICATION ──────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  @if(session('success'))
    showNotif('success', 'Berhasil ✓', @json(session('success')));
  @endif

  @if(session('error'))
    showNotif('error', 'Terjadi Kesalahan', @json(session('error')));
  @endif

  @if($errors->any())
    showNotif('error', 'Periksa Kembali', 'Ada beberapa field yang perlu diperbaiki.');

    // Otomatis buka tab yang punya error
    @if($errors->has('current_password') || $errors->has('password'))
      switchTab('password');
    @endif
  @endif

});

// ── TABS ──────────────────────────────────────────────────────────
function switchTab(id) {
  document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-section').forEach(s => s.classList.remove('active'));
  document.getElementById('tab-' + id).classList.add('active');
  document.getElementById('sec-' + id).classList.add('active');
}

// ── PHOTO PREVIEW ─────────────────────────────────────────────────
function previewPhoto(e) {
  const file = e.target.files[0];
  if (!file) return;

  if (file.size > 2 * 1024 * 1024) {
    showNotif('warn', 'File Terlalu Besar ⚠', 'Ukuran foto melebihi batas 2 MB.');
    e.target.value = '';
    return;
  }

  const reader = new FileReader();
  reader.onload = function (ev) {
    const src = ev.target.result;

    // Update topbar avatar
    const topbar = document.getElementById('topbarAvatar');
    const emoji  = topbar.querySelector('#avatarEmoji');
    let   img    = topbar.querySelector('#avatarImg');
    if (!img) {
      img = document.createElement('img');
      img.id = 'avatarImg';
      img.alt = 'Foto Profil';
      if (emoji) emoji.replaceWith(img);
      else topbar.prepend(img);
    }
    img.src = src;

    // Update upload zone avatar
    const zone     = document.getElementById('uploadAvatarPreview');
    const zEmoji   = zone.querySelector('#uploadAvatarEmoji');
    let   zImg     = zone.querySelector('#uploadAvatarImg');
    if (!zImg) {
      zImg = document.createElement('img');
      zImg.id = 'uploadAvatarImg';
      zImg.alt = 'Preview';
      if (zEmoji) zEmoji.replaceWith(zImg);
      else zone.prepend(zImg);
    }
    zImg.src = src;

    showNotif('info', 'Foto Dipilih 📷', 'Klik "Simpan Perubahan" untuk menyimpan.');
  };
  reader.readAsDataURL(file);
}

// ── TOGGLE PASSWORD VISIBILITY ────────────────────────────────────
function togglePw(id, btn) {
  const input = document.getElementById(id);
  input.type  = input.type === 'password' ? 'text' : 'password';
  btn.textContent = input.type === 'text' ? '🙈' : '👁';
}

// ── PASSWORD STRENGTH ─────────────────────────────────────────────
function checkStrength(val) {
  let score = 0;
  if (val.length >= 8)          score++;
  if (/[A-Z]/.test(val))        score++;
  if (/[0-9]/.test(val))        score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  const pcts  = ['0%', '25%', '50%', '75%', '100%'];
  const clrs  = ['transparent', '#f1523d', '#f1a83d', '#3d5af1', '#00c9a7'];
  const lbls  = ['—', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];

  const bar   = document.getElementById('strengthBar');
  const label = document.getElementById('strengthLabel');

  bar.style.width      = val.length ? pcts[score] : '0%';
  bar.style.background = val.length ? clrs[score] : 'transparent';
  label.textContent    = val.length ? (lbls[score] || 'Lemah') : '—';
  label.style.color    = val.length ? (clrs[score] || '#9698ae') : '#9698ae';
}

// ── NOTIFICATION ──────────────────────────────────────────────────
const nCfg = {
  success: { bar: '#00c9a7', icon_bg: '#e0faf5', icon_clr: '#00a88a', icon: '✓' },
  error:   { bar: '#f1523d', icon_bg: '#fef0ee', icon_clr: '#c43020', icon: '✗' },
  info:    { bar: '#3d5af1', icon_bg: '#eef0fe', icon_clr: '#2d48e0', icon: 'ℹ' },
  warn:    { bar: '#f1a83d', icon_bg: '#fef6e6', icon_clr: '#c48020', icon: '!' },
};

function showNotif(type, title, msg) {
  const c  = nCfg[type] || nCfg.info;
  const el = document.createElement('div');
  el.className = 'notif';

  el.innerHTML = `
    <div class="notif-icon-wrap" style="background:${c.icon_bg};color:${c.icon_clr}">${c.icon}</div>
    <div class="notif-content">
      <div class="notif-title">${title}</div>
      <div class="notif-msg">${msg}</div>
    </div>
    <button class="notif-close" type="button" onclick="dismissNotif(this.parentElement)">✕</button>
  `;

  // Progress bar
  const prog = document.createElement('div');
  prog.className = 'notif-progress';
  prog.style.background = c.bar;
  el.appendChild(prog);

  document.getElementById('notifStack').appendChild(el);
  setTimeout(() => dismissNotif(el), 4500);
}

function dismissNotif(el) {
  if (!el || el.classList.contains('hide')) return;
  el.classList.add('hide');
  setTimeout(() => el.remove(), 350);
}
</script>

@endsection