/* ============================================================
   NOVELA – READER
   Semua logika khusus halaman membaca:
   font size, tema baca, navigasi chapter, settings panel.
   ============================================================ */

/* ──────────────────────────────────────
   STATE
────────────────────────────────────── */
let _fontSize        = 18;       // px, ukuran font default saat baca
let _currentChapter  = 218;      // nomor chapter yang sedang dibaca
let _totalChapters   = 320;      // total chapter novel ini

/* ──────────────────────────────────────
   SETTINGS PANEL
────────────────────────────────────── */

/**
 * Tampilkan / sembunyikan panel pengaturan tampilan reader.
 */
function toggleSettings() {
  document.getElementById('settings-panel')?.classList.toggle('open');
}

/* ──────────────────────────────────────
   FONT SIZE
────────────────────────────────────── */

/**
 * Ubah ukuran font konten bacaan.
 * @param {number} delta - +1 atau -1
 */
function changeFontSize(delta) {
  _fontSize = Math.max(14, Math.min(26, _fontSize + delta));

  const display  = document.getElementById('font-size-display');
  const content  = document.getElementById('reader-content');

  if (display) display.textContent       = _fontSize + 'px';
  if (content) content.style.fontSize   = _fontSize + 'px';
}

/* ──────────────────────────────────────
   TEMA BACA
────────────────────────────────────── */

const _themes = {
  dark: {
    '--reader-bg':   '#04071a',
    '--reader-text': '#a8b4d8',
  },
  midnight: {
    '--reader-bg':   '#1a1a2e',
    '--reader-text': '#c8d0ef',
  },
  cream: {
    '--reader-bg':   '#f5f0e8',
    '--reader-text': '#2a2a2a',
  },
  white: {
    '--reader-bg':   '#ffffff',
    '--reader-text': '#1a1a1a',
  },
};

/**
 * Set tema tampilan reader.
 * @param {string}      theme  - key dari objek _themes
 * @param {HTMLElement} swatch - elemen .theme-swatch yang diklik
 */
function setReadTheme(theme, swatch) {
  // Update swatch active state
  swatch.closest('.theme-btns').querySelectorAll('.theme-swatch').forEach(s => s.classList.remove('active'));
  swatch.classList.add('active');

  // Terapkan CSS variable pada reader-content
  const content = document.getElementById('reader-content');
  const vars    = _themes[theme];
  if (content && vars) {
    Object.entries(vars).forEach(([key, val]) => {
      content.style.setProperty(key, val);
    });
    if (vars['--reader-bg'])   content.style.background = vars['--reader-bg'];
    if (vars['--reader-text']) content.style.color      = vars['--reader-text'];
  }

  const themeNames = { dark: 'Gelap', midnight: 'Midnight', cream: 'Krem', white: 'Putih' };
  showToast('info', 'Tema Baca', `Tema "${themeNames[theme] || theme}" diterapkan`);
}

/* ──────────────────────────────────────
   NAVIGASI CHAPTER
────────────────────────────────────── */

/**
 * Lanjut ke chapter berikutnya.
 */
function nextChapter() {
  if (_currentChapter >= _totalChapters) {
    showToast('info', 'Selesai', 'Kamu sudah berada di chapter terakhir! 🎉');
    return;
  }

  _currentChapter++;
  _updateChapterUI();
  window.scrollTo(0, 0);
  showToast('success', 'Chapter Selanjutnya', `Membaca Chapter ${_currentChapter}`);
}

/**
 * Kembali ke chapter sebelumnya.
 */
function prevChapter() {
  if (_currentChapter <= 1) {
    showToast('info', 'Navigasi', 'Sudah berada di chapter pertama');
    return;
  }

  _currentChapter--;
  _updateChapterUI();
  window.scrollTo(0, 0);
  showToast('info', 'Chapter Sebelumnya', `Membaca Chapter ${_currentChapter}`);
}

/**
 * Update elemen UI setelah chapter berganti.
 * @private
 */
function _updateChapterUI() {
  const pct = Math.round((_currentChapter / _totalChapters) * 100);

  const label = document.querySelector('.progress-label');
  const fill  = document.querySelector('.progress-fill');
  const title = document.querySelector('.reader-chapter-title');

  if (label) label.textContent       = `Chapter ${_currentChapter} / ${_totalChapters} · ${pct}% selesai`;
  if (fill)  fill.style.width        = pct + '%';
  if (title) title.textContent       = `Chapter ${_currentChapter}`;
}

/* ──────────────────────────────────────
   AUTO-SAVE LAST READ
────────────────────────────────────── */

/**
 * Simpan posisi terakhir ke localStorage.
 * Dipanggil secara otomatis saat chapter berganti.
 * @param {string} novelId - ID / slug novel
 */
function saveLastRead(novelId) {
  try {
    localStorage.setItem('novela_lastread_' + novelId, JSON.stringify({
      chapter: _currentChapter,
      savedAt: new Date().toISOString(),
    }));
  } catch (_) {
    // localStorage mungkin tidak tersedia (private browsing)
  }
}

/**
 * Ambil posisi terakhir dari localStorage.
 * @param  {string} novelId
 * @returns {{ chapter: number, savedAt: string } | null}
 */
function getLastRead(novelId) {
  try {
    const raw = localStorage.getItem('novela_lastread_' + novelId);
    return raw ? JSON.parse(raw) : null;
  } catch (_) {
    return null;
  }
}