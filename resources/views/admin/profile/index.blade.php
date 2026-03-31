@extends('layouts.admin')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        :root {
            --bg: #f4f6fc;
            --white: #ffffff;
            --surface: #f7f8fc;
            --border: #e8eaf3;
            --text: #18192a;
            --text-soft: #5a5f7a;
            --text-muted: #9698ae;
            --primary: #3d5af1;
            --primary-light: #eef0fe;
            --primary-glow: rgba(61, 90, 241, .2);
            --primary-dim: rgba(61, 90, 241, .1);
            --teal: #00c9a7;
            --teal-light: #e0faf5;
            --red: #f1523d;
            --red-light: #fef0ee;
            --amber: #f1a83d;
            --amber-light: #fef6e6;
            --radius: 16px;
            --radius-sm: 11px;
            --shadow: 0 2px 16px rgba(24, 25, 42, .07);
            --shadow-h: 0 8px 32px rgba(24, 25, 42, .13);
        }

        .dash {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            padding-bottom: 72px;
        }

        @keyframes up {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes notIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(.96)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        @keyframes notOt {
            to {
                opacity: 0;
                transform: translateY(8px) scale(.94);
                max-height: 0;
                padding: 0;
                margin: 0;
                overflow: hidden
            }
        }

        @keyframes bar {
            from {
                width: 100%
            }

            to {
                width: 0%
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(0, 201, 167, .5);
            }

            50% {
                opacity: .7;
                box-shadow: 0 0 0 5px rgba(0, 201, 167, 0);
            }
        }

        .a1 {
            animation: up .5s .00s ease both;
        }

        .a2 {
            animation: up .5s .07s ease both;
        }

        .a3 {
            animation: up .5s .13s ease both;
        }

        /* ── NOTIFICATION ── */
        #ns {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
            pointer-events: none;
        }

        .nt {
            pointer-events: all;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .97);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 16px;
            min-width: 300px;
            max-width: 350px;
            box-shadow: 0 8px 28px rgba(24, 25, 42, .12);
            animation: notIn .4s cubic-bezier(.16, 1, .3, 1) both;
        }

        .nt.out {
            animation: notOt .28s ease forwards;
        }

        .nt-ico {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .nt-ttl {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .nt-msg {
            font-size: 12px;
            color: var(--text-soft);
            margin-top: 1px;
            line-height: 1.4;
        }

        .nt-x {
            margin-left: auto;
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: #f4f6fc;
            border: 1px solid var(--border);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            transition: .18s;
        }

        .nt-x:hover {
            background: var(--border);
            color: var(--text);
        }

        .nt-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2.5px;
            border-radius: 99px;
            animation: bar 4.5s linear forwards;
        }

        /* ── BANNER ── */
        .banner {
            background: linear-gradient(130deg, var(--primary) 0%, #2d48e0 50%, #1e3bce 100%);
            border-radius: 20px;
            padding: 30px 36px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 80% 50%, rgba(255, 255, 255, .08) 0%, transparent 60%);
            pointer-events: none;
        }

        .bn-date {
            font-size: 11.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, .55);
            letter-spacing: .4px;
            margin-bottom: 8px;
        }

        .bn-name {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .bn-sub {
            font-size: 13px;
            color: rgba(255, 255, 255, .6);
            margin-top: 8px;
        }

        /* ── TOPBAR CARD ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 24px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-avatar {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            border: 2px solid rgba(61, 90, 241, .15);
            flex-shrink: 0;
            color: var(--primary);
        }

        .topbar-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-email {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .badge-role {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(61, 90, 241, .2);
            border-radius: 99px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-online {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--teal-light);
            color: #00a88a;
            border: 1px solid rgba(0, 201, 167, .2);
            border-radius: 99px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
        }

        .online-dot {
            width: 7px;
            height: 7px;
            background: var(--teal);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        /* ── TABS ── */
        .tabs {
            display: flex;
            gap: 6px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 6px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        .tab-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .25s;
            border: none;
            background: transparent;
        }

        .tab-btn.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 16px var(--primary-glow);
        }

        .tab-btn:not(.active):hover {
            background: var(--surface);
            color: var(--text);
        }

        /* ── SECTIONS ── */
        .tab-section {
            display: none;
            animation: up .35s ease both;
        }

        .tab-section.active {
            display: block;
        }

        /* ── PROFILE CARD ── */
        .profile-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: box-shadow .25s;
        }

        .profile-card:hover {
            box-shadow: var(--shadow-h);
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 28px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-head-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .head-dots {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .hd {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: block;
        }

        .head-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .head-sub {
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .head-step {
            font-size: 12px;
            color: var(--text-muted);
        }

        .card-body {
            padding: 26px 28px 28px;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 18px 28px;
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .card-footer small {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        @media(max-width:560px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
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

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control:disabled {
            cursor: not-allowed;
            opacity: .65;
        }

        .form-control-error {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 4px rgba(241, 82, 61, .1) !important;
        }

        .field-error {
            font-size: 12px;
            color: var(--red);
            margin-top: 6px;
            display: block;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .form-control {
            padding-right: 50px;
        }

        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 7px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .2s;
        }

        .toggle-eye:hover {
            background: var(--border);
            color: var(--text);
        }

        /* ── STRENGTH ── */
        .strength-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .strength-track {
            flex: 1;
            height: 5px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 99px;
            transition: width .4s ease, background .4s ease;
        }

        .strength-wrap>span {
            font-size: 11.5px;
            color: var(--text-muted);
            min-width: 90px;
            text-align: right;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── BUTTONS ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 12px 26px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .2px;
        }

        .btn-primary:hover {
            background: #2d48e0;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px var(--primary-glow);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-teal {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--teal);
            color: #0d1a18;
            border: none;
            border-radius: var(--radius-sm);
            padding: 12px 26px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-teal:hover {
            background: #00b094;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(0, 201, 167, .3);
        }

        /* ── ERROR BOX ── */
        .error-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--red-light);
            border: 1.5px solid rgba(241, 82, 61, .25);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #c43020;
        }

        .error-box ul {
            margin: 4px 0 0 16px;
        }

        .error-box li {
            margin-bottom: 2px;
        }

        /* ── INFO CHIPS ── */
        .info-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-soft);
        }
    </style>

    {{-- NOTIFICATION --}}
    <div id="ns"></div>

    <script>
        const NC = {
            success: {
                b: '#00c9a7',
                i: '#e0faf5',
                t: '#00a88a',
                ic: '✓'
            },
            error: {
                b: '#f1523d',
                i: '#fef0ee',
                t: '#c43020',
                ic: '✗'
            },
            info: {
                b: '#3d5af1',
                i: '#eef0fe',
                t: '#2d48e0',
                ic: 'ℹ'
            },
            warn: {
                b: '#f1a83d',
                i: '#fef6e6',
                t: '#c48020',
                ic: '!'
            }
        };

        function showN(type, title, msg) {
            const c = NC[type] || NC.info,
                el = document.createElement('div');
            el.className = 'nt';
            el.innerHTML =
                `<div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div><div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div><button class="nt-x" onclick="closeN(this.parentElement)">✕</button>`;
            const bar = document.createElement('div');
            bar.className = 'nt-bar';
            bar.style.background = c.b;
            el.appendChild(bar);
            document.getElementById('ns').appendChild(el);
            setTimeout(() => closeN(el), 4500);
        }

        function closeN(el) {
            if (!el || el.classList.contains('out')) return;
            el.classList.add('out');
            setTimeout(() => el && el.remove(), 300);
        }
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showN('success', 'Berhasil', @json(session('success')));
            @endif
            @if (session('error'))
                showN('error', 'Gagal', @json(session('error')));
            @endif
            @if ($errors->any())
                showN('error', 'Periksa Kembali', 'Ada beberapa field yang perlu diperbaiki.');
                @if ($errors->has('current_password') || $errors->has('password'))
                    switchTab('password');
                @endif
            @endif
        });
    </script>

    <div class="dash">

        {{-- BANNER --}}
        <div class="banner a1">
            <div>
                <div class="bn-date" id="bnDate"></div>
                <div class="bn-name">Profil Admin 👤</div>
                <div class="bn-sub">Kelola informasi akun dan keamanan kamu.</div>
            </div>
        </div>

        {{-- TOPBAR --}}
        <div class="topbar a2">
            <div class="topbar-left">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="topbar-name">{{ auth()->user()->name }}</div>
                    <div class="topbar-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div class="badge-role">🛡️ Admin</div>
                <div class="badge-online"><span class="online-dot"></span> Aktif</div>
            </div>
        </div>

        {{-- TABS --}}
        <div class="tabs a2">
            <button type="button" class="tab-btn active" id="tab-profile" onclick="switchTab('profile')">
                🪪 Informasi Profil
            </button>
            <button type="button" class="tab-btn" id="tab-password" onclick="switchTab('password')">
                🔐 Keamanan
            </button>
        </div>

        {{-- ── SECTION: PROFILE ── --}}
        <div class="tab-section active a3" id="sec-profile">
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
                            <div class="head-sub">Data dasar akun admin</div>
                        </div>
                    </div>
                    <div class="head-step">01 / 02</div>
                </div>

                <div class="card-body">

                    @if ($errors->has('name') || $errors->has('email'))
                        <div class="error-box">
                            <span>⚠</span>
                            <ul>
                                @foreach ($errors->only(['name', 'email']) as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" id="profileForm">
                        @csrf

                        <div class="info-chips">
                            <div class="chip">🛡️ Role: Admin</div>
                            <div class="chip">📧 Email dipakai untuk login</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label" for="inp_name">Nama Lengkap</label>
                                <input type="text" name="name" id="inp_name"
                                    class="form-control {{ $errors->has('name') ? 'form-control-error' : '' }}"
                                    value="{{ old('name', auth()->user()->name) }}" placeholder="Nama lengkap" required>
                                @error('name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label" for="inp_email">Alamat Email</label>
                                <input type="email" name="email" id="inp_email"
                                    class="form-control {{ $errors->has('email') ? 'form-control-error' : '' }}"
                                    value="{{ old('email', auth()->user()->email) }}" placeholder="email@contoh.com"
                                    required>
                                @error('email')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->username ?? '-' }}"
                                    disabled>
                            </div>
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="Admin" disabled>
                            </div>
                        </div>

                        <div class="card-footer" style="margin:24px -28px -28px;">
                            <small>⏱ Perubahan langsung diterapkan</small>
                            <button type="submit" class="btn-primary">→ Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SECTION: PASSWORD ── --}}
        <div class="tab-section a3" id="sec-password">
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

                    @if ($errors->has('current_password') || $errors->has('password'))
                        <div class="error-box">
                            <span>⚠</span>
                            <ul>
                                @foreach ($errors->only(['current_password', 'password']) as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.password') }}" method="POST" id="passwordForm">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="pw_current">Password Lama</label>
                            <div class="input-wrap">
                                <input type="password" name="current_password" id="pw_current"
                                    class="form-control {{ $errors->has('current_password') ? 'form-control-error' : '' }}"
                                    placeholder="Masukkan password saat ini" autocomplete="current-password">
                                <button type="button" class="toggle-eye"
                                    onclick="togglePw('pw_current',this)">👁</button>
                            </div>
                            @error('current_password')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div>
                                <label class="form-label" for="pw_new">Password Baru</label>
                                <div class="input-wrap">
                                    <input type="password" name="password" id="pw_new"
                                        class="form-control {{ $errors->has('password') ? 'form-control-error' : '' }}"
                                        placeholder="Min. 8 karakter" autocomplete="new-password"
                                        oninput="checkStrength(this.value)">
                                    <button type="button" class="toggle-eye"
                                        onclick="togglePw('pw_new',this)">👁</button>
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
                                    <input type="password" name="password_confirmation" id="pw_confirm"
                                        class="form-control" placeholder="Ulangi password baru"
                                        autocomplete="new-password">
                                    <button type="button" class="toggle-eye"
                                        onclick="togglePw('pw_confirm',this)">👁</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" style="margin:24px -28px -28px;">
                            <small>🔒 Setelah diganti, login ulang diperlukan</small>
                            <button type="submit" class="btn-teal">✓ Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('bnDate').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        function switchTab(id) {
            document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-section').forEach(s => s.classList.remove('active'));
            document.getElementById('tab-' + id).classList.add('active');
            document.getElementById('sec-' + id).classList.add('active');
        }

        function togglePw(id, btn) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
            btn.textContent = el.type === 'text' ? '🙈' : '👁';
        }

        function checkStrength(val) {
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const pcts = ['0%', '25%', '50%', '75%', '100%'];
            const clrs = ['transparent', '#f1523d', '#f1a83d', '#3d5af1', '#00c9a7'];
            const lbls = ['—', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
            const bar = document.getElementById('strengthBar');
            const lbl = document.getElementById('strengthLabel');
            bar.style.width = val.length ? pcts[score] : '0%';
            bar.style.background = val.length ? clrs[score] : 'transparent';
            lbl.textContent = val.length ? (lbls[score] || 'Lemah') : '—';
            lbl.style.color = val.length ? (clrs[score] || '#9698ae') : '#9698ae';
        }
    </script>

@endsection
