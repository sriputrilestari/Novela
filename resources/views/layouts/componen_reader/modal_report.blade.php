<div class="modal-overlay" id="report-modal" onclick="closeModalOverlay(event,'report-modal')">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">🚩 Laporkan Konten</div>
      <button class="modal-close" onclick="closeModal('report-modal')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label class="form-label">Pilih Alasan Laporan</label>
        <select class="form-select">
          <option>Plagiat / Pencurian karya</option>
          <option>Konten tidak pantas / Dewasa</option>
          <option>Spam atau Penipuan</option>
          <option>Konten kekerasan berlebihan</option>
          <option>Ujaran kebencian</option>
          <option>Lainnya</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Keterangan Tambahan</label>
        <textarea class="form-textarea" style="min-height:100px;" placeholder="Jelaskan masalah yang ditemukan..."></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-secondary" onclick="closeModal('report-modal')">Batal</button>
      <button class="btn-danger" onclick="submitReport()">Kirim Laporan</button>
    </div>
  </div>
</div>
