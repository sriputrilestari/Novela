@extends('layouts.app')
@section('title', 'Jadi Penulis - Novela')


@section('content')

    <div class="content-wrap" style="max-width:680px">
        {{-- Hero --}}
        <div style="text-align:center;margin-bottom:2rem">
            <div
                style="width:72px;height:72px;background:var(--blue-lt);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">
                ✍️</div>
            <h1 style="font-family:'Lora',serif;font-size:1.5rem;font-weight:700;color:var(--ink);margin-bottom:.5rem">Jadi
                Penulis di Novela</h1>
            <p style="color:var(--ink-3);font-size:.875rem;max-width:420px;margin:0 auto;line-height:1.7">Wujudkan ceritamu
                dan bagikan karya kepada pembaca. Ajukan akses author dari akun reader-mu.</p>
        </div>


        @if (isset($currentUser) && $currentUser->author_request !== 'none')
            @php $status = $currentUser->author_request; @endphp
            @if ($status === 'pending')
                {{-- ... status pending (tidak berubah) ... --}}
            @elseif($status === 'approved')
                {{-- ... status approved (tidak berubah) ... --}}
            @elseif($status === 'rejected')
                {{-- ... status rejected (tidak berubah) ... --}}
            @endif
        @else
            <div
                style="background:var(--white);border-radius:var(--radius-lg);border:0.5px solid var(--line);overflow:hidden;margin-bottom:1.5rem">

                {{-- Header benefits --}}
                <div style="background:linear-gradient(135deg,#1e2f9e,#3d5af1);padding:1.25rem 1.5rem;color:white">
                    <div style="font-family:'Lora',serif;font-size:.95rem;font-weight:700;margin-bottom:1rem;opacity:.9">
                        Keuntungan jadi penulis</div>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem">
                        @foreach ([['Tulis Novel', 'Buat & publikasikan novel sendiri'], ['Statistik', 'Pantau views & pembaca'], ['Interaksi', 'Balas komentar pembaca']] as $b)
                            <div
                                style="background:rgba(255,255,255,.1);border-radius:10px;padding:.875rem 1rem;border:0.5px solid rgba(255,255,255,.15)">
                                <div style="font-size:.8rem;font-weight:700;margin-bottom:.2rem">{{ $b[0] }}</div>
                                <div style="font-size:.7rem;opacity:.7;line-height:1.5">{{ $b[1] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Form body --}}
                <div style="padding:1.5rem">
                    <div
                        style="font-family:'Lora',serif;font-size:1rem;font-weight:700;margin-bottom:1.25rem;color:var(--ink)">
                        Form pengajuan penulis</div>

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <ul style="margin:0;padding-left:1rem">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reader.author-request.submit') }}" method="POST">
                        @csrf

                        {{-- Nama Pena --}}
                        <div class="form-group">
                            <label class="form-label">Nama Pena <span style="color:var(--red)">*</span></label>
                            <input class="form-input" name="pen_name" value="{{ old('pen_name', auth()->user()->name) }}"
                                placeholder="Nama yang akan tampil sebagai penulis" required />
                        </div>

                        {{-- Genre — max 3 --}}
                        <div class="form-group">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem">
                                <label class="form-label" style="margin:0">Genre Favorit</label>
                                <span style="font-size:.75rem;color:var(--ink-3)">Pilih maksimal <span id="genre-counter"
                                        style="font-weight:600;color:#534AB7">0</span>/3</span>
                            </div>

                            <div id="genre-wrap" style="display:flex;flex-wrap:wrap;gap:.5rem">
                                @foreach ($genres as $genre)
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                        id="gc-{{ $genre->id }}" style="display:none"
                                        {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }} />
                                    <span class="genre-pill {{ in_array($genre->id, old('genres', [])) ? 'active' : '' }}"
                                        data-target="gc-{{ $genre->id }}">
                                        <span class="genre-check-dot">
                                            <svg width="8" height="8" viewBox="0 0 8 8">
                                                <polyline points="1.5,4 3.2,5.8 6.5,2" fill="none" stroke="#EEEDFE"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        {{ $genre->nama_genre }}
                                    </span>
                                @endforeach
                            </div>

                            <div id="genre-hint"
                                style="font-size:.75rem;color:#A32D2D;background:#FCEBEB;border:0.5px solid #F7C1C1;border-radius:6px;padding:5px 10px;display:none;align-items:center;gap:5px;margin-top:.5rem">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <circle cx="6" cy="6" r="5.5" stroke="#A32D2D" />
                                    <path d="M6 4v3M6 8.5v.5" stroke="#A32D2D" stroke-width="1.2" stroke-linecap="round" />
                                </svg>
                                Maksimal 3 genre. Hapus salah satu dulu ya!
                            </div>

                            <div style="margin-top:.75rem">
                                <div
                                    style="font-size:.7rem;color:var(--ink-3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:.35rem">
                                    Pilihanmu</div>
                                <div id="genre-preview"
                                    style="display:flex;flex-wrap:wrap;gap:6px;min-height:28px;padding:8px 10px;border-radius:var(--radius);background:var(--bg-2);border:0.5px solid var(--line);align-items:center">
                                    <span id="genre-empty" style="font-size:.75rem;color:var(--ink-3)">Belum ada genre
                                        dipilih</span>
                                </div>
                            </div>
                        </div>

                        <hr style="border:none;border-top:0.5px solid var(--line);margin:1.25rem 0">

                        {{-- Sinopsis --}}
                        <div class="form-group">
                            <label class="form-label">Sinopsis novel pertamamu <span
                                    style="color:var(--red)">*</span></label>
                            <textarea class="form-textarea" name="sinopsis_pertama" id="sinopsis" rows="4"
                                placeholder="Ceritakan sedikit tentang novel yang ingin kamu tulis..." required style="min-height:110px">{{ old('sinopsis_pertama') }}</textarea>
                            <div style="font-size:.75rem;color:var(--ink-3);margin-top:.35rem"><span
                                    id="synopsis-count">0</span> / 500 karakter</div>
                        </div>

                        {{-- Pengalaman --}}
                        <div class="form-group">
                            <label class="form-label">Pengalaman Menulis</label>
                            <input type="hidden" name="pengalaman" id="pengalaman-val" value="{{ old('pengalaman') }}" />
                            <div style="display:flex;flex-direction:column;gap:.5rem;margin-top:.25rem">
                                @foreach ([['pemula', 'Pemula', 'Baru mulai belajar menulis'], ['hobi', 'Hobi', 'Menulis untuk kesenangan'], ['semi_pro', 'Semi-Profesional', 'Pernah publikasi atau ikut lomba'], ['profesional', 'Profesional', 'Penulis aktif dengan karya terbit']] as [$val, $label, $desc])
                                    <label class="level-pill {{ old('pengalaman') == $val ? 'active' : '' }}"
                                        data-val="{{ $val }}">
                                        <span class="level-check-dot">
                                            <svg width="8" height="8" viewBox="0 0 8 8">
                                                <polyline points="1.5,4 3.2,5.8 6.5,2" fill="none" stroke="#EEEDFE"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span>
                                            <span
                                                style="font-size:.85rem;font-weight:500;display:block">{{ $label }}</span>
                                            <span
                                                style="font-size:.75rem;color:var(--ink-3);display:block;margin-top:.1rem">{{ $desc }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Motivasi --}}
                        <div class="form-group">
                            <label class="form-label">Motivasi & Alasan</label>
                            <textarea class="form-textarea" name="motivasi" rows="3"
                                placeholder="Kenapa kamu ingin jadi penulis di Novela?">{{ old('motivasi') }}</textarea>
                        </div>

                        {{-- Setuju --}}
                        <div
                            style="background:var(--bg-2);border:0.5px solid var(--line);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.75rem">
                            <input type="checkbox" name="setuju" id="setuju" required
                                style="margin-top:2px;accent-color:var(--blue);width:15px;height:15px;flex-shrink:0" />
                            <label for="setuju"
                                style="font-size:.825rem;color:var(--ink-2);line-height:1.6;cursor:pointer">
                                Saya menyetujui syarat dan ketentuan penulis Novela dan berkomitmen untuk mempublikasikan
                                konten orisinal.
                            </label>
                        </div>

                        <button type="submit" class="btn-primary btn-block btn-lg">Kirim Permintaan Jadi Penulis</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        (function() {
            const MAX = 3;
            const wrap = document.getElementById('genre-wrap');
            const counter = document.getElementById('genre-counter');
            const hint = document.getElementById('genre-hint');
            const preview = document.getElementById('genre-preview');
            const empty = document.getElementById('genre-empty');
            let hintTimer;

            function getSelected() {
                return wrap ? [...wrap.querySelectorAll('input[type=checkbox]:checked')] : [];
            }

            function updateUI() {
                const selected = getSelected();
                const n = selected.length;

                if (counter) counter.textContent = n;

                wrap && wrap.querySelectorAll('.genre-pill').forEach(pill => {
                    const cb = document.getElementById(pill.dataset.target);
                    if (!cb) return;
                    pill.classList.toggle('active', cb.checked);
                    pill.classList.toggle('genre-dimmed', !cb.checked && n >= MAX);
                });

                if (n < MAX && hint) hint.style.display = 'none';

                if (preview) {
                    preview.innerHTML = '';
                    if (n === 0) {
                        preview.appendChild(empty);
                    } else {
                        selected.forEach(cb => {
                            const pill = wrap.querySelector(`[data-target="${cb.id}"]`);
                            if (!pill) return;
                            const tag = document.createElement('span');
                            tag.className = 'genre-selected-tag';
                            tag.textContent = pill.textContent.trim();
                            preview.appendChild(tag);
                        });
                    }
                }
            }

            wrap && wrap.querySelectorAll('.genre-pill').forEach(pill => {
                pill.addEventListener('click', () => {
                    const cb = document.getElementById(pill.dataset.target);
                    if (!cb) return;
                    if (!cb.checked && getSelected().length >= MAX) {
                        if (hint) {
                            hint.style.display = 'inline-flex';
                            clearTimeout(hintTimer);
                            hintTimer = setTimeout(() => {
                                hint.style.display = 'none';
                            }, 2500);
                        }
                        return;
                    }
                    cb.checked = !cb.checked;
                    updateUI();
                });
            });

            updateUI();

            // level picker
            document.querySelectorAll('.level-pill').forEach(pill => {
                pill.addEventListener('click', () => {
                    document.querySelectorAll('.level-pill').forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');
                    const input = document.getElementById('pengalaman-val');
                    if (input) input.value = pill.dataset.val;
                });
            });

            // synopsis counter
            const syn = document.getElementById('sinopsis');
            const cnt = document.getElementById('synopsis-count');
            if (syn && cnt) {
                const update = () => {
                    const l = syn.value.length;
                    cnt.textContent = l;
                    cnt.style.color = l > 500 ? 'var(--red)' : 'var(--ink-3)';
                };
                syn.addEventListener('input', update);
                update();
            }
        })();
    </script>
@endpush
