/* ============================================================
   NOVELA – UI UTILITIES
   Toast notification, modal, toggle favorit, radio, laporan.
   ============================================================ */

/* ──────────────────────────────────────
   TOAST NOTIFICATION
────────────────────────────────────── */

let _toastTimer = null;

/**
 * Tampilkan toast notification.
 * @param {'success'|'info'|'danger'} type  - jenis toast
 * @param {string}                    title - judul singkat
 * @param {string}                    msg   - pesan detail
 */
function showToast(type, title, msg) {
  const toast  = document.getElementById('toast');
  const icon   = document.getElementById('toast-icon');
  const icons  = { success: '✓', info: 'ℹ', danger: '⚠' };

  icon.className       = 'toast-icon ' + type;
  icon.textContent     = icons[type] || '✓';
  document.getElementById('toast-title').textContent = title;
  document.getElementById('toast-msg').textContent   = msg;

  toast.classList.add('show');

  clearTimeout(_toastTimer);
  _toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}

/* ──────────────────────────────────────
   MODAL
────────────────────────────────────── */

/**
 * Buka modal overlay.
 * @param {string} id - ID elemen .modal-overlay
 */
function openModal(id) {
  document.getElementById(id)?.classList.add('open');
}

/**
 * Tutup modal overlay.
 * @param {string} id - ID elemen .modal-overlay
 */
function closeModal(id) {
  document.getElementById(id)?.classList.remove('open');
}

/**
 * Tutup modal saat klik di luar area modal (overlay).
 * Pasang di onclick pada elemen .modal-overlay:
 *   onclick="closeModalOverlay(event, 'nama-modal')"
 * @param {MouseEvent} e  - event klik
 * @param {string}     id - ID modal overlay
 */
function closeModalOverlay(e, id) {
  if (e.target === e.currentTarget) closeModal(id);
}

/* ──────────────────────────────────────
   FAVORIT
────────────────────────────────────── */

/**
 * Toggle status favorit sebuah novel.
 * State disimpan di data-fav attribute pada tombol.
 * @param {HTMLElement} btn - tombol yang diklik
 */
function toggleFav(btn) {
  const isFav = btn.dataset.fav === '1';
  if (isFav) {
    btn.dataset.fav = '0';
    showToast('info', 'Favorit', 'Novel dihapus dari favorit');
    const svg = btn.querySelector('svg');
    if (svg) svg.setAttribute('fill', 'none');
  } else {
    btn.dataset.fav = '1';
    showToast('success', 'Favorit', 'Novel ditambahkan ke favorit ❤️');
    const svg = btn.querySelector('svg');
    if (svg) svg.setAttribute('fill', 'currentColor');
  }
}

/* ──────────────────────────────────────
   RADIO GROUP
────────────────────────────────────── */

/**
 * Pilih satu radio-item dalam kelompoknya.
 * @param {HTMLElement} item - elemen .radio-item yang diklik
 */
function selectRadio(item) {
  item.closest('.radio-group').querySelectorAll('.radio-item').forEach(i => i.classList.remove('selected'));
  item.classList.add('selected');
}

/* ──────────────────────────────────────
   KOMENTAR
────────────────────────────────────── */

/**
 * Like sebuah komentar (increment hitungan, warna tombol berubah).
 * @param {HTMLElement} btn - tombol like
 */
function likeComment(btn) {
  const span = btn.querySelector('span');
  if (!span) return;
  span.textContent  = parseInt(span.textContent) + 1;
  btn.style.color   = 'var(--accent)';
}

/* ──────────────────────────────────────
   LAPORAN / REPORT
────────────────────────────────────── */

/**
 * Submit laporan: tutup modal (jika ada), tampilkan toast konfirmasi.
 */
function submitReport() {
  closeModal('report-modal');
  showToast('success', 'Laporan Terkirim', 'Tim kami akan meninjaunya dalam 1×24 jam. Terima kasih!');
}