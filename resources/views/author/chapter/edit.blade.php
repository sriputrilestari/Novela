@extends('author.layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --blue: #3d5af1;
            --blue-lt: #eef0fe;
            --blue-md: #dde2fc;
            --green: #00c9a7;
            --green-lt: #e0faf5;
            --red: #f1523d;
            --red-lt: #fef0ee;
            --ink: #18192a;
            --ink-2: #5a5f7a;
            --ink-3: #9698ae;
            --line: #e8eaf3;
        }

        body,
        .ch {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .pg-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px 26px;
            margin-bottom: 20px;
        }

        .pg-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink-3);
            text-decoration: none;
        }

        .pg-back:hover {
            color: var(--blue);
        }

        .pg-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--ink);
        }

        .pg-sub {
            font-size: 12.5px;
            color: var(--ink-3);
            margin-top: 3px;
        }

        .fcard-body {
            padding: 26px 28px;
        }

        .f-group {
            margin-bottom: 20px;
        }

        .f-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 7px;
        }

        .f-ctrl {
            width: 100%;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            padding: 10px 14px;
            font-family: inherit;
            font-size: 13.5px;
            color: var(--ink);
            background: #fff;
            transition: .2s;
            outline: none;
        }

        .f-ctrl.err {
            border-color: var(--red);
        }

        .f-ctrl.err:focus {
            box-shadow: 0 0 0 3px rgba(241, 82, 61, .1);
        }

        textarea.f-ctrl {
            resize: vertical;
            line-height: 1.75;
        }

        .f-err {
            font-size: 12px;
            font-weight: 600;
            color: var(--red);
            margin-top: 5px;
        }

        .f-footer {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid var(--line);
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 11px 24px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn-save:hover {
            background: #2d48e0;
            transform: translateY(-1px);
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f4f6fc;
            color: var(--ink-2);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 11px 20px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .btn-cancel:hover {
            background: var(--line);
            color: var(--ink);
        }

        /* Notification Styles */
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
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .97);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px 16px;
            min-width: 300px;
            max-width: 350px;
            box-shadow: 0 8px 28px rgba(24, 25, 42, .12);
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
            color: var(--ink);
        }

        .nt-msg {
            font-size: 12px;
            color: var(--ink-2);
            margin-top: 1px;
        }

        .nt-x {
            margin-left: auto;
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background: #f4f6fc;
            border: 1px solid var(--line);
            color: var(--ink-3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            transition: .18s;
        }

        .nt-x:hover {
            background: var(--line);
            color: var(--ink);
        }
    </style>

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
            }
        };

        function showN(type, title, msg) {
            const c = NC[type] || NC.info;
            const el = document.createElement('div');
            el.className = 'nt';
            el.innerHTML = `
            <div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div>
            <div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div>
            <button class="nt-x" onclick="this.parentElement.remove()">✕</button>`;
            document.getElementById('ns').appendChild(el);
            setTimeout(() => el.remove(), 5000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showN('success', 'Berhasil', @json(session('success')));
            @endif
            @if (session('error'))
                showN('error', 'Gagal', @json(session('error')));
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showN('error', 'Ada Kesalahan', '{{ $error }}');
                @endforeach
            @endif
        });
    </script>

    <div class="ch">
        <div class="pg-head">
            <div>
                <a href="{{ route('author.chapter.index', $novel->id) }}" class="pg-back">← Daftar Chapter</a>
                <div class="pg-title">✏️ Edit Chapter</div>
                <div class="pg-sub">{{ $novel->judul }}</div>
            </div>
        </div>

        <div class="fcard-body">
            <form action="{{ route('author.chapter.update', [$novel->id, $chapter->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="f-group">
                    <label class="f-label" for="title">Judul Chapter</label>
                    <input type="text" id="title" name="title" class="f-ctrl @error('title') err @enderror"
                        value="{{ old('title', $chapter->judul_chapter) }}" placeholder="Masukkan judul chapter">
                    @error('title')
                        <div class="f-err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="f-group">
                    <label class="f-label" for="content">Isi Chapter</label>
                    <textarea id="content" name="content" rows="10" class="f-ctrl @error('content') err @enderror"
                        placeholder="Tulis isi chapter...">{{ old('content', $chapter->isi) }}</textarea>
                    @error('content')
                        <div class="f-err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="f-group">
                    <label class="f-label" for="urutan">Urutan Chapter</label>
                    <input type="number" id="urutan" name="urutan" class="f-ctrl @error('urutan') err @enderror"
                        value="{{ old('urutan', $chapter->urutan) }}" min="1">
                    @error('urutan')
                        <div class="f-err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="f-group">
                    <label class="f-label" for="status">Status</label>
                    <select id="status" name="status" class="f-ctrl @error('status') err @enderror">
                        <option value="draft" {{ old('status', $chapter->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="published" {{ old('status', $chapter->status) == 'published' ? 'selected' : '' }}>
                            Published</option>
                    </select>
                    @error('status')
                        <div class="f-err">{{ $message }}</div>
                    @enderror
                </div>

                <div class="f-footer">
                    <a href="{{ route('author.chapter.index', $novel->id) }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">Simpan Chapter</button>
                </div>
            </form>
        </div>
    </div>
@endsection
