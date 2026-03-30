@extends('author.layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════
     NOTIFICATION STACK  (bottom-right)
═══════════════════════════════════════════ --}}
<div id="notifStack" style="
  position:fixed;bottom:28px;right:28px;z-index:9999;
  display:flex;flex-direction:column-reverse;gap:10px;pointer-events:none;">
</div>

<style>
.notif{
  pointer-events:all;
  display:flex;align-items:center;gap:12px;
  background:rgba(255,255,255,.95);
  backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
  border:1px solid rgba(255,255,255,.8);
  border-radius:14px;padding:14px 16px;
  min-width:300px;max-width:360px;
  box-shadow:0 8px 32px rgba(24,25,42,.15),0 2px 8px rgba(24,25,42,.08);
  animation:notifIn .4s cubic-bezier(.16,1,.3,1) both;
  position:relative;overflow:hidden;
  font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;
}
.notif.hide{animation:notifOut .3s ease forwards;}
.notif-ico{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0;}
.notif-body{flex:1;}
.notif-title{font-size:13px;font-weight:700;color:#18192a;line-height:1.2;}
.notif-msg{font-size:12px;color:#5a5f7a;margin-top:2px;line-height:1.4;}
.notif-x{width:26px;height:26px;border-radius:7px;background:#f7f8fc;border:1px solid #e0e4ef;color:#9698ae;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;transition:all .2s;flex-shrink:0;}
.notif-x:hover{background:#e0e4ef;color:#18192a;}
.notif-bar{position:absolute;bottom:0;left:0;height:3px;border-radius:99px;animation:notifBar 4.5s linear forwards;}
@keyframes notifIn {from{opacity:0;transform:translateY(20px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes notifOut{to{opacity:0;transform:translateY(10px) scale(.9);max-height:0;margin:0;padding:0;overflow:hidden;}}
@keyframes notifBar{from{width:100%}to{width:0%}}
</style>

<script>
const _NC={
  success:{b:'#00c9a7',i:'#e0faf5',t:'#00a88a',ic:'✓'},
  error:  {b:'#f1523d',i:'#fef0ee',t:'#c43020',ic:'✗'},
  info:   {b:'#3d5af1',i:'#eef0fe',t:'#2d48e0',ic:'ℹ'},
  warn:   {b:'#f1a83d',i:'#fef6e6',t:'#c48020',ic:'!'},
};
function showNotif(type,title,msg,duration){
  const c=_NC[type]||_NC.info;
  const el=document.createElement('div');
  el.className='notif';
  el.innerHTML=`
    <div class="notif-ico" style="background:${c.i};color:${c.t}">${c.ic}</div>
    <div class="notif-body">
      <div class="notif-title">${title}</div>
      <div class="notif-msg">${msg}</div>
    </div>
    <button class="notif-x" type="button" onclick="closeNotif(this.parentElement)">✕</button>
  `;
  const bar=document.createElement('div');
  bar.className='notif-bar';bar.style.background=c.b;
  el.appendChild(bar);
  document.getElementById('notifStack').appendChild(el);
  setTimeout(()=>closeNotif(el),duration||4500);
}
function closeNotif(el){
  if(!el||el.classList.contains('hide'))return;
  el.classList.add('hide');
  setTimeout(()=>el&&el.remove(),350);
}

// Auto-fire dari session Laravel
document.addEventListener('DOMContentLoaded',function(){
  @if(session('success'))
    showNotif('success','Berhasil ✓',@json(session('success')));
  @endif
  @if(session('error'))
    showNotif('error','Terjadi Kesalahan',@json(session('error')));
  @endif
  @if(session('warning'))
    showNotif('warn','Perhatian',@json(session('warning')));
  @endif
  @if(session('info'))
    showNotif('info','Informasi',@json(session('info')));
  @endif
});
</script>

{{-- ═══════════════════════════════════════════
     MODAL KONFIRMASI HAPUS KOMENTAR
═══════════════════════════════════════════ --}}
<div id="deleteModal" style="
  position:fixed;inset:0;background:rgba(24,25,42,.55);z-index:8888;
  display:flex;align-items:center;justify-content:center;padding:20px;
  opacity:0;pointer-events:none;transition:opacity .2s;">
  <div id="deleteModalBox" style="
    background:#fff;border:1px solid #e0e4ef;border-radius:18px;
    padding:32px;max-width:400px;width:100%;
    box-shadow:0 20px 60px rgba(24,25,42,.2);
    transform:scale(.95);transition:all .25s cubic-bezier(.34,1.56,.64,1);
    font-family:'Plus Jakarta Sans','Segoe UI',sans-serif;">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
      <div style="width:48px;height:48px;border-radius:14px;background:#fef0ee;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🗑️</div>
      <div style="font-size:18px;font-weight:800;color:#18192a;">Hapus Komentar?</div>
    </div>
    <div style="font-size:13.5px;color:#5a5f7a;line-height:1.6;margin-bottom:24px;">
      Komentar ini akan dihapus secara permanen dan tidak dapat dipulihkan kembali.
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end;">
      <button type="button" onclick="closeDeleteModal()" style="background:#f7f8fc;border:1.5px solid #e0e4ef;border-radius:11px;padding:10px 20px;font-family:inherit;font-size:13px;font-weight:700;color:#5a5f7a;cursor:pointer;transition:all .2s;">Batal</button>
      <button type="button" id="deleteConfirmBtn" style="background:#f1523d;color:white;border:none;border-radius:11px;padding:10px 20px;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
let _deleteFormId=null;
function openDeleteModal(formId){
  _deleteFormId=formId;
  const m=document.getElementById('deleteModal');
  m.style.opacity='1';m.style.pointerEvents='all';
  document.getElementById('deleteModalBox').style.transform='scale(1)';
}
function closeDeleteModal(){
  const m=document.getElementById('deleteModal');
  m.style.opacity='0';m.style.pointerEvents='none';
  document.getElementById('deleteModalBox').style.transform='scale(.95)';
  _deleteFormId=null;
}
document.getElementById('deleteConfirmBtn').addEventListener('click',function(){
  if(_deleteFormId) document.getElementById(_deleteFormId).submit();
  closeDeleteModal();
});
</script>

{{-- ═══════════════════════════════════════════
     PAGE CONTENT  (sistem tidak diubah)
═══════════════════════════════════════════ --}}

<h1 class="h3 mb-4">Komentar Pembaca</h1>

<div class="card shadow">
    <div class="card-body">

        @if($comments->count() > 0)

            <div class="list-group">

                @foreach($comments as $comment)
                    <div class="list-group-item border-0 mb-3 shadow-sm rounded-3 p-4">

                        <div class="d-flex justify-content-between">

                            {{-- KIRI --}}
                            <div style="width:75%;">

                                <div class="d-flex align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold">
                                        {{ $comment->user->name }}
                                    </h6>

                                    <small class="text-muted ms-2">
                                        • {{ $comment->created_at->diffForHumans() }}
                                    </small>

                                    @if($comment->created_at->diffInHours(now()) < 24)
                                        <span class="badge bg-success ms-2">Baru</span>
                                    @endif
                                </div>

                                <div class="text-muted small mb-2">
                                    <strong>Novel:</strong> {{ $comment->chapter->novel->judul }} |
                                    <strong>Chapter:</strong> {{ $comment->chapter->judul_chapter }}
                                </div>

                                <div class="bg-light rounded-3 p-3">
                                    {{ $comment->komentar }}
                                </div>

                            </div>

                            {{-- KANAN --}}
                            <div style="width:150px;" class="text-end">

                                <a href="{{ route('author.comment.show', $comment->id) }}"
                                   class="btn btn-primary btn-sm w-100 mb-2">
                                    💬 Balasan
                                    <span class="badge bg-light text-dark ms-1">
                                        {{ $comment->replies->count() }}
                                    </span>
                                </a>

                                {{-- Form hapus — dipanggil lewat modal, bukan confirm() --}}
                                <form id="delete-comment-{{ $comment->id }}"
                                      action="{{ route('author.comment.destroy', $comment->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-sm w-100"
                                            onclick="openDeleteModal('delete-comment-{{ $comment->id }}')">
                                        🗑 Hapus
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $comments->links('pagination::bootstrap-5') }}
            </div>

        @else

            <div class="text-center text-muted py-4">
                Belum ada komentar.
            </div>

        @endif

    </div>
</div>

@endsection