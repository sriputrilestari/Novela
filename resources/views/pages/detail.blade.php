  @extends('layouts.main')

  @section('title', ($novel->judul ?? 'Moonlit Sorceress') . ' – Novela')

  @section('content')

      <div class="detail-hero">
          <div class="detail-inner">
              <div class="detail-cover" style="background:linear-gradient(135deg,#1a2a6c,#2d4a9c)">
                  @if (isset($novel) && $novel->cover)
                      <img src="{{ asset('storage/' . $novel->cover) }}" alt="{{ $novel->judul }}"
                          style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;border-radius:14px 14px 0 0" />
                  @else
                      🌙
                  @endif
              </div>
              <div class="detail-info">
                  <div class="detail-genre-row">
                      <span class="tag">{{ $novel->genre->nama_genre ?? '-' }}</span>
                      <span class="tag tag-purple">Romance</span>
                      @if (($novel->approval_status ?? 'published') === 'published')
                          <span class="tag tag-gold">★ Pilihan Editor</span>
                      @endif
                  </div>
                  <div class="detail-title">{{ $novel->judul ?? 'Moonlit Sorceress' }}</div>
                  <div class="detail-author-row">
                      <div class="detail-author-avatar">{{ strtoupper(substr(optional($novel->author)->name ?? 'B', 0, 1)) }}</div>
                      <span style="opacity:.85">oleh <strong
                              style="color:white">{{ $novel->author->name ?? 'Unknown Author' }}</strong></span>
                      <span style="opacity:.6;font-size:.8rem">· Verified Author</span>
                  </div>
                  <div class="detail-stats-row">
                      <div>
                          <form action="{{ route('novel.rate', $novel->id) }}" method="POST">
                              @csrf
                              <div style="display:flex;gap:4px;cursor:pointer;font-size:18px">
                                  @for ($i = 1; $i <= 5; $i++)
                                      <button type="submit" name="rating" value="{{ $i }}"
                                          style="background:none;border:none;color:gold">
                                          {{ $i <= round($novel->rating) ? '★' : '☆' }}
                                      </button>
                                  @endfor
                              </div>
                          </form>
                          <span style="opacity:.8;font-size:12px">
                              {{ number_format($novel->rating, 1) }} ({{ $novel->total_rating }} votes)
                          </span>
                      </div>
                      <div>👁 <span>{{ number_format($novel->views ?? 1200000) }}</span></div>
                      <div>📖 <span>{{ $chapters->count() ?? 320 }} Ch</span></div>
                      <div>❤️ <span>{{ $bookmarkCount ?? '48.2K' }}</span></div>
                      <div>💬 <span>{{ $commentCount ?? '8.9K' }}</span></div>
                  </div>
                  <div class="detail-actions">
                      <a href="{{ route('chapter.show', $firstChapter->id ?? 1) }}" class="btn-primary">▶ Baca Sekarang</a>
                      @auth
                          <form action="{{ route('bookmark.toggle', $novel->id ?? 1) }}" method="POST" style="display:inline">
                              @csrf
                              <button type="submit" class="btn-secondary" id="fav-btn">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                      fill="{{ $isBookmarked ?? false ? 'white' : 'none' }}" viewBox="0 0 24 24"
                                      stroke="currentColor" stroke-width="2">
                                      <path
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                  </svg>
                                  {{ $isBookmarked ?? false ? 'Hapus Favorit' : 'Tambah Favorit' }}
                              </button>
                          </form>
                      @endauth
                      <button class="btn-secondary" onclick="openModal('report-modal')">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none"
                              viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                          </svg>
                          Laporkan
                      </button>
                  </div>
              </div>
          </div>
      </div>

      <div class="content-wrap" style="padding-top:32px">
          <div class="tabs-row">
              <button class="tab-btn active" onclick="switchTab(this,'tab-synopsis')">📋 Sinopsis</button>
              <button class="tab-btn" onclick="switchTab(this,'tab-chapters')">📖 Chapter</button>
              <button class="tab-btn" onclick="switchTab(this,'tab-comments')">💬 Komentar</button>
              <button class="tab-btn" onclick="switchTab(this,'tab-about')">ℹ️ Tentang</button>
          </div>

          {{-- SINOPSIS --}}
          <div class="tab-pane active" id="tab-synopsis">
              <p class="synopsis-text">
                  {{ $novel->sinopsis ?? 'Di dunia di mana sihir telah punah selama satu abad, Lunara—gadis yatim piatu dari desa terpencil—menemukan bahwa dirinya memiliki kekuatan yang telah lama dilupakan. Ketika bulan purnama tiba, ia berubah menjadi Moonlit Sorceress, penjaga kuno yang dipilih oleh bintang-bintang itu sendiri.' }}
              </p>
              <div class="flex gap-8 mt-16" style="flex-wrap:wrap">
                  <span class="tag">Kekuatan Tersembunyi</span>
                  <span class="tag">Cinta Terlarang</span>
                  <span class="tag">Petualangan</span>
                  <span class="tag">Magis</span>
              </div>
              <div
                  style="margin-top:24px;padding:16px;background:var(--blue-lt);border-radius:14px;border:1px solid var(--blue-md)">
                  <div class="flex items-center gap-8 mb-8">
                      <span style="font-size:1.1rem">📊</span>
                      <span style="font-weight:700;color:var(--blue)">Statistik Novel</span>
                  </div>
                  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;text-align:center">
                      <div>
                          <div style="font-size:1.3rem;font-weight:800;color:var(--blue)">{{ $novel->views ?? '1.2M' }}
                          </div>
                          <div class="text-muted text-xs">Total Views</div>
                      </div>
                      <div>
                          <div style="font-size:1.3rem;font-weight:800;color:var(--green)">{{ $bookmarkCount ?? '48K' }}
                          </div>
                          <div class="text-muted text-xs">Favorit</div>
                      </div>
                      <div>
                          <div style="font-size:1.3rem;font-weight:800;color:var(--amber)">{{ $chapters->count() ?? 320 }}
                          </div>
                          <div class="text-muted text-xs">Chapter</div>
                      </div>
                  </div>
              </div>
          </div>

          {{-- CHAPTERS --}}
          <div class="tab-pane" id="tab-chapters">
              <div class="flex items-center justify-between mb-16">
                  <span class="text-muted text-sm">Total {{ $chapters->count() ?? 320 }} Chapter · <span
                          class="badge badge-{{ ($novel->status ?? 'ongoing') === 'completed' ? 'green' : 'amber' }}">{{ ($novel->status ?? 'ongoing') === 'completed' ? 'TAMAT' : 'ONGOING' }}</span></span>
                  <div class="flex gap-8">
                      <button class="btn-ghost" onclick="sortChapters('desc')">Terbaru ↓</button>
                      <button class="btn-ghost" onclick="sortChapters('asc')">Terlama ↑</button>
                  </div>
              </div>
              <div class="chapter-list" id="chapter-list">
                  @forelse($chapters ?? [] as $chapter)
                      <a href="{{ route('chapter.show', $chapter->id) }}" class="chapter-item"
                          style="text-decoration:none">
                          <div class="chapter-num">{{ $chapter->urutan }}</div>
                          <div class="chapter-info">
                              <div class="chapter-title-text">Chapter {{ $chapter->urutan }}:
                                  {{ $chapter->judul_chapter }}</div>
                              <div class="chapter-meta">{{ \Carbon\Carbon::parse($chapter->created_at)->format('d M Y') }}
                              </div>
                          </div>
                          <div class="chapter-status">
                              @if (isset($lastReadChapter) && $lastReadChapter->id === $chapter->id)
                                  <span class="badge badge-blue">📖 Terakhir</span>
                              @endif
                          </div>
                      </a>
                  @empty
                      @foreach ([['num' => 1, 'title' => 'Gadis di Bawah Bulan', 'date' => '8 Feb 2024'], ['num' => 2, 'title' => 'Warisan Terlarang', 'date' => '10 Feb 2024'], ['num' => 218, 'title' => 'Pertempuran Akhir', 'date' => '12 Mar 2025', 'last' => true], ['num' => 219, 'title' => 'Fajar Baru', 'date' => '14 Mar 2025'], ['num' => 320, 'title' => 'Akhir yang Abadi (TAMAT)', 'date' => '20 Jan 2026', 'final' => true]] as $ch)
                          <a href="{{ route('chapter.show', 1) }}" class="chapter-item" style="text-decoration:none">
                              <div class="chapter-num">{{ $ch['num'] }}</div>
                              <div class="chapter-info">
                                  <div class="chapter-title-text">Chapter {{ $ch['num'] }}: {{ $ch['title'] }}</div>
                                  <div class="chapter-meta">{{ $ch['date'] }}</div>
                              </div>
                              <div class="chapter-status">
                                  @isset($ch['last'])
                                      <span class="badge badge-blue">📖 Terakhir</span>
                                  @endisset
                                  @isset($ch['final'])
                                      <span class="badge badge-amber">★ Final</span>
                                  @endisset
                              </div>
                          </a>
                      @endforeach
                  @endforelse
              </div>
          </div>

          {{-- KOMENTAR --}}
          <div class="tab-pane" id="tab-comments">
              @auth
                  <div class="comment-box">
                      <form action="/comment" method="POST">
                          @csrf
                          <input type="hidden" name="chapter_id" value="{{ $firstChapter->id ?? 1 }}" />
                          <textarea class="comment-input" name="komentar" placeholder="Tulis komentarmu tentang novel ini..." required></textarea>
                          <div class="comment-actions">
                              <button type="button" class="btn-ghost btn-sm">Batal</button>
                              <button type="submit" class="btn-primary btn-sm">Kirim Komentar</button>
                          </div>
                      </form>
                  </div>
              @else
                  <div
                      style="background:var(--blue-lt);border:1px solid var(--blue-md);border-radius:14px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px">
                      <span style="font-size:1.2rem">💬</span>
                      <div>
                          <div style="font-weight:600;color:var(--blue);font-size:.9rem">Login untuk berkomentar</div>
                          <div class="text-muted text-xs mt-4">Bergabung dan bagikan pendapatmu!</div>
                      </div>
                      <a href="{{ route('login') }}" class="btn-sm" style="margin-left:auto">Login</a>
                  </div>
              @endauth
              @foreach ([['initial' => 'L', 'bg' => '', 'user' => 'Lizzy Reader', 'time' => '2 jam lalu', 'text' => 'Novel ini benar-benar luar biasa! Karakter Lunara sangat relatable dan alur ceritanya bikin penasaran terus.', 'likes' => 24], ['initial' => 'J', 'bg' => 'linear-gradient(135deg,#2d6c4a,#1a3a2c)', 'user' => 'John Doe', 'time' => '5 jam lalu', 'text' => 'World building-nya keren banget. Penulis benar-benar tahu cara membangun dunia yang immersive.', 'likes' => 16], ['initial' => 'E', 'bg' => 'linear-gradient(135deg,#6c2d4a,#3a1a2a)', 'user' => 'Emma Castillo', 'time' => '1 hari lalu', 'text' => 'Orion adalah karakter terfavorit saya. Chemistry-nya dengan Lunara bikin baper parah 😭❤️', 'likes' => 42]] as $comment)
                  <div class="comment-item">
                      <div class="comment-avatar" style="{{ $comment['bg'] ? 'background:' . $comment['bg'] : '' }}">
                          {{ $comment['initial'] }}</div>
                      <div class="comment-body">
                          <div class="comment-user">{{ $comment['user'] }} <span
                                  class="comment-time">{{ $comment['time'] }}</span></div>
                          <div class="comment-text">{{ $comment['text'] }}</div>
                          <div class="comment-actions-row">
                              <button class="comment-action-btn" onclick="likeComment(this)">👍
                                  <span>{{ $comment['likes'] }}</span></button>
                              <button class="comment-action-btn">💬 Balas</button>
                              <button class="comment-action-btn" style="color:var(--red)">🚩 Laporkan</button>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>

          {{-- TENTANG --}}
          <div class="tab-pane" id="tab-about">
              <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;max-width:640px">
                  <div style="background:var(--bg);border:1.5px solid var(--line);border-radius:14px;padding:18px">
                      <div class="text-muted text-xs mb-12">PENULIS</div>
                      <div class="flex gap-12 items-center">
                          <div class="detail-author-avatar"
                              style="background:var(--blue);color:white;width:44px;height:44px">
                              {{ strtoupper(substr(optional($novel->author)->name ?? 'B', 0, 1)) }}</div>
                          <div>
                              <div class="font-700">{{ $novel->author->name ?? 'Unknown Author' }}</div>
                              <div class="text-muted text-xs mt-4">12 Novel · 4.2M followers</div>
                          </div>
                      </div>
                      @if (isset($novel->author->bio))
                          <p class="text-muted text-sm mt-12" style="line-height:1.6">{{ $novel->author->bio }}</p>
                      @endif
                  </div>
                  <div style="background:var(--bg);border:1.5px solid var(--line);border-radius:14px;padding:18px">
                      <div class="text-muted text-xs mb-12">INFO NOVEL</div>
                      <div class="flex items-center justify-between mb-8">
                          <span class="text-sm text-soft">Status</span>
                          <span
                              class="badge {{ ($novel->status ?? 'ongoing') === 'completed' ? 'badge-green' : 'badge-amber' }}">{{ ($novel->status ?? 'ongoing') === 'completed' ? 'TAMAT' : 'ONGOING' }}</span>
                      </div>
                      <div class="flex items-center justify-between mb-8">
                          <span class="text-sm text-soft">Bahasa</span>
                          <span class="text-sm font-600">Indonesia</span>
                      </div>
                      <div class="flex items-center justify-between mb-8">
                          <span class="text-sm text-soft">Rilis</span>
                          <span
                              class="text-sm font-600">{{ isset($novel) ? \Carbon\Carbon::parse($novel->created_at)->format('M Y') : 'Feb 2024' }}</span>
                      </div>
                      <div class="flex items-center justify-between">
                          <span class="text-sm text-soft">Genre</span>
                          <span class="badge badge-blue">{{ $novel->genre->nama_genre ?? '-' }}</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <script>
          function sortChapters(dir) {
              showToast('info', 'Chapter', 'Diurutkan: ' + (dir === 'desc' ? 'Terbaru' : 'Terlama'))
          }
      </script>
  @endsection
