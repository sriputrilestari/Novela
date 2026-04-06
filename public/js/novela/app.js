/* ============================================================
   NOVELA – APP INIT
   Titik masuk utama. Dijalankan sekali saat DOM siap.
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Search bar di topbar: tekan Enter → buka halaman search ── */
  const topbarSearch = document.querySelector('.search-input');
  if (topbarSearch) {
    topbarSearch.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        showPage('search');
        setActive(document.querySelectorAll('.nav-btn')[1]);
      }
    });
  }

  /* ── Search bar besar di halaman Jelajahi ── */
  const bigSearch = document.getElementById('search-big-input');
  if (bigSearch) {
    bigSearch.addEventListener('input', () => {
      // Placeholder: bisa dihubungkan ke fungsi filter novel
    });
    bigSearch.addEventListener('keydown', e => {
      if (e.key === 'Enter') {
        showToast('info', 'Cari', `Mencari: "${bigSearch.value}"`);
      }
    });
  }

  /* ── Tampilkan halaman Home sebagai default ── */
  showPage('home');
  const homeBtn = document.querySelector('.nav-btn');
  if (homeBtn) homeBtn.classList.add('active');

  /* ── Coba restore posisi baca terakhir ── */
  const lastRead = getLastRead('moonlit-sorceress');
  if (lastRead) {
    console.info(`[Novela] Last read: Chapter ${lastRead.chapter} (${lastRead.savedAt})`);
  }

});