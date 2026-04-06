<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Novela – Baca Novel Online')</title>

    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <style>
        /* ═══════════════════════════════════════════
       DESIGN TOKENS
    ═══════════════════════════════════════════ */
        :root {
            --bg: #f4f6fc;
            --white: #ffffff;
            --blue: #3d5af1;
            --blue-lt: #eef0fe;
            --blue-md: #dde2fc;
            --blue-dk: #2d49e0;
            --green: #00c9a7;
            --green-lt: #e0faf5;
            --amber: #f1a83d;
            --amber-lt: #fef6e6;
            --red: #f1523d;
            --red-lt: #fef0ee;
            --purple: #a855f7;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
            --radius: 14px;
            --radius-lg: 20px;
            --shadow: 0 2px 16px rgba(24, 25, 42, .07);
            --shadow-h: 0 8px 32px rgba(24, 25, 42, .13);
            --font: 'Plus Jakarta Sans', sans-serif;
            --serif: 'DM Serif Display', serif;
            --sans: 'Plus Jakarta Sans', sans-serif;

            /* alias untuk profile page */
            --blue-dark: #2d49e0;
            --blue-light: #eef0fe;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-xs: 0 1px 3px rgba(24, 25, 42, .07);
            --shadow-sm: 0 2px 8px rgba(24, 25, 42, .10);
            --shadow-md: 0 4px 20px rgba(24, 25, 42, .13);
        }

        /* ═══════════════════════════════════════════
       RESET & BASE
    ═══════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font-family: var(--font);
        }

        img {
            max-width: 100%;
            display: block;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--line);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--blue);
        }

        /* ═══════════════════════════════════════════
       LAYOUT
    ═══════════════════════════════════════════ */
        .content-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 40px;
        }

        /* ================= NAVBAR FINAL ================= */

        .navbar {
            background: var(--white);
            border-bottom: 1.5px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 12px rgba(24, 25, 42, .06);
        }

        /* WRAPPER */
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 48px;
            height: 72px;

            position: relative;
            /* penting */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* LOGO */
        .nav-logo {
            font-family: var(--serif);
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--blue);
            text-decoration: none;
            display: flex;
            align-items: center;
            z-index: 2;
        }

        /* SEARCH */
        .nav-search {
            max-width: 280px;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
        }

        .nav-search svg {
            position: absolute;
            left: 12px;
            color: var(--ink-3);
            pointer-events: none;
        }

        .nav-search input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1.5px solid var(--line);
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink);
            background: var(--bg);
            outline: none;
            transition: 0.2s;
        }

        .nav-search input:focus {
            border-color: var(--blue);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        /* MENU */
        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            gap: 18px;

        }

        /* LINK */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink-2);
            transition: 0.2s;
            white-space: nowrap;
        }

        .nav-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--blue-lt);
            color: var(--blue);
        }

        /* RIGHT USER */
        .nav-user-menu,
        .nav-auth {
            z-index: 2;
        }

        /* AVATAR */
        .nav-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--blue), var(--blue-dk));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9rem;
            cursor: pointer;
            user-select: none;
            transition: 0.2s;
        }

        .nav-avatar:hover {
            box-shadow: 0 4px 14px rgba(61, 90, 241, .35);
            transform: translateY(-1px);
        }

        /* DROPDOWN */
        .user-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-h);
            min-width: 230px;
            z-index: 9999;
            display: none;
            overflow: hidden;
            animation: dropIn .18s ease;
        }

        .user-dropdown.open {
            display: block;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* DROPDOWN HEADER */
        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            background: var(--bg);
        }

        .dropdown-header .dh-name {
            font-weight: 700;
            font-size: .9rem;
            color: var(--ink);
        }

        .dropdown-header .dh-email {
            font-size: .73rem;
            color: var(--ink-3);
            margin-top: 2px;
        }

        /* DROPDOWN ITEM */
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            text-decoration: none;
            font-size: .845rem;
            font-weight: 600;
            color: var(--ink);
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background .15s;
        }

        .dropdown-item:hover {
            background: var(--bg);
        }

        .dropdown-item .di-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
            background: var(--blue-lt);
        }

        .dropdown-item.danger {
            color: var(--red);
        }

        .dropdown-item.danger .di-icon {
            background: var(--red-lt);
        }

        .dropdown-item.danger:hover {
            background: var(--red-lt);
        }

        .dropdown-divider {
            border-top: 1px solid var(--line);
            margin: 4px 0;
        }

        .nav-auth {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
            align-items: center;
        }

        .btn-ghost-nav {
            padding: 8px 18px;
            border-radius: 999px;
            font-size: .845rem;
            font-weight: 600;
            color: var(--ink-2);
            text-decoration: none;
            border: 1.5px solid var(--line);
            background: transparent;
            transition: all .15s;
        }

        .btn-ghost-nav:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
        }

        .btn-primary-nav {
            padding: 8px 20px;
            border-radius: 999px;
            font-size: .845rem;
            font-weight: 700;
            text-decoration: none;
            background: var(--blue);
            color: white;
            transition: all .2s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary-nav:hover {
            background: var(--blue-dk);
            box-shadow: 0 4px 14px rgba(61, 90, 241, .35);
        }

        /* ═══════════════════════════════════════════
       BADGES
    ═══════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
        }

        .badge-blue {
            background: var(--blue-lt);
            color: var(--blue);
            border: 1px solid var(--blue-md);
        }

        .badge-green {
            background: var(--green-lt);
            color: #009b80;
            border: 1px solid rgba(0, 201, 167, .2);
        }

        .badge-amber {
            background: var(--amber-lt);
            color: #c2862f;
            border: 1px solid rgba(241, 168, 61, .2);
        }

        .badge-red {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid rgba(241, 82, 61, .15);
        }

        .badge-purple {
            background: rgba(168, 85, 247, .1);
            color: var(--purple);
            border: 1px solid rgba(168, 85, 247, .2);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
        }

        .status-pending {
            background: var(--amber-lt);
            color: #c2862f;
        }

        .status-approved {
            background: var(--green-lt);
            color: #009b80;
        }

        .status-rejected {
            background: var(--red-lt);
            color: var(--red);
        }

        /* ═══════════════════════════════════════════
       BUTTONS
    ═══════════════════════════════════════════ */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: .875rem;
            font-weight: 700;
            background: var(--blue);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-primary:hover {
            background: var(--blue-dk);
            box-shadow: 0 4px 16px rgba(61, 90, 241, .35);
            transform: translateY(-1px);
        }

        .btn-primary.btn-block {
            width: 100%;
            justify-content: center;
        }

        .btn-primary.btn-lg {
            padding: 13px 28px;
            font-size: .95rem;
        }

        .btn-primary.btn-sm {
            padding: 6px 14px !important;
            font-size: .78rem !important;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 999px;
            font-size: .875rem;
            font-weight: 600;
            background: rgba(255, 255, 255, .12);
            color: white;
            text-decoration: none;
            border: 1.5px solid rgba(255, 255, 255, .25);
            cursor: pointer;
            transition: all .2s;
            backdrop-filter: blur(4px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, .22);
            border-color: rgba(255, 255, 255, .4);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 999px;
            font-size: .875rem;
            font-weight: 600;
            background: transparent;
            color: var(--blue);
            text-decoration: none;
            border: 1.5px solid var(--blue-md);
            cursor: pointer;
            transition: all .2s;
        }

        .btn-outline:hover {
            background: var(--blue-lt);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: .845rem;
            font-weight: 600;
            background: transparent;
            color: var(--ink-2);
            text-decoration: none;
            border: 1.5px solid var(--line);
            cursor: pointer;
            transition: all .15s;
        }

        .btn-ghost:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
        }

        .btn-ghost.btn-sm,
        .btn-ghost[class*="btn-sm"] {
            padding: 5px 12px !important;
            font-size: .78rem !important;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 20px;
            border-radius: 999px;
            font-size: .875rem;
            font-weight: 700;
            background: var(--red);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-danger:hover {
            background: #d94030;
            box-shadow: 0 4px 12px rgba(241, 82, 61, .35);
        }

        .btn-danger.btn-sm {
            padding: 6px 14px !important;
            font-size: .78rem !important;
        }

        .btn-green {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            border-radius: 999px;
            font-size: .875rem;
            font-weight: 700;
            background: var(--green);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-green:hover {
            background: #00b395;
            box-shadow: 0 4px 12px rgba(0, 201, 167, .3);
        }

        .btn-sm {
            padding: 6px 14px !important;
            font-size: .78rem !important;
            border-radius: 999px !important;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1.5px solid var(--line);
            background: var(--white);
            color: var(--ink-2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s;
        }

        .icon-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-lt);
        }

        /* ═══════════════════════════════════════════
       TAGS
    ═══════════════════════════════════════════ */
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 8px;
            font-size: .75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            border: 1px solid rgba(255, 255, 255, .2);
        }

        .tag-purple {
            background: rgba(168, 85, 247, .2);
            color: #d0a0ff;
            border-color: rgba(168, 85, 247, .3);
        }

        .tag-gold {
            background: rgba(201, 168, 76, .2);
            color: #f0d080;
            border-color: rgba(201, 168, 76, .3);
        }

        /* ═══════════════════════════════════════════
       STATS
    ═══════════════════════════════════════════ */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 20px;
            text-align: center;
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-h);
            transform: translateY(-2px);
        }

        .stat-num {
            font-family: var(--serif);
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--blue);
            line-height: 1;
        }

        .stat-lbl {
            font-size: .75rem;
            color: var(--ink-3);
            margin-top: 5px;
            font-weight: 600;
        }

        /* ═══════════════════════════════════════════
       SECTION HEADERS
    ═══════════════════════════════════════════ */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title {
            font-family: var(--serif);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
        }

        .see-all {
            font-size: .845rem;
            font-weight: 600;
            color: var(--blue);
            text-decoration: none;
        }

        .see-all:hover {
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════
       GENRE PILLS
    ═══════════════════════════════════════════ */
        .genre-scroll {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .genre-pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 16px;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 600;
            background: var(--white);
            color: var(--ink-2);
            border: 1.5px solid var(--line);
            cursor: pointer;
            transition: all .15s;
            user-select: none;
        }

        .genre-pill:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .genre-pill.active {
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        /* ═══════════════════════════════════════════
       NOVEL CARDS
    ═══════════════════════════════════════════ */
        .novel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .novel-card {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
            transition: all .22s;
            display: flex;
            flex-direction: column;
        }

        .novel-card:hover {
            box-shadow: var(--shadow-h);
            transform: translateY(-4px);
            border-color: var(--blue-md);
        }

        .novel-cover {
            width: 100%;
            aspect-ratio: 2/3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .novel-cover img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .novel-cover-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(11, 19, 56, .7) 0%, transparent 60%);
        }

        .novel-info {
            padding: 12px;
            flex: 1;
        }

        .novel-title {
            font-size: .875rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 3px;
            line-height: 1.35;
        }

        .novel-author {
            font-size: .75rem;
            color: var(--ink-3);
            margin-bottom: 3px;
        }

        .novel-genre {
            font-size: .72rem;
            font-weight: 600;
            color: var(--blue);
            margin-bottom: 5px;
        }

        .novel-stars {
            font-size: .75rem;
            color: var(--amber);
        }

        .novel-stars span {
            color: var(--ink-3);
        }

        /* Novel list */
        .novel-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 32px;
        }

        .novel-list-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 14px;
            cursor: pointer;
            transition: all .2s;
        }

        .novel-list-item:hover {
            box-shadow: var(--shadow-h);
            transform: translateX(3px);
            border-color: var(--blue-md);
        }

        .rank-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .9rem;
            color: white;
            flex-shrink: 0;
        }

        .list-cover {
            width: 52px;
            height: 72px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .list-info {
            flex: 1;
            min-width: 0;
        }

        .list-title {
            font-weight: 700;
            font-size: .9rem;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .list-meta {
            font-size: .75rem;
            color: var(--ink-3);
            margin-bottom: 6px;
        }

        .list-tags {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .list-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════
       READING ITEMS
    ═══════════════════════════════════════════ */
        .reading-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 14px;
            transition: all .2s;
        }

        .reading-item:hover {
            box-shadow: var(--shadow);
            border-color: var(--blue-md);
        }

        .reading-cover {
            width: 54px;
            height: 76px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .reading-info {
            flex: 1;
            min-width: 0;
        }

        .reading-title {
            font-weight: 700;
            font-size: .9rem;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .reading-author {
            font-size: .75rem;
            color: var(--ink-3);
        }

        .reading-actions {
            margin-top: 8px;
        }

        .reading-progress-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
        }

        .reading-progress-bar {
            flex: 1;
            height: 4px;
            background: var(--line);
            border-radius: 2px;
            overflow: hidden;
        }

        .reading-progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--blue), var(--purple));
            border-radius: 2px;
        }

        .reading-progress-text {
            font-size: .72rem;
            color: var(--ink-3);
            font-weight: 600;
            flex-shrink: 0;
        }

        .reading-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════
       CHAPTER LIST
    ═══════════════════════════════════════════ */
        .chapter-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .chapter-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 12px 14px;
            transition: all .18s;
            text-decoration: none;
        }

        .chapter-item:hover {
            border-color: var(--blue);
            background: var(--blue-lt);
        }

        .chapter-num {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--blue-lt);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: .78rem;
            flex-shrink: 0;
        }

        .chapter-info {
            flex: 1;
            min-width: 0;
        }

        .chapter-title-text {
            font-size: .875rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .chapter-meta {
            font-size: .73rem;
            color: var(--ink-3);
        }

        .chapter-status {
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════
       TABS
    ═══════════════════════════════════════════ */
        .tabs-row {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid var(--line);
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 10px 18px;
            border: none;
            background: transparent;
            font-size: .875rem;
            font-weight: 600;
            color: var(--ink-3);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all .15s;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: var(--blue);
        }

        .tab-btn.active {
            color: var(--blue);
            border-bottom-color: var(--blue);
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn .2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fav-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
        }

        .fav-tab {
            padding: 9px 20px;
            border-radius: 999px;
            border: 1.5px solid var(--line);
            background: transparent;
            font-size: .845rem;
            font-weight: 600;
            color: var(--ink-2);
            cursor: pointer;
            transition: all .15s;
        }

        .fav-tab:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .fav-tab.active {   
            background: var(--blue);
            color: white;
            border-color: var(--blue);
        }

        /* ═══════════════════════════════════════════
       DETAIL HERO
    ═══════════════════════════════════════════ */
        .detail-hero {
            background: linear-gradient(135deg, #080f2e 0%, #10195e 50%, #080f2e 100%);
            padding: 48px 40px 0;
            position: relative;
            overflow: hidden;
        }

        .detail-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 40%, rgba(61, 90, 241, .2) 0%, transparent 60%);
            pointer-events: none;
        }

        .detail-hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(to bottom, transparent, var(--bg));
        }

        .detail-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 36px;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }

        .detail-cover {
            flex-shrink: 0;
            width: 190px;
            height: 280px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            border: 2px solid rgba(255, 255, 255, .12);
            box-shadow: 0 12px 48px rgba(0, 0, 0, .5);
            position: relative;
            z-index: 1;
            margin-bottom: -40px;
            overflow: hidden;
        }

        .detail-info {
            flex: 1;
            padding-top: 8px;
            position: relative;
            z-index: 1;
        }

        .detail-genre-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .detail-title {
            font-family: var(--serif);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
            line-height: 1.2;
        }

        .detail-author-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .detail-author-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--blue));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .detail-stats-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .detail-stat {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: .82rem;
            color: rgba(255, 255, 255, .7);
        }

        .detail-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding-bottom: 48px;
        }

        .synopsis-text {
            font-family: var(--serif);
            font-size: 1.05rem;
            line-height: 1.85;
            color: var(--ink-2);
            max-width: 720px;
            margin-bottom: 20px;
        }

        /* ═══════════════════════════════════════════
       SEARCH HERO
    ═══════════════════════════════════════════ */
        .search-hero {
            background: linear-gradient(135deg, #0b1338, #1e2f9e);
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        .search-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 60% 50%, rgba(168, 85, 247, .15) 0%, transparent 60%);
            pointer-events: none;
        }

        .search-big-wrap {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, .1);
            border: 1.5px solid rgba(255, 255, 255, .2);
            border-radius: 16px;
            padding: 6px 16px;
            gap: 10px;
            max-width: 680px;
            margin: 0 auto 20px;
            backdrop-filter: blur(8px);
            position: relative;
            z-index: 1;
        }

        .search-big-wrap form {
            flex: 1;
        }

        .search-big-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .search-big {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1.05rem;
            font-weight: 500;
            color: white;
            padding: 8px 0;
        }

        .search-big::placeholder {
            color: rgba(255, 255, 255, .5);
        }

        .filter-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
            z-index: 1;
        }

        .filter-chip {
            padding: 6px 16px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .75);
            border: 1px solid rgba(255, 255, 255, .18);
            cursor: pointer;
            transition: all .15s;
        }

        .filter-chip:hover {
            background: rgba(255, 255, 255, .2);
            color: white;
        }

        .filter-chip.active {
            background: white;
            color: var(--blue);
            border-color: white;
        }

        /* ═══════════════════════════════════════════
       PROFILE
    ═══════════════════════════════════════════ */
        .profile-header {
            background: linear-gradient(135deg, #0b1338, #1e2f9e);
            padding: 28px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }


        .profile-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(61, 90, 241, .3) 0%, transparent 60%);
            pointer-events: none;
        }

        .profile-avatar-wrap {
            position: relative;
            flex-shrink: 0;
            z-index: 1;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--purple));
            border: 3px solid rgba(255, 255, 255, .25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 0 24px rgba(61, 90, 241, .4);
            overflow: hidden;
        }

        .avatar-change-btn {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--blue);
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: .65rem;
        }

        .profile-info {
            flex: 1;
            position: relative;
            z-index: 1;
        }


        .profile-name {
            font-family: var(--serif);
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 3px;
        }


        .profile-email {
            font-size: .8rem;
            color: rgba(255, 255, 255, .6);
            margin-bottom: 10px;
        }


        .profile-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .profile-badge {
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            padding: 3px 10px;
            font-size: .72rem;
            color: rgba(255, 255, 255, .85);
            font-weight: 600;
        }

        .badge-gold {
            color: #fbbf24;
            background: rgba(251, 191, 36, .15);
            border-color: rgba(251, 191, 36, .3);
        }

        .badge-green {
            color: #34d399;
            background: rgba(52, 211, 153, .1);
            border-color: rgba(52, 211, 153, .25);
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-bottom: 2px solid var(--line);
        }

        .profile-stat {
            padding: 22px;
            text-align: center;
            border-right: 1px solid var(--line);
            background: var(--white);
        }

        .profile-stat:last-child {
            border-right: none;
        }

        .profile-stat-num {
            font-family: var(--serif);
            font-size: 1.6rem;
            color: var(--blue);
            font-weight: 700;
        }

        .profile-stat-lbl {
            font-size: .73rem;
            color: var(--ink-3);
            margin-top: 4px;
            font-weight: 600;
        }

        .profile-section {
            padding: 28px 40px;
            max-width: 760px;
            margin: 0 auto;
        }

        .profile-card {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .profile-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--line);
            font-weight: 700;
            font-size: .9rem;
            background: var(--bg);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-card-body {
            padding: 22px;
        }

        .settings-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch-slider {
            position: absolute;
            inset: 0;
            background: var(--line);
            border-radius: 999px;
            cursor: pointer;
            transition: background .25s;
        }

        .switch-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            left: 3px;
            bottom: 3px;
            transition: transform .25s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
        }

        .switch input:checked+.switch-slider {
            background: var(--blue);
        }

        .switch input:checked+.switch-slider::before {
            transform: translateX(20px);
        }

        /* ═══════════════════════════════════════════
       READER
    ═══════════════════════════════════════════ */
        .reader-topbar {
            background: var(--white);
            border-bottom: 1.5px solid var(--line);
            position: sticky;
            top: 64px;
            z-index: 99;
            padding: 12px 40px;
            box-shadow: 0 1px 8px rgba(24, 25, 42, .06);
        }

        .reader-topbar-inner {
            max-width: 700px;
            margin: 0 auto;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .reader-novel-title {
            font-size: .78rem;
            color: var(--ink-3);
            margin-bottom: 2px;
        }

        .reader-chapter-title {
            font-family: var(--serif);
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
        }

        .reader-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .reader-settings-panel {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 24px;
            display: none;
            box-shadow: var(--shadow);
        }

        .reader-settings-panel.open {
            display: block;
        }

        .settings-label {
            font-size: .845rem;
            color: var(--ink-2);
            font-weight: 500;
        }

        .font-size-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .font-size-btn {
            background: var(--bg);
            border: 1.5px solid var(--line);
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--ink);
            font-weight: 700;
            transition: all .15s;
        }

        .font-size-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
        }

        .font-size-val {
            font-size: .845rem;
            color: var(--blue);
            min-width: 36px;
            text-align: center;
            font-weight: 700;
        }

        .theme-btns {
            display: flex;
            gap: 8px;
        }

        .theme-swatch {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            border: 2.5px solid transparent;
            transition: all .2s;
        }

        .theme-swatch.active {
            border-color: var(--blue);
            box-shadow: 0 0 0 2px rgba(61, 90, 241, .2);
        }

        #reader-content {
            font-family: var(--serif);
            font-size: 1.1rem;
            line-height: 2;
            color: var(--ink-2);
            margin-bottom: 40px;
            transition: all .3s;
        }

        #reader-content p {
            margin-bottom: 1.5em;
        }

        .reader-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--white);
            border-top: 1.5px solid var(--line);
            padding: 12px 40px;
            display: flex;
            align-items: center;
            gap: 16px;
            z-index: 99;
            box-shadow: 0 -4px 20px rgba(24, 25, 42, .08);
        }

        .reader-progress {
            flex: 1;
        }

        .progress-label {
            font-size: .73rem;
            color: var(--ink-3);
            margin-bottom: 6px;
            text-align: center;
            font-weight: 500;
        }

        .progress-bar {
            height: 5px;
            background: var(--line);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--blue), var(--purple));
            border-radius: 3px;
            transition: width .3s;
        }

        /* ═══════════════════════════════════════════
       COMMENTS
    ═══════════════════════════════════════════ */
        .comment-box {
            background: var(--bg);
            border: 1.5px solid var(--line);
            border-radius: var(--radius);
            padding: 16px;
            margin-bottom: 20px;
        }

        .comment-input {
            width: 100%;
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: .875rem;
            color: var(--ink);
            resize: vertical;
            min-height: 80px;
            outline: none;
            transition: border .2s;
            margin-bottom: 10px;
        }

        .comment-input:focus {
            border-color: var(--blue);
        }

        .comment-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .comment-item {
            display: flex;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px solid var(--line);
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--purple));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .85rem;
            color: white;
            flex-shrink: 0;
        }

        .comment-body {
            flex: 1;
            min-width: 0;
        }

        .comment-user {
            font-weight: 700;
            font-size: .875rem;
            color: var(--ink);
            margin-bottom: 5px;
        }

        .comment-time {
            font-size: .72rem;
            color: var(--ink-3);
            font-weight: 400;
            margin-left: 8px;
        }

        .comment-text {
            font-size: .875rem;
            color: var(--ink-2);
            line-height: 1.65;
            margin-bottom: 8px;
        }

        .comment-actions-row {
            display: flex;
            gap: 8px;
        }

        .comment-action-btn {
            background: none;
            border: none;
            font-size: .775rem;
            color: var(--ink-3);
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            transition: all .15s;
        }

        .comment-action-btn:hover {
            background: var(--blue-lt);
            color: var(--blue);
        }

        /* ═══════════════════════════════════════════
       FORMS
    ═══════════════════════════════════════════ */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: .845rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: .875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border .2s, box-shadow .2s;
        }

        .form-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .form-textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: .875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            resize: vertical;
            min-height: 90px;
            transition: border .2s, box-shadow .2s;
        }

        .form-textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .form-select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: .875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%239698ae' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            transition: border .2s;
        }

        .form-select:focus {
            border-color: var(--blue);
        }

        .form-error {
            font-size: .75rem;
            color: var(--red);
            margin-top: 5px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .alert-success {
            background: var(--green-lt);
            color: #007f6b;
            border: 1px solid rgba(0, 201, 167, .2);
        }

        .alert-error {
            background: var(--red-lt);
            color: var(--red);
            border: 1px solid rgba(241, 82, 61, .2);
        }

        /* ═══════════════════════════════════════════
       MODAL
    ═══════════════════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(24, 25, 42, .55);
            backdrop-filter: blur(5px);
            z-index: 9998;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: 0 24px 80px rgba(24, 25, 42, .22);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            animation: modalIn .22s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid var(--line);
            background: var(--bg);
        }

        .modal-title {
            font-weight: 700;
            font-size: .95rem;
            color: var(--ink);
        }

        .modal-close {
            background: var(--line);
            border: none;
            cursor: pointer;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            color: var(--ink-2);
            transition: all .15s;
        }

        .modal-close:hover {
            background: var(--red-lt);
            color: var(--red);
        }

        .modal-body {
            padding: 22px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            padding: 14px 20px;
            border-top: 1px solid var(--line);
            background: var(--bg);
        }

        /* ═══════════════════════════════════════════
       TOAST
    ═══════════════════════════════════════════ */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            border-radius: 14px;
            background: var(--ink);
            color: white;
            font-size: .845rem;
            font-weight: 500;
            box-shadow: 0 8px 32px rgba(24, 25, 42, .25);
            max-width: 320px;
            pointer-events: auto;
            animation: toastIn .25s ease;
        }

        .toast.success {
            background: #009b80;
        }

        .toast.error {
            background: #d94030;
        }

        .toast.info {
            background: var(--blue);
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(20px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        /* ═══════════════════════════════════════════
       UTILITIES
    ═══════════════════════════════════════════ */
        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .flex-col {
            flex-direction: column;
        }

        .gap-6 {
            gap: 6px;
        }

        .gap-8 {
            gap: 8px;
        }

        .gap-10 {
            gap: 10px;
        }

        .gap-12 {
            gap: 12px;
        }

        .gap-16 {
            gap: 16px;
        }

        .mt-4 {
            margin-top: 4px;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        .mt-16 {
            margin-top: 16px;
        }

        .mt-24 {
            margin-top: 24px;
        }

        .mt-32 {
            margin-top: 32px;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-16 {
            margin-bottom: 16px;
        }

        .mb-24 {
            margin-bottom: 24px;
        }

        .mb-32 {
            margin-bottom: 32px;
        }

        .text-sm {
            font-size: .845rem;
        }

        .text-xs {
            font-size: .73rem;
        }

        .text-muted {
            color: var(--ink-3);
        }

        .text-soft {
            color: var(--ink-2);
        }

        .font-700 {
            font-weight: 700;
        }

        .font-600 {
            font-weight: 600;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--line);
            margin: 16px 0;
        }

        /* Footer */
        .footer {
            background: var(--white);
            border-top: 1.5px solid var(--line);
            padding: 20px 40px;
            text-align: center;
            font-size: .78rem;
            color: var(--ink-3);
        }

        .footer a {
            color: var(--blue);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════ */
        @media (max-width: 900px) {
            .nav-inner {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 48px;
                height: 72px;

                display: flex;
                align-items: center;
            }

            .stats-strip {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-banner {
                padding: 40px 16px;
            }

            .hero-title {
                font-size: 1.9rem;
            }

            .detail-inner {
                flex-direction: column;
            }

            .detail-cover {
                width: 140px;
                height: 210px;
                margin-bottom: -24px;
            }

            .profile-section {
                padding: 20px 16px;
            }

            .profile-header {
                padding: 32px 16px;
            }

            .reader-topbar {
                padding: 10px 16px;
            }

            .reader-nav {
                padding: 12px 16px;
            }

            .search-hero {
                padding: 32px 16px;
            }

            .footer {
                padding: 16px;
            }

            .content-wrap {
                padding: 20px 16px;
            }

            .nav-link span {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .novel-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            }

            .detail-hero {
                padding: 28px 16px 0;
            }

            .detail-title {
                font-size: 1.5rem;
            }

            /* search */
        }

        .filter-chip {
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #ddd;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.25s ease;
            border: 1px solid transparent;
        }

        .filter-chip:hover {
            background: rgba(61, 90, 241, 0.2);
            color: #fff;
            border: 1px solid #3d5af1;
            transform: translateY(-2px);
        }

        .filter-chip.active {
            background: linear-gradient(135deg, #3d5af1, #1e2f9e);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(61, 90, 241, 0.4);
        }

        .filter-chip .dot {
            width: 6px;
            height: 6px;
            background: #3d5af1;
            border-radius: 50%;
        }

        /* card novel pencarian */
        .novel-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.25s ease;
            border: 1px solid #eef2f7;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
        }

        .novel-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .novel-info {
            padding: 14px;
        }

        .novel-cover-overlay {
            pointer-events: none;
        }

        /* GENRE */
        .genre-pill {
            background: #f1f5ff;
            color: #3b5bdb;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* JUDUL */
        .novel-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 8px;
            line-height: 1.4;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* AUTHOR */
        .novel-author {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 4px;
        }

        /* RATING */
        .novel-rating {
            margin-top: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            color: #f59e0b;
        }

        .novel-rating .star {
            font-size: 14px;
        }

        .no-underline {
            text-decoration: none !important;
            color: inherit;
        }

        .no-underline:hover {
            text-decoration: none;
            color: inherit;
        }

        <style>
        /* ── PROFILE PAGE STYLES ── */

        .pf-wrap {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px 32px 40px;
        }

        /* HERO BAR */
        .pf-hero {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-xs);
        }

        .pf-av-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .pf-av {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--purple));
            border: 3px solid var(--blue-lt);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            overflow: hidden;
            flex-shrink: 0;
        }

        .pf-av-btn {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--blue);
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: .6rem;
            transition: background .15s;
        }

        .pf-av-btn:hover {
            background: var(--blue-dk);
        }

        .pf-info {
            flex: 1;
        }

        .pf-name {
            font-family: var(--serif);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .pf-email {
            font-size: .775rem;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .pf-badges {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .pf-badge {
            font-size: .7rem;
            font-weight: 700;
            padding: 2px 9px;
            border-radius: 999px;
            border: 1px solid;
        }

        .pf-badge-blue {
            background: var(--blue-lt);
            color: var(--blue);
            border-color: var(--blue-md);
        }

        .pf-badge-gold {
            background: var(--amber-lt);
            color: #c2862f;
            border-color: rgba(241, 168, 61, .25);
        }

        .pf-badge-green {
            background: var(--green-lt);
            color: #009b80;
            border-color: rgba(0, 201, 167, .25);
        }

        /* WRITER BANNER inside hero */
        .pf-writer-box {
            background: var(--blue-lt);
            border: 1.5px solid var(--blue-md);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-shrink: 0;
            min-width: 200px;
        }

        .pf-writer-title {
            font-size: .78rem;
            font-weight: 700;
            color: var(--blue);
        }

        .pf-writer-sub {
            font-size: .7rem;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .pf-writer-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 13px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
            background: var(--blue);
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: background .15s;
            flex-shrink: 0;
        }

        .pf-writer-btn:hover {
            background: var(--blue-dk);
        }

        /* MAIN GRID 2-COL */
        .pf-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .pf-grid-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* CARD */
        .pf-card {
            background: var(--white);
            border: 1.5px solid var(--line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xs);
        }

        .pf-card-head {
            padding: 11px 18px;
            border-bottom: 1px solid var(--line);
            font-size: .845rem;
            font-weight: 700;
            color: var(--ink);
            background: var(--bg);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .pf-card-body {
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* FORM ELEMENTS */
        .pf-row2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .pf-row3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .pf-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .pf-lbl {
            font-size: .775rem;
            font-weight: 700;
            color: var(--ink-2);
        }

        .pf-input {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: .845rem;
            color: var(--ink);
            background: var(--white);
            font-family: var(--font);
            outline: none;
            transition: border .2s, box-shadow .2s;
        }

        .pf-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .pf-textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-size: .845rem;
            color: var(--ink);
            background: var(--white);
            font-family: var(--font);
            outline: none;
            resize: none;
            height: 70px;
            transition: border .2s, box-shadow .2s;
        }

        .pf-textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(61, 90, 241, .1);
        }

        .pf-form-error {
            font-size: .72rem;
            color: var(--red);
            margin-top: 2px;
        }

        .pf-row-end {
            display: flex;
            justify-content: flex-end;
        }

        .pf-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 700;
            background: var(--blue);
            color: white;
            border: none;
            cursor: pointer;
            font-family: var(--font);
            transition: all .2s;
        }

        .pf-btn:hover {
            background: var(--blue-dk);
            box-shadow: 0 4px 14px rgba(61, 90, 241, .3);
            transform: translateY(-1px);
        }

        .pf-btn-danger {
            background: transparent;
            color: var(--red);
            border: 1.5px solid rgba(241, 82, 61, .3);
            padding: 7px 16px;
        }

        .pf-btn-danger:hover {
            background: var(--red-lt);
            border-color: var(--red);
            box-shadow: none;
            transform: none;
        }

        /* SWITCH TOGGLE */
        .pf-sw-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid var(--line);
        }

        .pf-sw-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .pf-sw-row:first-child {
            padding-top: 0;
        }

        .pf-sw-lbl {
            font-size: .845rem;
            font-weight: 600;
            color: var(--ink);
        }

        .pf-sw-sub {
            font-size: .72rem;
            color: var(--ink-3);
            margin-top: 2px;
        }

        .pf-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }

        .pf-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .pf-slider {
            position: absolute;
            inset: 0;
            background: var(--line);
            border-radius: 999px;
            cursor: pointer;
            transition: background .2s;
        }

        .pf-slider::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            top: 3px;
            left: 3px;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }

        .pf-switch input:checked+.pf-slider {
            background: var(--blue);
        }

        .pf-switch input:checked+.pf-slider::after {
            transform: translateX(18px);
        }

        /* DANGER CARD */
        .pf-card-danger {
            border-color: rgba(241, 82, 61, .25);
        }

        .pf-card-danger .pf-card-head {
            color: var(--red);
            background: var(--red-lt);
            border-bottom-color: rgba(241, 82, 61, .15);
        }

        .pf-danger-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .pf-danger-title {
            font-size: .875rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .pf-danger-sub {
            font-size: .75rem;
            color: var(--ink-3);
        }

        /* PREF CARD fills remaining height */
        .pf-card-pref {
            height: 100%;
        }
    </style>

    @yield('extra-css')
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="nav-inner">

            {{-- LEFT: LOGO --}}
            <a href="{{ route('home') }}" class="nav-logo">
                ✦ <span>Novela</span>
            </a>

            {{-- CENTER: MENU --}}
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    </svg>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('search') }}" class="nav-link {{ request()->routeIs('search') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.35-4.35" />
                    </svg>
                    <span>Jelajahi</span>
                </a>

                <a href="{{ route('genres') }}" class="nav-link {{ request()->routeIs('genres') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>Genre</span>
                </a>

                @auth
                    <a href="{{ route('history') }}" class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                        <span>Riwayat</span>
                    </a>

                    <a href="{{ route('favorites') }}"
                        class="nav-link {{ request()->routeIs('favorites') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span>Favorit</span>
                    </a>
                @endauth
            </div>

            {{-- RIGHT: USER / AUTH --}}
            <div class="nav-right">
                @auth
                    <div class="nav-user-menu">
                        <div class="nav-avatar" onclick="toggleDropdown()">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>

                        <div class="user-dropdown" id="user-dropdown">
                            <div class="dropdown-header">
                                <div class="dh-name">{{ Auth::user()->name }}</div>
                                <div class="dh-email">{{ Auth::user()->email }}</div>
                                <span class="badge badge-blue" style="margin-top:8px">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>

                            {{-- PROFIL --}}
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">👤 Profil Saya</a>
                            @elseif (Auth::user()->role === 'author')
                                <a href="{{ route('author.profile.index') }}" class="dropdown-item">👤 Profil Saya</a>
                            @else
                                <a href="{{ route('reader.profile.index') }}" class="dropdown-item">👤 Profil Saya</a>
                            @endif

                            {{-- ROLE EXTRA --}}
                            @if (Auth::user()->role === 'reader')
                                <a href="{{ route('reader.author-request') }}" class="dropdown-item">✍️ Jadi Penulis</a>
                            @endif

                            @if (Auth::user()->role === 'author')
                                <a href="{{ route('author.dashboard') }}" class="dropdown-item">📊 Dashboard Penulis</a>
                            @endif

                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">🛡️ Dashboard Admin</a>
                            @endif

                            <div class="dropdown-divider"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    🚪 Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="nav-auth">
                        <a href="{{ route('login') }}" class="btn-ghost-nav">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary-nav">Daftar</a>
                    </div>
                @endauth
            </div>

        </div>
    </nav>

    {{-- FLASH MESSAGES --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast('success', 'Berhasil', @json(session('success'))));
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast('error', 'Error', @json(session('error'))));
        </script>
    @endif
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast('info', 'Perhatian', @json(session('warning'))));
        </script>
    @endif

    {{-- CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer class="footer">
        ✦ <strong>Novela</strong> — Read Anywhere, Dream Everywhere &nbsp;·&nbsp;
        <a href="#">Syarat</a> &nbsp;·&nbsp; <a href="#">Privasi</a> &nbsp;·&nbsp; <a
            href="#">Bantuan</a>
        &nbsp;·&nbsp; © {{ date('Y') }} Novela
    </footer>

    {{-- REPORT MODAL --}}
    <div class="modal-overlay" id="report-modal" onclick="if(event.target===this)closeModal('report-modal')">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title">🚩 Laporkan Konten</span>
                <button class="modal-close" onclick="closeModal('report-modal')">✕</button>
            </div>
            <div class="modal-body">
                <form action="/report" method="POST" id="report-form">
                    @csrf
                    <input type="hidden" name="novel_id" id="report-novel-id" />
                    <div class="form-group">
                        <label class="form-label">Alasan Laporan</label>
                        <select class="form-select" name="alasan">
                            <option value="">-- Pilih alasan --</option>
                            <option value="plagiarisme">Plagiarisme</option>
                            <option value="konten_dewasa">Konten Dewasa</option>
                            <option value="ujaran_kebencian">Ujaran Kebencian</option>
                            <option value="spam">Spam</option>
                            <option value="kekerasan">Kekerasan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-textarea" name="description" placeholder="Jelaskan lebih detail..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-ghost" onclick="closeModal('report-modal')">Batal</button>
                <button class="btn-danger" onclick="submitReport()">Kirim Laporan</button>
            </div>
        </div>
    </div>

    {{-- TOAST CONTAINER --}}
    <div id="toast-container" class="toast-container"></div>

    <script>
        /* DROPDOWN */
        function toggleDropdown() {
            document.getElementById('user-dropdown')?.classList.toggle('open');
        }
        document.addEventListener('click', e => {
            const m = document.querySelector('.nav-user-menu');
            if (m && !m.contains(e.target)) document.getElementById('user-dropdown')?.classList.remove('open');
        });

        /* MODAL */
        function openModal(id) {
            document.getElementById(id)?.classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.remove('open');
        }

        /* TOAST */
        function showToast(type = 'info', title = '', msg = '') {
            const c = document.getElementById('toast-container');
            const t = document.createElement('div');
            t.className = `toast ${type}`;
            t.innerHTML = `<span>${title?'<strong>'+title+'</strong>'+(msg?' · '+msg:''):msg}</span>`;
            c.appendChild(t);
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transform = 'translateX(20px)';
                t.style.transition = 'all .3s';
                setTimeout(() => t.remove(), 300);
            }, 3500);
        }

        /* TABS */
        function switchTab(btn, tabId) {
            const row = btn.closest('.tabs-row') || document;
            row.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const wrap = btn.closest('.content-wrap') || document;
            wrap.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            document.getElementById(tabId)?.classList.add('active');
        }

        function switchFavTab(btn, tabId) {
            document.querySelectorAll('.fav-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            ['fav-novels', 'fav-chapters'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = (id === tabId) ? 'block' : 'none';
            });
        }

        /* GENRE / FILTER */
        function toggleGenre(el) {
            el.closest('.genre-scroll').querySelectorAll('.genre-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
        }

        function toggleFilter(el) {
            el.closest('.filter-row').querySelectorAll('.filter-chip').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
        }

        /* FAVORITE */
        function toggleFav(btn) {
            const svg = btn.querySelector('svg');
            const on = svg?.getAttribute('fill') === 'currentColor';
            if (!on) {
                svg?.setAttribute('fill', 'currentColor');
                showToast('success', 'Favorit', 'Novel ditambahkan ke favorit!');
            } else {
                svg?.setAttribute('fill', 'none');
                showToast('info', 'Favorit', 'Novel dihapus dari favorit');
            }
        }

        /* COMMENT */
        function likeComment(btn) {
            const span = btn.querySelector('span');
            if (!span) return;
            span.textContent = parseInt(span.textContent || 0) + 1;
            btn.style.color = 'var(--blue)';
        }

        /* REPORT */
        function submitReport() {
            closeModal('report-modal');
            showToast('success', 'Laporan', 'Laporan berhasil dikirim, terima kasih!');
        }

        /* READER SETTINGS */
        function toggleSettings() {
            document.getElementById('settings-panel')?.classList.toggle('open');
        }
        let fs = 18;

        function changeFontSize(d) {
            fs = Math.min(26, Math.max(14, fs + d));
            const disp = document.getElementById('font-size-display');
            const cont = document.getElementById('reader-content');
            if (disp) disp.textContent = fs + 'px';
            if (cont) cont.style.fontSize = fs + 'px';
        }

        function setReadTheme(theme, el) {
            el.closest('.theme-btns').querySelectorAll('.theme-swatch').forEach(s => s.classList.remove('active'));
            el.classList.add('active');
            const themes = {
                dark: {
                    bg: '#04071a',
                    color: '#a8b4d8'
                },
                midnight: {
                    bg: '#1a1a2e',
                    color: '#c8d0ef'
                },
                cream: {
                    bg: '#fdf9f5',
                    color: '#2a1f0f'
                },
                white: {
                    bg: '#ffffff',
                    color: '#18192a'
                }
            };
            const t = themes[theme];
            const rc = document.getElementById('reader-content');
            if (rc && t) {
                rc.style.background = t.bg;
                rc.style.color = t.color;
            }
        }

        function prevChapter() {
            showToast('info', 'Chapter', 'Navigasi ke chapter sebelumnya');
        }

        function nextChapter() {
            showToast('success', 'Chapter', 'Navigasi ke chapter selanjutnya');
        }
    </script>

    @yield('extra-js')
</body>

</html>
