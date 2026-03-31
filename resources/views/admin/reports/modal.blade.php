{{ --;
    Komponen formlaporanuntukreader .
    include di halamandetailnovel:
    @include 'reader.partials.report-modal', ['novel' => $novel];
    Lalu tambahkantombolpemicu:
    < button onclick = "document.getElementById('reportModal').classList.add('open')" > 🚩 Laporkan <  / button >
    --}}

< style >
. report - modal - overlay {position: fixed;
    inset: 0;
    background: rgba(24, 25, 42, .5);
    z - index: 9000;
    display: flex;
    align - items: center;
    justify - content: center;
    padding: 20px;
    opacity: 0;
    pointer - events: none;
    transition: .25s;}
. report - modal - overlay . open {opacity: 1;
    pointer - events: all;}
. report - modal - box {background: #fff;border-radius:20px;padding:28px;width:100%;max-width:460px;box-shadow:0 24px 64px rgba(24,25,42,.2);transform:translateY(20px) scale(.97);transition:.3s cubic-bezier(.16,1,.3,1);font-family:'Plus Jakarta Sans',sans-serif;}
    . report - modal - overlay . open . report - modal - box {transform: translateY(0)scale(1);}
    . rm - header {display: flex;
        align - items: flex - start;
        justify - content: space - between;
        margin - bottom: 6px;}
    . rm - title {font - size: 17px;
        font - weight: 800;
        color: #18192a;}
        . rm - close {width: 30px;
            height: 30px;
            border - radius: 8px;
            background:                      #f4f6fc;border:1px solid #e8eaf3;color:#9698ae;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;transition:.2s;flex-shrink:0;}
            . rm - close: hover {background: #e8eaf3;color:#18192a;}
                . rm - sub {font - size: 13px;
                    color: #9698ae;margin-bottom:22px;}
                    . rm - novel - chip {display: flex;
                        align - items: center;
                        gap: 10px;
                        background: #f4f6fc;border:1px solid #e8eaf3;border-radius:12px;padding:12px 14px;margin-bottom:20px;}
                        . rm - novel - ico {font - size: 20px;
                            flex - shrink: 0;}
                        . rm - novel - title {font - size: 13px;
                            font - weight: 700;
                            color: #18192a;}
                            . rm - novel - author {font - size: 11.5px;
                                color: #9698ae;margin-top:1px;}
                                . rm - label {font - size: 12px;
                                    font - weight: 700;
                                    color: #5a5f7a;text-transform:uppercase;letter-spacing:.6px;display:block;margin-bottom:8px;}
                                    . rm - options {display: flex;
                                        flex - direction: column;
                                        gap: 8px;
                                        margin - bottom: 20px;}
                                    . rm - option {display: flex;
                                        align - items: center;
                                        gap: 10px;
                                        border: 1.5px solid                   #e8eaf3;border-radius:11px;padding:12px 14px;cursor:pointer;transition:.2s;}
                                        . rm - option: hover {border - color: #3d5af1;background:#eef0fe;}
                                            . rm - option input[type = radio]{display: none;}
                                            . rm - option . selected {border - color: #3d5af1;background:#eef0fe;}
                                                . rm - option - ico {font - size: 18px;
                                                    flex - shrink: 0;}
                                                . rm - option - label {font - size: 13.5px;
                                                    font - weight: 600;
                                                    color: #18192a;}
                                                    . rm - option - sub {font - size: 11.5px;
                                                        color: #9698ae;margin-top:1px;}
                                                        . rm - textarea {width: 100 % ;
                                                            background:                             #f7f8fc;border:1.5px solid #e8eaf3;border-radius:11px;padding:12px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;color:#18192a;outline:none;resize:vertical;min-height:90px;transition:.2s;}
                                                            . rm - textarea: focus {border - color: #3d5af1;box-shadow:0 0 0 3px rgba(61,90,241,.1);}
                                                                . rm - textarea::placeholder {color:    #9698ae;}
                                                                    . rm - footer {display: flex;
                                                                        gap: 10px;
                                                                        justify - content: flex - end;
                                                                        margin - top: 20px;}
                                                                    . rm - btn - cancel {padding: 11px22px;
                                                                        border - radius: 10px;
                                                                        border: 1px solid                       #e8eaf3;background:#f4f6fc;color:#5a5f7a;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:.2s;}
                                                                        . rm - btn - cancel: hover {background: #e8eaf3;}
                                                                            . rm - btn - submit {padding: 11px24px;
                                                                                border - radius: 10px;
                                                                                border: none;
                                                                                background:                             #f1523d;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:7px;}
                                                                                . rm - btn - submit: hover {background: #d4422e;transform:translateY(-1px);}
                                                                                    . rm - btn - submit: disabled {opacity: .5;
                                                                                        cursor: not - allowed;
                                                                                        transform: none;}
                                                                                    <  / style >

                                                                                    {{ --TOMBOL PEMICU(taruh dimanapunkamumaudihalamandetailnovel)--}}
                                                                                    < button type = "button";
                                                                                    onclick       = "document.getElementById('reportModal').classList.add('open')";
                                                                                    style         = "display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:10px;border:1px solid rgba(241,82,61,.25);background:#fef0ee;color:#f1523d;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:.2s;";
                                                                                    onmouseover   = "this.style.background='#fdd8d4'";
                                                                                    onmouseout    = "this.style.background='#fef0ee'" >
                                                                                    🚩 LaporkanNovel
                                                                                    <  / button >

                                                                                    {{ --MODAL--}}
                                                                                    < divclass  = "report-modal-overlay"id = "reportModal" >
                                                                                    < divclass  = "report-modal-box" >

                                                                                    < divclass     = "rm-header" >
                                                                                    < divclass     = "rm-title" > 🚩 LaporkanNovel <  / div >
                                                                                    < buttonclass  = "rm-close"onclick = "document.getElementById('reportModal').classList.remove('open')" > ✕ <  / button >
                                                                                    <  / div >
                                                                                    < divclass  = "rm-sub" > Bantu kamimenjagakualitaskontendenganmelaporkanpelanggaran .  <  / div >

                                                                                    {{ --Info novel--}}
                                                                                    < divclass  = "rm-novel-chip" >
                                                                                    < divclass  = "rm-novel-ico" > 📚 <  / div >
                                                                                    < div >
                                                                                    < divclass  = "rm-novel-title" > {{ $novel->judul}} <  / div >
                                                                                    < divclass  = "rm-novel-author" > oleh {{ $novel->author->name ?? '—'}} <  / div >
                                                                                    <  / div >
                                                                                    <  / div >

                                                                                    @if (session('error') && str_contains(session('error'), 'sudah pernah')) {
                                                                                        < div style = "background:#fef0ee;border:1px solid rgba(241,82,61,.2);border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:13px;color:#c43020;font-family:'Plus Jakarta Sans',sans-serif;" >
                                                                                        ⚠ {{session('error');}}
                                                                                        <  / div >
                                                                                        @endif

                                                                                        < form method = "POST"action = "{{ route('reader.reports.store', $novel->id) }}"id = "reportForm" >
                                                                                        @csrf

                                                                                        < labelclass  = "rm-label" > Pilih AlasanLaporan <  / label >
                                                                                        < divclass    = "rm-options"id   = "reasonOptions" >
                                                                                        @php;
                                                                                    }

                                                                                    $alasanList = [
                                                                                        ['value' => 'Konten Dewasa', 'icon' => '🔞', 'sub' => 'Konten seksual atau tidak pantas'],
                                                                                        ['value' => 'Kekerasan Berlebihan', 'icon' => '⚔️', 'sub' => 'Konten kekerasan ekstrem'],
                                                                                        ['value' => 'Plagiarisme', 'icon' => '©️', 'sub' => 'Konten hasil menyalin karya orang lain'],
                                                                                        ['value' => 'Ujaran Kebencian', 'icon' => '🚫', 'sub' => 'Konten rasis, diskriminatif, atau menyinggung'],
                                                                                        ['value' => 'Spam / Konten Tidak Relevan', 'icon' => '🗑️', 'sub' => 'Konten tidak bermutu atau spam'],
                                                                                        ['value' => 'Lainnya', 'icon' => '💬', 'sub' => 'Alasan lain (jelaskan di bawah)'],
                                                                                    ];
                                                                                    @endphp;

                                                                                    @foreach ($alasanList as $item) {
                                                                                        < labelclass  = "rm-option"onclick = "selectReason(this, '{{ $item['value'] }}')" >
                                                                                        < input type = "radio"name = "alasan"value = "{{ $item['value'] }}"{{old('alasan') === $item['value'] ? 'checked' : ''}} >
                                                                                        < divclass  = "rm-option-ico" > {{ $item['icon'];}} <  / div >
                                                                                        < div >
                                                                                        < divclass  = "rm-option-label" > {{ $item['value'];}} <  / div >
                                                                                        < divclass  = "rm-option-sub" > {{ $item['sub'];}} <  / div >
                                                                                        <  / div >
                                                                                        <  / label >
                                                                                        @endforeach
                                                                                        <  / div >
                                                                                        @error('alasan') < div style = "font-size:12px;color:#f1523d;margin:-12px 0 12px;" > {{ $message}} <  / div > @enderror

                                                                                        < labelclass  = "rm-label"for  = "rmDeskripsi" > Deskripsi Tambahan(opsional) {
                                                                                            <  / label >
                                                                                            < textarea name = "deskripsi"id = "rmDeskripsi"class  = "rm-textarea";
                                                                                        }

                                                                                        placeholder = "Ceritakan lebih detail tentang pelanggaran yang kamu temukan…" >
                                                                                            {{old('deskripsi');}} <  / textarea >
                                                                                        @error('deskripsi') < div style = "font-size:12px;color:#f1523d;margin-top:4px;" > {{ $message}} <  / div > @enderror

                                                                                        < divclass  = "rm-footer" >
                                                                                        < button type = "button"class  = "rm-btn-cancel";
                                                                                        onclick = "document.getElementById('reportModal').classList.remove('open')" >
                                                                                        Batal
                                                                                        <  / button >
                                                                                        < button type = "submit"class  = "rm-btn-submit"id = "rmSubmitBtn"disabled >
                                                                                        🚩 KirimLaporan
                                                                                        <  / button >
                                                                                        <  / div >
                                                                                        <  / form >

                                                                                        <  / div >
                                                                                        <  / div >

                                                                                        < script >
                                                                                        function selectReason(el, val)
                                                                                            {
                                                                                            document . querySelectorAll('.rm-option') . foreach (o => o . classList . remove('selected'));
                                                                                            el . classList . add('selected');
                                                                                            el . querySelector('input[type=radio]') . checked   = true;
                                                                                            document . getElementById('rmSubmitBtn') . disabled = false;
                                                                                        }

// Jika ada old value (validasi gagal), restore selected state
                                                                                        document . addEventListener('DOMContentLoaded', () => {
                                                                                            const checked = document . querySelector('.rm-option input[type=radio]:checked');
                                                                                            if (checked) {
                                                                                                checked . closest('.rm-option') . classList . add('selected');
                                                                                                document . getElementById('rmSubmitBtn') . disabled = false;
                                                                                                // Buka modal otomatis jika ada error
                                                                                                @if ($errors->has('alasan') || $errors->has('deskripsi')) {
                                                                                                    document . getElementById('reportModal') . classList . add('open');
                                                                                                }

                                                                                                @endif;
                                                                                            }
                                                                                        });

// Tutup modal klik luar
                                                                                        document . getElementById('reportModal') . addEventListener('click', function (e) {
                                                                                            if (e . target === this) {
                                                                                                this . classList . remove('open');
                                                                                            }

                                                                                        });
                                                                                        <  / script >
                                                                                    }
