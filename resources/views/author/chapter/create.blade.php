@extends('author.layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--blue:#3d5af1;--blue-lt:#eef0fe;--blue-md:#dde2fc;--green:#00c9a7;--green-lt:#e0faf5;--red:#f1523d;--red-lt:#fef0ee;--ink:#18192a;--ink-2:#5a5f7a;--ink-3:#9698ae;--line:#e8eaf3;}
.ch{font-family:'Plus Jakarta Sans',sans-serif;}
@keyframes nIn{from{opacity:0;transform:translateY(16px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes nOut{to{opacity:0;transform:translateY(8px) scale(.94);max-height:0;padding:0;margin:0;overflow:hidden}}
@keyframes nBar{from{width:100%}to{width:0%}}
@keyframes up{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

/* notif */
#ns{position:fixed;bottom:28px;right:28px;z-index:9999;display:flex;flex-direction:column-reverse;gap:10px;pointer-events:none;}
.nt{pointer-events:all;position:relative;overflow:hidden;display:flex;align-items:center;gap:12px;background:rgba(255,255,255,.97);backdrop-filter:blur(20px);border:1px solid var(--line);border-radius:14px;padding:14px 16px;min-width:300px;max-width:350px;box-shadow:0 8px 28px rgba(24,25,42,.12);animation:nIn .4s cubic-bezier(.16,1,.3,1) both;}
.nt.out{animation:nOut .28s ease forwards;}
.nt-ico{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.nt-ttl{font-size:13px;font-weight:700;color:var(--ink);}
.nt-msg{font-size:12px;color:var(--ink-2);margin-top:1px;}
.nt-x{margin-left:auto;flex-shrink:0;width:24px;height:24px;border-radius:6px;background:#f4f6fc;border:1px solid var(--line);color:var(--ink-3);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;transition:.18s;}
.nt-x:hover{background:var(--line);color:var(--ink);}
.nt-bar{position:absolute;bottom:0;left:0;height:2.5px;border-radius:99px;animation:nBar 4.5s linear forwards;}

/* header */
.pg-head{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px 26px;margin-bottom:20px;box-shadow:0 2px 12px rgba(24,25,42,.06);animation:up .4s ease both;}
.pg-back{display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--ink-3);text-decoration:none;margin-bottom:6px;}
.pg-back:hover{color:var(--blue);}
.pg-title{font-size:20px;font-weight:800;color:var(--ink);}
.pg-sub{font-size:12.5px;color:var(--ink-3);margin-top:3px;}

/* form card */
.fcard{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 2px 12px rgba(24,25,42,.06);overflow:hidden;animation:up .4s .06s ease both;}
.fcard-head{padding:16px 24px;border-bottom:1px solid var(--line);background:#f8f9fe;}
.fcard-title{font-size:14px;font-weight:700;color:var(--ink);}
.fcard-body{padding:26px 28px;}

/* fields */
.f-2col{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
@media(max-width:640px){.f-2col{grid-template-columns:1fr;}}
.f-group{margin-bottom:20px;}
.f-label{display:block;font-size:13px;font-weight:700;color:var(--ink);margin-bottom:7px;}
.f-ctrl{width:100%;border:1.5px solid var(--line);border-radius:10px;padding:10px 14px;font-family:inherit;font-size:13.5px;color:var(--ink);background:#fff;transition:.2s;outline:none;}
.f-ctrl:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(61,90,241,.1);}
.f-ctrl.err{border-color:var(--red);}
.f-ctrl.err:focus{box-shadow:0 0 0 3px rgba(241,82,61,.1);}
textarea.f-ctrl{resize:vertical;line-height:1.75;}
.f-err{font-size:12px;font-weight:600;color:var(--red);margin-top:5px;}

/* status picker */
.st-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:8px;}
.st-r{display:none;}
.st-lbl{display:flex;flex-direction:column;align-items:center;gap:5px;background:#f8f9fe;border:2px solid var(--line);border-radius:12px;padding:18px 12px;cursor:pointer;transition:.2s;text-align:center;}
.st-lbl:hover{border-color:var(--blue);background:var(--blue-lt);}
.st-r:checked+.st-lbl{border-color:var(--blue);background:var(--blue-lt);box-shadow:0 0 0 3px rgba(61,90,241,.1);}
.st-ico{font-size:24px;}
.st-name{font-size:13.5px;font-weight:800;color:var(--ink);}
.st-desc{font-size:11.5px;color:var(--ink-3);}

/* form footer */
.f-footer{display:flex;align-items:center;gap:10px;margin-top:26px;padding-top:22px;border-top:1px solid var(--line);}
.btn-save{display:inline-flex;align-items:center;gap:7px;background:var(--blue);color:#fff;border:none;border-radius:10px;padding:11px 24px;font-family:inherit;font-size:13.5px;font-weight:700;cursor:pointer;transition:.2s;}
.btn-save:hover{background:#2d48e0;transform:translateY(-1px);}
.btn-cancel{display:inline-flex;align-items:center;gap:7px;background:#f4f6fc;color:var(--ink-2);border:1px solid var(--line);border-radius:10px;padding:11px 20px;font-family:inherit;font-size:13.5px;font-weight:700;text-decoration:none;transition:.2s;}
.btn-cancel:hover{background:var(--line);color:var(--ink);}
</style>

<div id="ns"></div>
<script>
const NC={success:{b:'#00c9a7',i:'#e0faf5',t:'#00a88a',ic:'✓'},error:{b:'#f1523d',i:'#fef0ee',t:'#c43020',ic:'✗'},warn:{b:'#f1a83d',i:'#fef6e6',t:'#c48020',ic:'!'},info:{b:'#3d5af1',i:'#eef0fe',t:'#2d48e0',ic:'ℹ'}};
function showN(type,title,msg){const c=NC[type]||NC.info,el=document.createElement('div');el.className='nt';el.innerHTML=`<div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div><div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div><button class="nt-x" onclick="closeN(this.parentElement)">✕</button>`;const bar=document.createElement('div');bar.className='nt-bar';bar.style.background=c.b;el.appendChild(bar);document.getElementById('ns').appendChild(el);setTimeout(()=>closeN(el),4500);}
function closeN(el){if(!el||el.classList.contains('out'))return;el.classList.add('out');setTimeout(()=>el&&el.remove(),300);}
document.addEventListener('DOMContentLoaded',()=>{
    @if(session('success')) showN('success','Berhasil',@json(session('success'))); @endif
    @if(session('error'))   showN('error','Gagal',@json(session('error')));         @endif
    @if($errors->any())     showN('error','Ada Kesalahan','Periksa kembali isian form.'); @endif
});
</script>

<div class="ch">

    <div class="pg-head">
        <div>
            <a href="{{ route('author.chapter.index', $novel->id) }}" class="pg-back">← Daftar Chapter</a>
            <div class="pg-title">✍️ Tambah Chapter</div>
            <div class="pg-sub">{{ $novel->judul }}</div>
        </div>
    </div>

    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-title">📝 Informasi Chapter</div>
        </div>
        <div class="fcard-body">
            <form action="{{ route('author.chapter.store', $novel->id) }}" method="POST">
                @csrf

                <div class="f-2col">
                    <div class="f-group">
                        <label class="f-label" for="urutan">Urutan Chapter</label>
                        <input type="number" id="urutan" name="urutan" min="1"
                               value="{{ old('urutan') }}"
                               class="f-ctrl @error('urutan') err @enderror"
                               placeholder="Contoh: 1" required>
                        @error('urutan')<div class="f-err">{{ $message }}</div>@enderror
                    </div>
                    <div class="f-group">
                        <label class="f-label" for="title">Judul Chapter</label>
                        <input type="text" id="title" name="title"
                               value="{{ old('title') }}"
                               class="f-ctrl @error('title') err @enderror"
                               placeholder="Judul chapter" required>
                        @error('title')<div class="f-err">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="f-group">
                    <label class="f-label" for="content">Isi Chapter</label>
                    <textarea id="content" name="content" rows="14"
                              class="f-ctrl @error('content') err @enderror"
                              placeholder="Tulis isi chapter di sini..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="f-err">{{ $message }}</div>@enderror
                </div>

                <div class="f-group" style="margin-bottom:0;">
                    <label class="f-label">Status Chapter</label>
                    <div class="st-grid">
                        <div>
                            <input type="radio" class="st-r" id="st-draft" name="status" value="draft"
                                   {{ old('status','draft') == 'draft' ? 'checked' : '' }}>
                            <label class="st-lbl" for="st-draft">
                                <span class="st-ico">📝</span>
                                <span class="st-name">Draft</span>
                                <span class="st-desc">Belum terlihat pembaca</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="st-r" id="st-pub" name="status" value="published"
                                   {{ old('status') == 'published' ? 'checked' : '' }}>
                            <label class="st-lbl" for="st-pub">
                                <span class="st-ico">🚀</span>
                                <span class="st-name">Published</span>
                                <span class="st-desc">Langsung tampil ke pembaca</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="f-footer">
                    <button type="submit" class="btn-save">💾 Simpan Chapter</button>
                    <a href="{{ route('author.chapter.index', $novel->id) }}" class="btn-cancel">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection