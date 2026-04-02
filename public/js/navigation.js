/* ============================================================
   NOVELA – NAVIGATION
   Semua fungsi perpindahan halaman, tab, dan filter.
   ============================================================ */

/**
 * Tampilkan halaman berdasarkan nama.
 * @param {string} name - ID halaman tanpa prefix "page-"
 */
function showPage(name) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  const page = document.getElementById('page-' + name);
  if (page) {
    page.classList.add('active');
    window.scrollTo(0, 0);
  }
}

/**
 * Set tombol navigasi yang aktif di topbar.
 * @param {HTMLElement|null} btn - tombol yang diklik, null = tidak ada yang aktif
 */
function setActive(btn) {
  document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
}

/**
 * Pindah tab dalam satu halaman (mis. Sinopsis / Chapter / Komentar).
 * Mencari .tab-pane dalam scope yang sama dengan tabs-row.
 * @param {HTMLElement} btn       - tombol tab yang diklik
 * @param {string}      targetId  - ID elemen .tab-pane tujuan
 */
function switchTab(btn, targetId) {
  // Nonaktifkan semua tab-btn dalam grup yang sama
  btn.closest('.tabs-row').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  // Nonaktifkan semua tab-pane dalam container induk terdekat
  const container = btn.closest('[id^="page-"]') || document;
  container.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));

  const target = document.getElementById(targetId);
  if (target) target.classList.add('active');
}

/**
 * Pindah sub-tab pada halaman Favorit (Novel / Bookmark).
 * @param {HTMLElement} btn       - tombol fav-tab yang diklik
 * @param {string}      targetId  - ID div konten yang ditampilkan
 */
function switchFavTab(btn, targetId) {
  btn.closest('.fav-tabs').querySelectorAll('.fav-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  ['fav-novels', 'fav-chapters'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.display = (id === targetId) ? 'block' : 'none';
  });
}

/**
 * Toggle pill genre (single select).
 * @param {HTMLElement} el - pill yang diklik
 */
function toggleGenre(el) {
  el.closest('.genre-scroll').querySelectorAll('.genre-pill').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
}

/**
 * Toggle chip filter pencarian (single select).
 * @param {HTMLElement} el - chip yang diklik
 */
function toggleFilter(el) {
  el.closest('.filter-row').querySelectorAll('.filter-chip').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
}
