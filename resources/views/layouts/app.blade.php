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
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Inter:wght@400;500;600;700&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/novela/variables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/base.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/components.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/novela/pages.css') }}" />
    @stack('styles')
</head>

<body>
    <div class="app">
        <nav class="topbar">
            <div class="topbar-row">
                <a class="topbar-logo" href="{{ route('home') }}">
                    <span class="logo-star">*</span> Novela
                </a>

                <div class="topbar-right">
                    @auth
                        @php
                            $profileRoute = auth()->user()->role === 'admin'
                                ? route('admin.dashboard')
                                : (auth()->user()->role === 'author'
                                    ? route('author.profile.index')
                                    : route('reader.profile.index'));
                        @endphp
                        <a class="avatar-btn" href="{{ $profileRoute }}" title="{{ auth()->user()->name }}">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </a>
                    @else
                        <a class="btn-secondary btn-auth-mobile" href="{{ route('login') }}">Masuk</a>
                    @endauth
                </div>
            </div>

            <div class="topbar-search-row">
                <form action="{{ route('search') }}" method="GET" class="search-wrap topbar-search-form">
                    <svg class="search-icon" width="14" height="14" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <input class="search-input" name="q" placeholder="Cari novel..." value="{{ request('q') }}" />
                </form>
            </div>

            <div class="topbar-nav desktop-nav">
                <a class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-4 0H7m5 0h2" />
                    </svg>
                    Beranda
                </a>

                <a class="nav-btn {{ request()->routeIs('search') ? 'active' : '' }}" href="{{ route('search') }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    Jelajahi
                </a>

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
        </nav>

        @yield('content')

        <footer class="footer">
            * <strong>Novela</strong> - Read Anywhere, Dream Everywhere
            <span class="footer-break">|</span>
            &copy; {{ date('Y') }} Novela
        </footer>

        <div class="toast" id="toast" role="status" aria-live="polite">
            <div class="toast-icon" id="toast-icon">OK</div>
            <div class="toast-text">
                <div class="toast-title" id="toast-title">Berhasil</div>
                <div class="toast-msg" id="toast-msg"></div>
            </div>
        </div>

        <nav class="mobile-bottom-nav">
            <a class="mobile-nav-btn {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <span>Home</span>
            </a>
            <a class="mobile-nav-btn {{ request()->routeIs('search') ? 'active' : '' }}" href="{{ route('search') }}">
                <span>Jelajah</span>
            </a>
            @auth
                <a class="mobile-nav-btn {{ request()->routeIs('favorites') ? 'active' : '' }}"
                    href="{{ route('favorites') }}">
                    <span>Favorit</span>
                </a>
                <a class="mobile-nav-btn {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                    <span>Riwayat</span>
                </a>
            @else
                <a class="mobile-nav-btn {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                    <span>Masuk</span>
                </a>
                <a class="mobile-nav-btn {{ request()->routeIs('register') ? 'active' : '' }}"
                    href="{{ route('register') }}">
                    <span>Daftar</span>
                </a>
            @endauth
        </nav>
    </div>

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

    <script>
        function openModal(id) {
            document.getElementById(id)?.classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.remove('open');
        }

        function switchTab(btn, tabId) {
            const row = btn.closest('.tabs-row') || document;
            row.querySelectorAll('.tab-btn').forEach(item => item.classList.remove('active'));
            btn.classList.add('active');

            const wrap = btn.closest('.content-wrap, .detail-content') || document;
            wrap.querySelectorAll('.tab-pane').forEach(item => item.classList.remove('active'));
            document.getElementById(tabId)?.classList.add('active');
        }
    </script>

    <script src="{{ asset('js/novela/ui.js') }}"></script>
    <script src="{{ asset('js/novela/navigation.js') }}"></script>
    <script src="{{ asset('js/novela/reader.js') }}"></script>
    <script src="{{ asset('js/novela/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
