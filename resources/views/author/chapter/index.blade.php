@extends('author.layouts.app')

@section('content')

<style>
/* ==== FIX RATA TOMBOL AKSI ==== */
.acts {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.act-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>

<div id="ns"></div>

{{-- ================= HEADER ================= --}}
<div class="pg-head">
    <div class="pg-left">
        <a href="{{ route('author.novel.index') }}" class="pg-back">← Kembali ke Novel</a>
        <div class="pg-title">📖 {{ $novel->title }}</div>
        <div class="pg-sub">Kelola chapter novelmu di sini</div>
    </div>
    <a href="{{ route('author.chapter.create', $novel->id) }}" class="pg-add">
        + Tambah Chapter
    </a>
</div>

{{-- ================= TABLE CARD ================= --}}
<div class="tcard">

    <div class="tcard-head">
        <div class="tcounts">
            <div class="tcount-item">
                <div class="tcount-num">{{ $total }}</div>
                <div class="tcount-lbl">Total Chapter</div>
            </div>
            <div class="tcount-item">
                <div class="tcount-num" style="color:var(--green)">
                    {{ $published }}
                </div>
                <div class="tcount-lbl">Published</div>
            </div>
            <div class="tcount-item">
                <div class="tcount-num" style="color:var(--ink-3)">
                    {{ $draft }}
                </div>
                <div class="tcount-lbl">Draft</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50">#</th>
                <th width="70">No.</th>
                <th>Judul Chapter</th>
                <th width="120">Status</th>
                <th width="280" class="tc">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($chapters as $index => $chapter)
            <tr>
                <td>{{ $index + 1 }}</td>

                <td>
                    <span class="urutan-badge">
                        {{ $chapter->chapter_number }}
                    </span>
                </td>

                <td>
                    <div class="chapter-name">
                        {{ $chapter->title }}
                    </div>
                    <div class="chapter-time">
                        Diupdate {{ $chapter->updated_at->diffForHumans() }}
                    </div>
                </td>

                <td>
                    @if($chapter->status === 'published')
                        <span class="pill pill-pub">Published</span>
                    @else
                        <span class="pill pill-dft">Draft</span>
                    @endif
                </td>

                <td class="td-c">
                    <div class="acts">

                        <a href="{{ route('author.chapter.show', [$novel->id, $chapter->id]) }}"
                           class="act-btn btn-view">👁 View</a>

                        <a href="{{ route('author.chapter.edit', [$novel->id, $chapter->id]) }}"
                           class="act-btn btn-edit">✏️ Edit</a>

                        {{-- Toggle --}}
                        <form action="{{ route('author.chapter.toggle', [$novel->id, $chapter->id]) }}"
                              method="POST"
                              class="toggle-form">
                            @csrf
                            @method('PATCH')

                            @if($chapter->status === 'published')
                                <button type="submit" class="act-btn btn-dft">
                                    Draft
                                </button>
                            @else
                                <button type="submit" class="act-btn btn-pub">
                                    Publish
                                </button>
                            @endif
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('author.chapter.destroy', [$novel->id, $chapter->id]) }}"
                              method="POST"
                              class="del-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="act-btn btn-del"
                                    onclick="openModal(this)">🗑</button>
                        </form>

                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-ico">📭</div>
                        <div class="empty-txt">
                            Belum ada chapter
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

{{-- ================= MODAL DELETE ================= --}}
<div class="modal-bg" id="delModal">
    <div class="modal-box">
        <div class="modal-ico">🗑️</div>
        <div class="modal-title">Hapus Chapter?</div>
        <div class="modal-msg">
            Tindakan ini tidak bisa dibatalkan.<br>
            Chapter akan dihapus permanen.
        </div>
        <div class="modal-btns">
            <button class="modal-btn mbtn-cancel" onclick="closeModal()">Batal</button>
            <button class="modal-btn mbtn-del" id="delConfirm">Ya, Hapus</button>
        </div>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
let pendingForm=null;

function openModal(btn){
    const row=btn.closest('tr');
    pendingForm=row.querySelector('form.del-form');
    document.getElementById('delModal').classList.add('show');
}

function closeModal(){
    document.getElementById('delModal').classList.remove('show');
    pendingForm=null;
}

document.getElementById('delConfirm').onclick=function(){
    if(pendingForm) pendingForm.submit();
};

document.getElementById('delModal').addEventListener('click',function(e){
    if(e.target===this) closeModal();
});
</script>

{{-- ================= NOTIFICATION ================= --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded',function(){
    alert("{{ session('success') }}");
});
</script>
@endif

@endsection