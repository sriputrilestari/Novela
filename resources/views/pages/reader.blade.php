@extends('layouts.app')
@section('title', 'Ch.' . $chapter->urutan . ' – ' . $chapter->novel->judul)

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@300;400;500&family=Cinzel:wght@500;600&display=swap');

        :root {
            --rd-bg: #0b0f14;
            --rd-surface: #121821;
            --rd-surface2: #1a2330;
            --rd-border: rgba(255, 255, 255, 0.08);
            --rd-border2: rgba(255, 255, 255, 0.15);
            --rd-text: #e6edf3;
            --rd-text-muted: #9aa4af;
            --rd-text-faint: #6b7280;
            --rd-white: #e6edf3;
            --rd-accent: #58a6ff;
            --rd-accent2: #bc8cff;
            --rd-gold: #d4a853;
            --rd-radius: 10px;
        }

        .rd-topbar {
            position: sticky;
            top: 64px;
            z-index: 90;
            background: rgba(13, 17, 23, .88);
            backdrop-filter: blur(20px) saturate(1.4);
            -webkit-backdrop-filter: blur(20px) saturate(1.4);
            border-bottom: 1px solid var(--rd-border);
        }

        .rd-topbar-inner {
            max-width: 760px;
            margin: 0 auto;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .rd-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border2);
            border-radius: 999px;
            color: var(--rd-text);
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .rd-back-btn:hover {
            background: var(--rd-surface2);
            border-color: var(--rd-accent);
            color: var(--rd-accent);
            transform: translateX(-2px);
        }

        .rd-back-btn svg {
            transition: transform .2s;
        }

        .rd-back-btn:hover svg {
            transform: translateX(-2px);
        }

        .rd-topbar-title {
            flex: 1;
            min-width: 0;
        }

        .rd-topbar-novel {
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            color: var(--rd-text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rd-topbar-chapter {
            font-family: 'Cinzel', serif;
            font-size: .88rem;
            font-weight: 500;
            color: var(--rd-white);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }

        /* Progress bar */
        .rd-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background: linear-gradient(90deg, var(--rd-accent), var(--rd-accent2));
            z-index: 9999;
            transition: width .1s;
            border-radius: 0 2px 2px 0;
        }

        /* Main wrap */
        .rd-wrap {
            max-width: 680px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Chapter header */
        .rd-chapter-header {
            text-align: center;
            padding: 56px 0 48px;
            border-bottom: 1px solid var(--rd-border);
            margin-bottom: 48px;
        }

        .rd-chapter-label {
            display: inline-block;
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--rd-accent);
            background: rgba(88, 166, 255, .1);
            border: 1px solid rgba(88, 166, 255, .2);
            padding: 4px 14px;
            border-radius: 999px;
            margin-bottom: 20px;
        }

        .rd-chapter-title {
            font-family: 'Cinzel', serif;
            font-size: 1.55rem;
            font-weight: 600;
            color: var(--rd-white);
            line-height: 1.4;
            letter-spacing: .02em;
        }

        /* Content */
        #reader-content {
            font-family: 'Lora', serif;
            font-size: 18px;
            line-height: 1.95;
            color: var(--rd-text);
            word-break: break-word;
            overflow-wrap: break-word;
            transition: font-size .2s, color .2s;
        }

        #reader-content p {
            margin: 0 0 1.6em;
            text-indent: 1.8em;
        }

        #reader-content p:first-child {
            text-indent: 0;
        }

        #reader-content p:first-child::first-letter {
            font-size: 3.2em;
            font-weight: 600;
            color: var(--rd-white);
            float: left;
            line-height: .82;
            margin: .06em .1em 0 0;
            font-family: 'Cinzel', serif;
        }

        /* End of chapter */
        .rd-chapter-end {
            text-align: center;
            padding: 56px 0 48px;
            margin-top: 48px;
            border-top: 1px solid var(--rd-border);
        }

        .rd-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .rd-ornament-line {
            width: 48px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--rd-border2));
        }

        .rd-ornament-line.right {
            background: linear-gradient(90deg, var(--rd-border2), transparent);
        }

        .rd-ornament span {
            font-size: .85rem;
            color: var(--rd-text-muted);
            letter-spacing: .25em;
        }

        .rd-end-label {
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            color: var(--rd-text-muted);
            margin-bottom: 28px;
            letter-spacing: .05em;
        }

        .rd-next-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 28px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--rd-accent), var(--rd-accent2));
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .25s;
            box-shadow: 0 0 0 0 rgba(88, 166, 255, .3);
        }

        .rd-next-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(88, 166, 255, .25);
        }

        .rd-finished-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 1px solid var(--rd-border2);
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem;
            color: var(--rd-gold);
            background: rgba(212, 168, 83, .06);
        }

        /* Comments section */
        .rd-comments {
            padding: 48px 0;
            border-top: 1px solid var(--rd-border);
        }

        .rd-comments-title {
            font-family: 'Cinzel', serif;
            font-size: 1rem;
            font-weight: 500;
            color: var(--rd-white);
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rd-comments-title .count {
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            font-weight: 400;
            color: var(--rd-text-muted);
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            padding: 2px 10px;
            border-radius: 999px;
        }

        /* Comment form */
        .rd-comment-form {
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 32px;
            transition: border-color .2s;
        }

        .rd-comment-form:focus-within {
            border-color: var(--rd-border2);
        }

        .rd-comment-textarea {
            width: 100%;
            box-sizing: border-box;
            min-height: 80px;
            resize: vertical;
            background: transparent;
            border: none;
            outline: none;
            color: var(--rd-text);
            font-size: .9rem;
            font-family: 'DM Sans', sans-serif;
            line-height: 1.6;
            margin-bottom: 12px;
            display: block;
        }

        .rd-comment-textarea::placeholder {
            color: var(--rd-text-faint);
        }

        .rd-comment-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rd-char-count {
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            color: var(--rd-text-faint);
        }

        .rd-submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 18px;
            background: var(--rd-accent);
            color: #0d1117;
            border: none;
            border-radius: 999px;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }

        .rd-submit-btn:hover {
            background: #79b8ff;
            transform: translateY(-1px);
        }

        /* Comment item */
        .rd-comment {
            display: flex;
            gap: 13px;
            margin-bottom: 28px;
        }

        .rd-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rd-accent), var(--rd-accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: .82rem;
            color: #0d1117;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .rd-avatar.sm {
            width: 28px;
            height: 28px;
            font-size: .72rem;
            background: linear-gradient(135deg, var(--rd-surface2), var(--rd-surface));
            border: 1px solid var(--rd-border2);
            color: var(--rd-text);
        }

        .rd-comment-body {
            flex: 1;
            min-width: 0;
        }

        .rd-comment-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
            flex-wrap: wrap;
        }

        .rd-comment-name {
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            font-weight: 500;
            color: var(--rd-white);
        }

        .rd-author-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: .68rem;
            font-weight: 500;
            color: var(--rd-gold);
            background: rgba(212, 168, 83, .12);
            border: 1px solid rgba(212, 168, 83, .2);
            padding: 1px 8px;
            border-radius: 999px;
            letter-spacing: .03em;
        }

        .rd-comment-time {
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            color: var(--rd-text-muted);
        }

        .rd-comment-text {
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--rd-text);
            line-height: 1.65;
            word-break: break-word;
            margin-bottom: 10px;
        }

        /* Comment actions */
        .rd-comment-actions {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rd-like-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border: 1px solid var(--rd-border);
            border-radius: 999px;
            background: transparent;
            color: var(--rd-text-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            cursor: pointer;
            transition: all .2s;
        }

        .rd-like-btn:hover,
        .rd-like-btn.liked {
            border-color: rgba(88, 166, 255, .4);
            background: rgba(88, 166, 255, .08);
            color: var(--rd-accent);
        }

        .rd-like-btn.liked svg {
            fill: var(--rd-accent);
        }

        .rd-reply-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border: none;
            border-radius: 999px;
            background: transparent;
            color: var(--rd-text-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            cursor: pointer;
            transition: all .2s;
        }

        .rd-reply-btn:hover {
            color: var(--rd-text);
        }

        /* Reply form */
        .rd-reply-form {
            display: none;
            margin-top: 12px;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            border-radius: 10px;
            padding: 12px 14px;
        }

        .rd-reply-form.open {
            display: block;
        }

        .rd-reply-input {
            width: 100%;
            box-sizing: border-box;
            background: transparent;
            border: none;
            outline: none;
            color: var(--rd-text);
            font-size: .85rem;
            font-family: 'DM Sans', sans-serif;
            line-height: 1.6;
            resize: none;
            min-height: 60px;
            display: block;
            margin-bottom: 10px;
        }

        .rd-reply-input::placeholder {
            color: var(--rd-text-faint);
        }

        .rd-reply-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .rd-cancel-btn {
            padding: 5px 14px;
            border: 1px solid var(--rd-border);
            border-radius: 999px;
            background: transparent;
            color: var(--rd-text-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .78rem;
            cursor: pointer;
            transition: all .2s;
        }

        .rd-cancel-btn:hover {
            color: var(--rd-text);
            border-color: var(--rd-border2);
        }

        /* Replies */
        .rd-replies {
            margin-top: 14px;
            padding-left: 16px;
            border-left: 2px solid var(--rd-border);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .rd-reply {
            display: flex;
            gap: 10px;
        }

        /* Empty state */
        .rd-empty {
            text-align: center;
            padding: 48px 0 24px;
        }

        .rd-empty-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--rd-surface);
            border: 1px solid var(--rd-border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 1.2rem;
        }

        .rd-empty p {
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            color: var(--rd-text-muted);
            margin: 0;
        }

        /* Login prompt */
        .rd-login-prompt {
            background: var(--rd-surface);
            border: 1px dashed var(--rd-border2);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 28px;
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            color: var(--rd-text-muted);
        }

        .rd-login-prompt a {
            color: var(--rd-accent);
            text-decoration: none;
        }

        .rd-login-prompt a:hover {
            text-decoration: underline;
        }

        /* Divider */
        .rd-divider {
            height: 1px;
            background: var(--rd-border);
            margin: 0;
        }
    </style>
@endpush

@section('content')

    {{-- Reading progress bar --}}
    <div class="rd-progress-bar" id="progress-fill"></div>

    {{-- ═══ TOPBAR ═══ --}}
    <div class="rd-topbar">
        <div class="rd-topbar-inner">
            <a href="{{ route('novel.show', $chapter->novel->id) }}" class="rd-back-btn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M9 2L4 7L9 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Kembali
            </a>
            <div class="rd-topbar-title">
                <div class="rd-topbar-novel">{{ $chapter->novel->judul }}</div>
                <div class="rd-topbar-chapter">Chapter {{ $chapter->urutan }}: {{ $chapter->judul_chapter }}</div>
            </div>
        </div>
    </div>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div class="rd-wrap">

        {{-- Chapter Header --}}
        <div class="rd-chapter-header">
            <div class="rd-chapter-label">Chapter {{ $chapter->urutan }}</div>
            <h1 class="rd-chapter-title">{{ $chapter->judul_chapter }}</h1>
        </div>

        {{-- Chapter Content --}}
        <div id="reader-content">
            @php
                $paragraphs = array_filter(preg_split('/\n{2,}/', trim($chapter->isi)), fn($p) => trim($p) !== '');
            @endphp

            @foreach ($paragraphs as $paragraph)
                <p>{{ trim($paragraph) }}</p>
            @endforeach
        </div>

        {{-- ═══ END OF CHAPTER ═══ --}}
        <div class="rd-chapter-end">
            <div class="rd-ornament">
                <div class="rd-ornament-line"></div>
                <span>✦</span>
                <div class="rd-ornament-line right"></div>
            </div>
            <div class="rd-end-label">Akhir Chapter {{ $chapter->urutan }}</div>

            @if ($nextChapter)
                <a href="{{ route('chapter.show', $nextChapter->id) }}" class="rd-next-btn">
                    Lanjut Chapter {{ $nextChapter->urutan }}
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
            @else
                <div class="rd-finished-badge">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M2 7.5L6 11.5L13 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    Semua chapter sudah dibaca!
                </div>
            @endif
        </div>

        {{-- ═══ KOMENTAR ═══ --}}
        <div class="rd-comments">
            <div class="rd-comments-title">
                Komentar
                <span class="count">{{ $comments->count() }}</span>
            </div>

            @auth
                <div class="rd-comment-form">
                    <form method="POST" action="/comment" id="comment-form">
                        @csrf
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}" />
                        <textarea name="komentar" class="rd-comment-textarea" placeholder="Tulis komentarmu..." required maxlength="500"
                            id="comment-input" oninput="updateCharCount(this)"></textarea>
                        <div class="rd-comment-footer">
                            <span class="rd-char-count" id="char-count">0 / 500</span>
                            <button type="submit" class="rd-submit-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <path d="M1 6.5H12M12 6.5L7 1.5M12 6.5L7 11.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="rd-login-prompt">
                    <a href="{{ route('login') }}">Masuk</a> untuk meninggalkan komentar.
                </div>
            @endauth

            {{-- Daftar komentar --}}
            @forelse($comments as $comment)
                <div class="rd-comment" id="comment-{{ $comment->id }}">
                    <div class="rd-avatar">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                    <div class="rd-comment-body">
                        <div class="rd-comment-meta">
                            <span class="rd-comment-name">{{ $comment->user->name }}</span>
                            @if ($comment->user->role === 'author')
                                <span class="rd-author-badge">Author</span>
                            @endif
                            <span class="rd-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="rd-comment-text">{{ $comment->komentar }}</div>
                        <div class="rd-comment-actions">
                            {{-- Like button --}}
                            @auth
                                <form method="POST" action="{{ route('comment.like', $comment->id) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="rd-like-btn">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                            <path
                                                d="M6.5 11.5C6.5 11.5 1 8.2 1 4.5C1 2.8 2.3 1.5 4 1.5C5 1.5 5.9 2 6.5 2.8C7.1 2 8 1.5 9 1.5C10.7 1.5 12 2.8 12 4.5C12 8.2 6.5 11.5 6.5 11.5Z"
                                                stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        {{ $comment->likes_count ?? 0 }}
                                    </button>
                                </form>
                            @else
                                <span class="rd-like-btn" style="cursor:default">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path
                                            d="M6.5 11.5C6.5 11.5 1 8.2 1 4.5C1 2.8 2.3 1.5 4 1.5C5 1.5 5.9 2 6.5 2.8C7.1 2 8 1.5 9 1.5C10.7 1.5 12 2.8 12 4.5C12 8.2 6.5 11.5 6.5 11.5Z"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    {{ $comment->likes_count ?? 0 }}
                                </span>
                            @endauth

                            {{-- Reply button --}}
                            @auth
                                <button class="rd-reply-btn" onclick="toggleReplyForm({{ $comment->id }})">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path
                                            d="M11.5 8C11.5 9 10.7 9.8 9.7 9.8H4.5L1.5 12V3.8C1.5 2.8 2.3 2 3.3 2H9.7C10.7 2 11.5 2.8 11.5 3.8V8Z"
                                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    Balas
                                </button>
                            @endauth
                        </div>

                        {{-- Reply form --}}
                        @auth
                            <div class="rd-reply-form" id="reply-form-{{ $comment->id }}">
                                <form method="POST" action="/reply">
                                    @csrf
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                                    <textarea name="komentar" class="rd-reply-input" placeholder="Tulis balasan..."></textarea>
                                    <div class="rd-reply-actions">
                                        <button type="button" class="rd-cancel-btn"
                                            onclick="toggleReplyForm({{ $comment->id }})">Batal</button>
                                        <button type="submit" class="rd-submit-btn"
                                            style="font-size:.76rem;padding:5px 14px">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        @endauth

                        {{-- Replies --}}
                        @if ($comment->visibleReplies->isNotEmpty())
                            <div class="rd-replies">
                                @foreach ($comment->visibleReplies as $reply)
                                    <div class="rd-reply">
                                        <div class="rd-avatar sm">{{ strtoupper(substr($reply->user->name, 0, 1)) }}</div>
                                        <div class="rd-comment-body">
                                            <div class="rd-comment-meta">
                                                <span class="rd-comment-name"
                                                    style="font-size:.84rem">{{ $reply->user->name }}</span>
                                                @if ($reply->user->role === 'author')
                                                    <span class="rd-author-badge">Author</span>
                                                @endif
                                                <span
                                                    class="rd-comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="rd-comment-text" style="font-size:.87rem">{{ $reply->komentar }}
                                            </div>
                                            {{-- Like for reply --}}
                                            <div class="rd-comment-actions">
                                                @auth
                                                    <form method="POST" action="{{ route('reply.like', $reply->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        <button type="submit" class="rd-like-btn">
                                                            <svg width="12" height="12" viewBox="0 0 13 13"
                                                                fill="none">
                                                                <path
                                                                    d="M6.5 11.5C6.5 11.5 1 8.2 1 4.5C1 2.8 2.3 1.5 4 1.5C5 1.5 5.9 2 6.5 2.8C7.1 2 8 1.5 9 1.5C10.7 1.5 12 2.8 12 4.5C12 8.2 6.5 11.5 6.5 11.5Z"
                                                                    stroke="currentColor" stroke-width="1.2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            {{ $reply->likes_count ?? 0 }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="rd-like-btn" style="cursor:default;font-size:.72rem">
                                                        <svg width="12" height="12" viewBox="0 0 13 13"
                                                            fill="none">
                                                            <path
                                                                d="M6.5 11.5C6.5 11.5 1 8.2 1 4.5C1 2.8 2.3 1.5 4 1.5C5 1.5 5.9 2 6.5 2.8C7.1 2 8 1.5 9 1.5C10.7 1.5 12 2.8 12 4.5C12 8.2 6.5 11.5 6.5 11.5Z"
                                                                stroke="currentColor" stroke-width="1.2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        {{ $reply->likes_count ?? 0 }}
                                                    </span>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rd-empty">
                    <div class="rd-empty-icon">💬</div>
                    <p>Belum ada komentar.<br>Jadilah yang pertama!</p>
                </div>
            @endforelse
        </div>

    </div>

    <div style="height:80px"></div>

    {{-- Modal Report --}}
    @include('layouts.componen_reader.modal_report', ['novelId' => $chapter->novel->id])

@endsection

@push('scripts')
    <script>
        // Progress bar
        window.addEventListener('scroll', function() {
            var total = document.documentElement.scrollHeight - window.innerHeight;
            var pct = total > 0 ? Math.min(100, Math.round((window.scrollY / total) * 100)) : 0;
            document.getElementById('progress-fill').style.width = pct + '%';
        }, {
            passive: true
        });

        // Char counter
        function updateCharCount(el) {
            document.getElementById('char-count').textContent = el.value.length + ' / 500';
        }

        // Toggle reply form
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (!form) return;
            form.classList.toggle('open');
            if (form.classList.contains('open')) {
                form.querySelector('textarea').focus();
            }
        }

        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        document.querySelectorAll('.modal-overlay').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target === el) el.classList.remove('open');
            });
        });
    </script>
@endpush
