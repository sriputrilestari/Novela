<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Novela')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Inter:wght@400;500;600&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/novela/variables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/base.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/components.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/pages.css') }}" />
    @stack('styles')
</head>

<body>
    <div class="app">

        {{-- ═══ TOPBAR ═══ --}}
        <nav class="topbar">
            {{-- LEFT: LOGO + SEARCH --}}
            <div class="topbar-left">
                <a class="topbar-logo" href="{{ route('home') }}">
                    <span class="logo-star">✦</span> Novela
                </a>

                <form action="{{ route('search') }}" method="GET" class="search-wrap left-search">
                    <svg class="search-icon" width="14" height="14" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input class="search-input" name="q" placeholder="Cari novel..."
                        value="{{ request('q') }}" />
                </form>
            </div>

            {{-- CENTER: NAV --}}
            <div class="topbar-nav spaced-nav">
                <a class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-4 0H7m5 0h2" />
                    </svg>
                    Beranda
                </a>

                <a class="nav-btn {{ request()->routeIs('search') ? 'active' : '' }}" href="{{ route('search') }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    Jelajahi
                </a>

                {{-- <a class="nav-btn {{ request()->routeIs('genres') ? 'active' : '' }}" href="{{ route('genres') }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Genre
                </a> --}}

                @auth
                    <a class="nav-btn {{ request()->routeIs('favorites') ? 'active' : '' }}"
                        href="{{ route('favorites') }}">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Favorit
                    </a>

                    <a class="nav-btn {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Riwayat
                    </a>
                @endauth
            </div>

            {{-- RIGHT: AVATAR / LOGIN --}}
            <div class="topbar-right">
                @auth
                    <a class="avatar-btn" href="{{ route('reader.profile.index') }}" title="{{ auth()->user()->name }}">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </a>
                @else
                    <a class="btn-primary" href="{{ route('login') }}" >Masuk</a>
                    <a class="btn-primary" href="{{ route('register') }}" >Daftar</a>
                @endauth
            </div>

        </nav>

        {{-- ═══ KONTEN ═══ --}}
        @yield('content')

        {{-- ═══ FOOTER — selalu di bawah ═══ --}}
        <footer class="footer">
            ✦ <strong>Novela</strong> — Read Anywhere, Dream Everywhere &nbsp;·&nbsp;
            © {{ date('Y') }} Novela Inc.
        </footer>

        {{-- ═══ TOAST ═══ --}}
        <div class="toast" id="toast" role="status" aria-live="polite">
            <div class="toast-icon" id="toast-icon">✓</div>
            <div class="toast-text">
                <div class="toast-title" id="toast-title">Berhasil</div>
                <div class="toast-msg" id="toast-msg"></div>
            </div>
        </div>

        {{-- ═══ MODAL LAPORAN ═══ --}}
        <div class="modal-overlay" id="report-modal" onclick="if(event.target===this)closeModal('report-modal')">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">🚩 Laporkan Konten</div>
                    <button class="modal-close" onclick="closeModal('report-modal')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Pilih Alasan</label>
                        <select class="form-select">
                            <option>Plagiat / Pencurian karya</option>
                            <option>Konten tidak pantas</option>
                            <option>Spam atau Penipuan</option>
                            <option>Kekerasan berlebihan</option>
                            <option>Ujaran kebencian</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-textarea" placeholder="Jelaskan masalah yang ditemukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="closeModal('report-modal')">Batal</button>
                    <button class="btn-danger" onclick="submitReport()">Kirim Laporan</button>
                </div>
            </div>
        </div>

    </div>{{-- /app --}}

    {{-- Session flash → toast --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('success', 'Berhasil', '{{ addslashes(session('success')) }}');
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('danger', 'Error', '{{ addslashes(session('error')) }}');
            });
        </script>
    @endif

    <script src="{{ asset('js/novela/ui.js') }}"></script>
    <script src="{{ asset('js/novela/navigation.js') }}"></script>
    <script src="{{ asset('js/novela/reader.js') }}"></script>
    <script src="{{ asset('js/novela/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
