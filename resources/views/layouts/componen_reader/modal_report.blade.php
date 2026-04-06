{{--
    KOMPONEN MODAL LAPORAN NOVEL
    Cara pakai: @include('components.modal-report', ['novelId' => $novel->id])
    Tombol trigger: <button onclick="openModal('report-modal')">🚩 Laporkan</button>
--}}

@auth
    <div class="modal-overlay" id="report-modal"
        style="
    position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;
    display:flex;align-items:center;justify-content:center;padding:20px;
    opacity:0;pointer-events:none;transition:.25s;
">
        <div style="
    background:#fff;border-radius:20px;padding:28px;width:100%;max-width:460px;
    box-shadow:0 24px 64px rgba(0,0,0,.2);
    transform:translateY(20px) scale(.97);transition:.3s cubic-bezier(.16,1,.3,1);
  "
            id="report-modal-box">

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                <div style="font-size:16px;font-weight:800;color:#18192a;">🚩 Laporkan Novel</div>
                <button onclick="closeModal('report-modal')"
                    style="
        width:28px;height:28px;border-radius:7px;border:1px solid #e8eaf3;
        background:#f4f6fc;cursor:pointer;font-size:12px;font-weight:700;color:#9698ae;
      ">✕</button>
            </div>
            <div style="font-size:12.5px;color:#9698ae;margin-bottom:20px;">
                Laporan akan ditinjau admin. Penyalahgunaan fitur ini dapat berakibat sanksi akun.
            </div>

            <form method="POST" action="{{ route('novel.report', $novelId) }}">
                @csrf

                {{-- Alasan --}}
                <div style="margin-bottom:16px;">
                    <label
                        style="display:block;font-size:11px;font-weight:700;color:#5a5f7a;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;">
                        Alasan Laporan <span style="color:#f1523d">*</span>
                    </label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                        @foreach ([
            'plagiarisme' => '📋 Plagiarisme',
            'konten_dewasa' => '🔞 Konten Dewasa',
            'kekerasan' => '⚠️ Kekerasan Berlebihan',
            'ujaran_kebencian' => '🤬 Ujaran Kebencian',
            'spam' => '🗑️ Spam / Tidak Relevan',
            'lainnya' => '📝 Lainnya',
        ] as $value => $label)
                            <label
                                style="
            display:flex;align-items:center;gap:8px;padding:10px 12px;
            border:1.5px solid #e8eaf3;border-radius:10px;cursor:pointer;
            font-size:12.5px;font-weight:600;color:#18192a;transition:.15s;
          "
                                class="report-option">
                                <input type="radio" name="alasan" value="{{ $value }}"
                                    style="accent-color:#3d5af1;" required>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:11px;font-weight:700;color:#5a5f7a;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;">
                        Deskripsi (opsional)
                    </label>
                    <textarea name="deskripsi" maxlength="1000" placeholder="Jelaskan lebih detail..."
                        style="
          width:100%;background:#f7f8fc;border:1.5px solid #e8eaf3;border-radius:10px;
          padding:12px 14px;font-size:13px;color:#18192a;outline:none;resize:vertical;
          min-height:80px;font-family:inherit;box-sizing:border-box;transition:.2s;
        "
                        onfocus="this.style.borderColor='#3d5af1'" onblur="this.style.borderColor='#e8eaf3'"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" onclick="closeModal('report-modal')"
                        style="
          padding:10px 20px;border-radius:10px;border:1px solid #e8eaf3;
          background:#f4f6fc;color:#5a5f7a;font-size:13px;font-weight:600;cursor:pointer;
        ">Batal</button>
                    <button type="submit"
                        style="
          padding:10px 22px;border-radius:10px;border:none;
          background:#f1523d;color:#fff;font-size:13px;font-weight:700;cursor:pointer;
        ">🚩
                        Kirim Laporan</button>
                </div>
            </form>

        </div>
    </div>

    <style>
        .report-option:has(input:checked) {
            border-color: #3d5af1 !important;
            background: #eef0fe;
        }

        .report-option:hover {
            border-color: #c0c8f8;
            background: #f8f9fe;
        }

        #report-modal.open {
            opacity: 1 !important;
            pointer-events: all !important;
        }

        #report-modal.open #report-modal-box {
            transform: translateY(0) scale(1) !important;
        }
    </style>
@else
    {{-- Guest: arahkan ke login --}}
    <div class="modal-overlay" id="report-modal"
        style="
    position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;
    display:flex;align-items:center;justify-content:center;padding:20px;
    opacity:0;pointer-events:none;transition:.25s;
">
        <div style="
    background:#fff;border-radius:20px;padding:32px;width:100%;max-width:360px;
    text-align:center;box-shadow:0 24px 64px rgba(0,0,0,.2);
    transform:translateY(20px) scale(.97);transition:.3s cubic-bezier(.16,1,.3,1);
  "
            id="report-modal-box">
            <div style="font-size:40px;margin-bottom:12px;">🔒</div>
            <div style="font-size:16px;font-weight:800;color:#18192a;margin-bottom:8px;">Login Diperlukan</div>
            <div style="font-size:13px;color:#9698ae;margin-bottom:24px;">Kamu harus login untuk melaporkan novel.</div>
            <div style="display:flex;gap:10px;justify-content:center;">
                <button onclick="closeModal('report-modal')"
                    style="padding:10px 18px;border-radius:10px;border:1px solid #e8eaf3;background:#f4f6fc;color:#5a5f7a;font-size:13px;font-weight:600;cursor:pointer;">Batal</button>
                <a href="{{ route('login') }}"
                    style="padding:10px 22px;border-radius:10px;background:#3d5af1;color:#fff;font-size:13px;font-weight:700;text-decoration:none;">Masuk</a>
            </div>
        </div>
    </div>
    <style>
        #report-modal.open {
            opacity: 1 !important;
            pointer-events: all !important;
        }

        #report-modal.open #report-modal-box {
            transform: translateY(0) scale(1) !important;
        }
    </style>
@endauth
