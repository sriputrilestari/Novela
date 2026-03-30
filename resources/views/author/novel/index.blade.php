@extends('author.layouts.app')

@section('content')

{{-- ═══════════════════════════════════════════
     NOTIFICATION STACK  (bottom-right, matching profile & comments)
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

// Auto-fire from Laravel session
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
     MODAL KONFIRMASI HAPUS
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
      <div style="font-size:18px;font-weight:800;color:#18192a;">Hapus Novel?</div>
    </div>
    <div style="font-size:13.5px;color:#5a5f7a;line-height:1.6;margin-bottom:24px;">
      Novel <strong id="deleteNovelTitle" style="color:#18192a;"></strong> akan dihapus permanen beserta semua chapter-nya. Tindakan ini tidak dapat dibatalkan.
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end;">
      <button type="button" onclick="closeDeleteModal()" style="background:#f7f8fc;border:1.5px solid #e0e4ef;border-radius:11px;padding:10px 20px;font-family:inherit;font-size:13px;font-weight:700;color:#5a5f7a;cursor:pointer;transition:all .2s;">Batal</button>
      <button type="button" id="deleteConfirmBtn" style="background:#f1523d;color:white;border:none;border-radius:11px;padding:10px 20px;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
let _deleteFormId=null;
function openDeleteModal(formId,title){
  _deleteFormId=formId;
  document.getElementById('deleteNovelTitle').textContent='"'+title+'"';
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

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Novel Saya</h1>
        <a href="{{ route('author.novel.create') }}" class="btn btn-primary">
            + Tambah Novel
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Judul</th>
                            <th>Genre</th>
                            <th width="120">Cover</th>
                            <th width="130">Status Cerita</th>
                            <th width="150">Status Approval</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($novels as $novel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $novel->judul }}</strong>
                                </td>

                                <td>
                                    {{ $novel->genre->nama_genre ?? '-' }}
                                </td>

                                <td class="text-center">
                                    @if ($novel->cover)
                                        <img
                                            src="{{ asset('storage/' . $novel->cover) }}"
                                            alt="cover"
                                            class="img-thumbnail"
                                            style="max-height: 80px;">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>

                                {{-- STATUS CERITA --}}
                                <td class="text-center">
                                    <span class="badge
                                        {{ $novel->status === 'completed' ? 'badge-primary' : 'badge-info' }}">
                                        {{ ucfirst($novel->status) }}
                                    </span>
                                </td>

                                {{-- STATUS APPROVAL --}}
                                <td class="text-center">
                                    <span class="badge
                                        {{ $novel->approval_status === 'published' ? 'badge-success' :
                                           ($novel->approval_status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ ucfirst($novel->approval_status) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('author.chapter.index', $novel->id) }}"
                                       class="btn btn-sm btn-primary">
                                        +Chapter
                                    </a>

                                    <a href="{{ route('author.novel.edit', $novel->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    {{-- Form hapus — dipanggil lewat modal, bukan confirm() --}}
                                    <form id="delete-novel-{{ $novel->id }}"
                                          action="{{ route('author.novel.destroy', $novel->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                onclick="openDeleteModal('delete-novel-{{ $novel->id }}','{{ addslashes($novel->judul) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada novel
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection