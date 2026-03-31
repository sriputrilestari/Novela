@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{--blue:#3d5af1;--blue-lt:#eef0fe;--green:#00c9a7;--green-lt:#e0faf5;--amber:#f1a83d;--amber-lt:#fef6e6;--red:#f1523d;--red-lt:#fef0ee;--ink:#18192a;--ink-2:#5a5f7a;--ink-3:#9698ae;--line:#e8eaf3;--bg:#f4f6fc;--white:#ffffff;--radius:16px;--shadow:0 2px 16px rgba(24,25,42,.07);--shadow-h:0 8px 32px rgba(24,25,42,.13);}
*{box-sizing:border-box;}
.dash{font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);padding-bottom:72px;}
@keyframes up{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.a1{animation:up .5s .00s ease both}.a2{animation:up .5s .07s ease both}.a3{animation:up .5s .13s ease both}

/* NOTIFICATION */
#ns{position:fixed;bottom:28px;right:28px;z-index:9999;display:flex;flex-direction:column-reverse;gap:10px;pointer-events:none;}
.nt{pointer-events:all;position:relative;overflow:hidden;display:flex;align-items:center;gap:12px;background:rgba(255,255,255,.97);backdrop-filter:blur(20px);border:1px solid var(--line);border-radius:14px;padding:14px 16px;min-width:300px;max-width:350px;box-shadow:0 8px 28px rgba(24,25,42,.12);}
@keyframes notIn{from{opacity:0;transform:translateY(16px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes notOt{to{opacity:0;transform:translateY(8px) scale(.94);max-height:0;padding:0;margin:0;overflow:hidden}}
@keyframes bar{from{width:100%}to{width:0%}}
.nt{animation:notIn .4s cubic-bezier(.16,1,.3,1) both;}
.nt.out{animation:notOt .28s ease forwards;}
.nt-ico{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.nt-ttl{font-size:13px;font-weight:700;color:var(--ink);}
.nt-msg{font-size:12px;color:var(--ink-2);margin-top:1px;}
.nt-x{margin-left:auto;flex-shrink:0;width:24px;height:24px;border-radius:6px;background:#f4f6fc;border:1px solid var(--line);color:var(--ink-3);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;transition:.18s;}
.nt-x:hover{background:var(--line);color:var(--ink);}
.nt-bar{position:absolute;bottom:0;left:0;height:2.5px;border-radius:99px;animation:bar 4.5s linear forwards;}

.box{background:var(--white);border:1px solid var(--line);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:16px;}
.box-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px 14px;border-bottom:1px solid var(--line);}
.box-title{font-size:14.5px;font-weight:700;color:var(--ink);}
.box-sub{font-size:12px;color:var(--ink-3);margin-top:2px;}
.box-body{padding:24px;}

.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
@media(max-width:640px){.grid-2{grid-template-columns:1fr}}

.detail-row{display:flex;flex-direction:column;gap:4px;padding:14px 0;border-bottom:1px solid #f2f4fb;}
.detail-row:last-child{border-bottom:none;}
.detail-label{font-size:11px;font-weight:700;color:var(--ink-3);text-transform:uppercase;letter-spacing:.6px;}
.detail-value{font-size:13.5px;color:var(--ink);font-weight:500;}

.tag{border-radius:99px;padding:4px 11px;font-size:11px;font-weight:700;white-space:nowrap;}
.tag-pending{background:var(--amber-lt);color:#b07010;}
.tag-reviewed{background:var(--green-lt);color:#00a08a;}
.tag-rejected{background:var(--red-lt);color:#c43020;}

.back-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:10px;border:1px solid var(--line);background:#f4f6fc;color:var(--ink-2);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;transition:.2s;margin-bottom:20px;}
.back-btn:hover{background:var(--line);color:var(--ink);}

.action-bar{display:flex;gap:10px;flex-wrap:wrap;padding:18px 22px;border-top:1px solid var(--line);background:#f8f9fe;}
.btn-act{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:.2s;}
.btn-act:hover{transform:translateY(-1px);}
.btn-review{background:var(--green-lt);color:#00a08a;}
.btn-warn{background:var(--amber-lt);color:#b07010;}
.btn-reject{background:var(--red-lt);color:var(--red);}
.btn-delete{background:#f0e8ff;color:#8b2cf5;}

/* MODAL */
.modal-overlay{position:fixed;inset:0;background:rgba(24,25,42,.45);z-index:8000;display:flex;align-items:center;justify-content:center;padding:24px;opacity:0;pointer-events:none;transition:.25s;}
.modal-overlay.open{opacity:1;pointer-events:all;}
.modal-box{background:var(--white);border-radius:20px;padding:28px;width:100%;max-width:480px;box-shadow:0 24px 64px rgba(24,25,42,.18);transform:translateY(20px) scale(.97);transition:.3s cubic-bezier(.16,1,.3,1);}
.modal-overlay.open .modal-box{transform:translateY(0) scale(1);}
.modal-title{font-size:16px;font-weight:800;color:var(--ink);margin-bottom:6px;}
.modal-sub{font-size:13px;color:var(--ink-3);margin-bottom:20px;}
.modal-label{font-size:12px;font-weight:700;color:var(--ink-2);text-transform:uppercase;letter-spacing:.6px;display:block;margin-bottom:8px;}
.modal-textarea{width:100%;background:#f7f8fc;border:1.5px solid var(--line);border-radius:10px;padding:12px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;color:var(--ink);outline:none;resize:vertical;min-height:90px;transition:.2s;}
.modal-textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(61,90,241,.1);}
.modal-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px;}
.btn-modal-cancel{padding:10px 20px;border-radius:10px;border:1px solid var(--line);background:#f4f6fc;color:var(--ink-2);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:.2s;}
.btn-modal-cancel:hover{background:var(--line);}
.btn-modal-submit{padding:10px 22px;border-radius:10px;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:.2s;color:#fff;}
</style>

<div id="ns"></div>
<script>
const NC={success:{b:'#00c9a7',i:'#e0faf5',t:'#00a88a',ic:'✓'},error:{b:'#f1523d',i:'#fef0ee',t:'#c43020',ic:'✗'},info:{b:'#3d5af1',i:'#eef0fe',t:'#2d48e0',ic:'ℹ'},warn:{b:'#f1a83d',i:'#fef6e6',t:'#c48020',ic:'!'}};
function showN(type,title,msg){const c=NC[type]||NC.info,el=document.createElement('div');el.className='nt';el.innerHTML=`<div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div><div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div><button class="nt-x" onclick="closeN(this.parentElement)">✕</button>`;const bar=document.createElement('div');bar.className='nt-bar';bar.style.background=c.b;el.appendChild(bar);document.getElementById('ns').appendChild(el);setTimeout(()=>closeN(el),4500);}
function closeN(el){if(!el||el.classList.contains('out'))return;el.classList.add('out');setTimeout(()=>el&&el.remove(),300);}
document.addEventListener('DOMContentLoaded',()=>{
  @if(session('success')) showN('success','Berhasil',@json(session('success'))); @endif
  @if(session('error'))   showN('error','Gagal',@json(session('error'))); @endif
});
</script>

{{-- MODAL PERINGATAN --}}
<div class="modal-overlay" id="modalWarn">
  <div class="modal-box">
    <div class="modal-title">⚠️ Kirim Peringatan ke Author</div>
    <div class="modal-sub">Peringatan akan dicatat pada laporan ini.</div>
    <form method="POST" action="{{ route('admin.reports.warn', $report->id) }}">
      @csrf
      <label class="modal-label">Catatan Peringatan</label>
      <textarea name="catatan_admin" class="modal-textarea" placeholder="Contoh: Konten melanggar pedoman komunitas. Harap perbaiki dalam 3 hari." required></textarea>
      <div class="modal-actions">
        <button type="button" class="btn-modal-cancel" onclick="closeModal('modalWarn')">Batal</button>
        <button type="submit" class="btn-modal-submit" style="background:var(--amber);">⚠️ Kirim Peringatan</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL TOLAK --}}
<div class="modal-overlay" id="modalReject">
  <div class="modal-box">
    <div class="modal-title">✕ Tolak Laporan</div>
    <div class="modal-sub">Laporan akan ditolak.</div>
    <form method="POST" action="{{ route('admin.reports.reject', $report->id) }}">
      @csrf
      <label class="modal-label">Catatan (opsional)</label>
      <textarea name="catatan_admin" class="modal-textarea" placeholder="Alasan penolakan..."></textarea>
      <div class="modal-actions">
        <button type="button" class="btn-modal-cancel" onclick="closeModal('modalReject')">Batal</button>
        <button type="submit" class="btn-modal-submit" style="background:var(--red);">✕ Tolak</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL HAPUS --}}
<div class="modal-overlay" id="modalDelete">
  <div class="modal-box">
    <div class="modal-title">🗑️ Hapus Novel</div>
    <div class="modal-sub">Novel <strong>{{ $report->novel->judul }}</strong> akan dihapus permanen.</div>
    <div style="background:var(--red-lt);border:1px solid rgba(241,82,61,.2);border-radius:12px;padding:14px 16px;margin-bottom:4px;">
      <div style="font-size:13px;color:#c43020;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">⚠ Tindakan ini tidak dapat dibatalkan!</div>
    </div>
    <div class="modal-actions">
      <button type="button" class="btn-modal-cancel" onclick="closeModal('modalDelete')">Batal</button>
      <form method="POST" action="{{ route('admin.reports.deleteNovel', $report->id) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn-modal-submit" style="background:#8b2cf5;">🗑️ Hapus</button>
      </form>
    </div>
  </div>
</div>

<div class="dash">

  <a href="{{ route('admin.reports.index') }}" class="back-btn a1">← Kembali ke Daftar Laporan</a>

  <div class="grid-2 a2">

    {{-- INFO LAPORAN --}}
    <div class="box">
      <div class="box-head">
        <div>
          <div class="box-title">🚩 Detail Laporan</div>
          <div class="box-sub">ID #{{ $report->id }} · {{ $report->created_at->format('d M Y, H:i') }}</div>
        </div>
        <span class="tag tag-{{ $report->status }}">
          @if($report->status==='pending') ⏳ @elseif($report->status==='reviewed') ✅ @else ✕ @endif
          {{ $report->statusLabel() }}
        </span>
      </div>
      <div class="box-body">
        <div class="detail-row">
          <div class="detail-label">Pelapor</div>
          <div class="detail-value">{{ $report->user->name }}</div>
          <div style="font-size:12px;color:var(--ink-3);">{{ $report->user->email }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Alasan Laporan</div>
          <div class="detail-value">{{ $report->alasan }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Deskripsi</div>
          <div class="detail-value">{{ $report->deskripsi ?: '—' }}</div>
        </div>
        @if($report->catatan_admin)
          <div class="detail-row">
            <div class="detail-label">Catatan Admin</div>
            <div class="detail-value" style="background:var(--amber-lt);padding:10px 14px;border-radius:10px;border:1px solid rgba(241,168,61,.2);">
              {{ $report->catatan_admin }}
            </div>
          </div>
        @endif
      </div>
    </div>

    {{-- INFO NOVEL --}}
    <div class="box">
      <div class="box-head">
        <div>
          <div class="box-title">📚 Novel yang Dilaporkan</div>
          <div class="box-sub">Informasi novel terkait laporan</div>
        </div>
      </div>
      <div class="box-body">
        <div class="detail-row">
          <div class="detail-label">Judul Novel</div>
          <div class="detail-value">{{ $report->novel->judul }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Penulis (Author)</div>
          <div class="detail-value">{{ $report->novel->author->name ?? '—' }}</div>
          <div style="font-size:12px;color:var(--ink-3);">{{ $report->novel->author->email ?? '' }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Status Novel</div>
          <div class="detail-value">{{ $report->novel->approval_status ?? '—' }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Dipublikasikan</div>
          <div class="detail-value">{{ $report->novel->created_at?->format('d M Y') ?? '—' }}</div>
        </div>
      </div>
    </div>

  </div>

  {{-- ACTION BAR --}}
  @if($report->status === 'pending')
    <div class="box a3">
      <div class="box-head">
        <div>
          <div class="box-title">⚡ Tindakan Admin</div>
          <div class="box-sub">Pilih aksi untuk laporan ini</div>
        </div>
      </div>
      <div class="action-bar">

        {{-- Review --}}
        <form method="POST" action="{{ route('admin.reports.review', $report->id) }}">
          @csrf
          <button type="submit" class="btn-act btn-review">✅ Tandai Direview</button>
        </form>

        {{-- Peringatan --}}
        <button class="btn-act btn-warn" onclick="document.getElementById('modalWarn').classList.add('open')">
          ⚠️ Beri Peringatan Author
        </button>

        {{-- Tolak --}}
        <button class="btn-act btn-reject" onclick="document.getElementById('modalReject').classList.add('open')">
          ✕ Tolak Laporan
        </button>

        {{-- Hapus Novel --}}
        <button class="btn-act btn-delete" onclick="document.getElementById('modalDelete').classList.add('open')">
          🗑️ Hapus Novel
        </button>

      </div>
    </div>
  @endif

</div>

<script>
function closeModal(id){ document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(el=>{
  el.addEventListener('click',e=>{ if(e.target===el) el.classList.remove('open'); });
});
</script>

@endsection
