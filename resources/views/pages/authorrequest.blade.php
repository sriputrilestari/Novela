@extends('layouts.main')
@section('title', 'Jadi Penulis – Novela')
@section('content')

<div class="content-wrap" style="max-width:700px">

  {{-- Header --}}
  <div style="text-align:center;margin-bottom:36px">
    <div style="width:80px;height:80px;background:var(--blue-lt);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:2.2rem;margin:0 auto 16px">✍️</div>
    <h1 style="font-family:'Lora',serif;font-size:1.8rem;font-weight:700;color:var(--ink);margin-bottom:8px">Jadi Penulis di Novela</h1>
    <p style="color:var(--ink-3);font-size:.95rem;max-width:480px;margin:0 auto;line-height:1.7">Wujudkan ceritamu dan bagikan karya kepada jutaan pembaca. Bergabung menjadi penulis Novela hari ini!</p>
  </div>

  @if(session('success'))
  <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert alert-error">⚠️ {{ session('error') }}</div>
  @endif

  {{-- Status block --}}
  @if(isset($currentUser) && $currentUser->author_request)
    @php $req = $currentUser->author_request; @endphp

    @if($req->status === 'pending')
    <div style="background:var(--amber-lt);border:1.5px solid rgba(241,168,61,.25);border-radius:var(--radius);padding:24px;margin-bottom:24px">
      <div class="flex items-center gap-12 mb-12">
        <span style="font-size:1.5rem">⏳</span>
        <div>
          <div style="font-weight:700;color:#c2862f;font-size:1rem">Permintaan Sedang Ditinjau</div>
          <div class="text-xs text-muted mt-4">Dikirim {{ \Carbon\Carbon::parse($req->created_at)->diffForHumans() }}</div>
        </div>
        <span class="status-pill status-pending" style="margin-left:auto">Pending</span>
      </div>
      <p style="font-size:.875rem;color:var(--ink-2);line-height:1.6">Tim kami sedang meninjau permintaanmu. Proses ini biasanya memakan waktu 1–3 hari kerja. Kami akan menghubungimu via email setelah keputusan dibuat.</p>
      <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(241,168,61,.2)">
        <form action="{{ route('reader.author-request.cancel') }}" method="POST" style="display:inline">
          @csrf
          <button type="submit" class="btn-danger btn-sm" onclick="return confirm('Batalkan permintaan?')">Batalkan Permintaan</button>
        </form>
      </div>
    </div>

    @elseif($req->status === 'approved')
    <div style="background:var(--green-lt);border:1.5px solid rgba(0,201,167,.25);border-radius:var(--radius);padding:24px;margin-bottom:24px">
      <div class="flex items-center gap-12">
        <span style="font-size:1.5rem">🎉</span>
        <div>
          <div style="font-weight:700;color:#009b80;font-size:1rem">Selamat! Kamu Sudah Jadi Penulis</div>
          <div class="text-xs text-muted mt-4">Disetujui {{ \Carbon\Carbon::parse($req->updated_at)->diffForHumans() }}</div>
        </div>
        <span class="status-pill status-approved" style="margin-left:auto">Approved</span>
      </div>
      <p style="font-size:.875rem;color:var(--ink-2);margin-top:12px;line-height:1.6">Akun kamu sekarang sudah memiliki akses penulis. Mulai tulis novel pertamamu!</p>
      <div style="margin-top:16px">
        <a href="{{ route('author.dashboard') }}" class="btn-green">🚀 Ke Dashboard Penulis</a>
      </div>
    </div>

    @elseif($req->status === 'rejected')
    <div style="background:var(--red-lt);border:1.5px solid rgba(241,82,61,.2);border-radius:var(--radius);padding:24px;margin-bottom:24px">
      <div class="flex items-center gap-12 mb-12">
        <span style="font-size:1.5rem">😔</span>
        <div>
          <div style="font-weight:700;color:var(--red);font-size:1rem">Permintaan Ditolak</div>
          <div class="text-xs text-muted mt-4">Ditolak {{ \Carbon\Carbon::parse($req->updated_at)->diffForHumans() }}</div>
        </div>
        <span class="status-pill status-rejected" style="margin-left:auto">Ditolak</span>
      </div>
      @if($req->catatan_admin)
      <div style="background:rgba(241,82,61,.07);border-radius:10px;padding:12px 14px;margin-bottom:16px">
        <div class="text-xs text-muted mb-4">Alasan penolakan:</div>
        <p style="font-size:.875rem;color:var(--ink-2)">{{ $req->catatan_admin }}</p>
      </div>
      @endif
      <p style="font-size:.875rem;color:var(--ink-2);margin-bottom:16px;line-height:1.6">Kamu bisa mengajukan kembali setelah 30 hari. Pastikan kamu memenuhi semua syarat yang diperlukan.</p>
      <form action="{{ route('reader.author-request.reapply') }}" method="POST">
        @csrf
        <button type="submit" class="btn-primary btn-sm">Ajukan Ulang</button>
      </form>
    </div>
    @endif

  @else
  {{-- FORM REQUEST --}}
  <div style="background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden;margin-bottom:24px">

    {{-- Benefits strip --}}
    <div style="background:linear-gradient(135deg,#1e2f9e,#3d5af1);padding:24px;color:white">
      <div style="font-family:'Lora',serif;font-size:1.1rem;font-weight:700;margin-bottom:16px">Keuntungan Jadi Penulis</div>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px">
        @foreach([
          ['icon'=>'✍️','title'=>'Tulis Novel','desc'=>'Buat dan publikasikan novel sendiri'],
          ['icon'=>'📊','title'=>'Statistik','desc'=>'Pantau views dan pembaca'],
          ['icon'=>'💬','title'=>'Interaksi','desc'=>'Balas komentar pembaca'],
        ] as $b)
        <div style="background:rgba(255,255,255,.1);border-radius:12px;padding:14px;backdrop-filter:blur(4px)">
          <div style="font-size:1.3rem;margin-bottom:6px">{{ $b['icon'] }}</div>
          <div style="font-weight:700;font-size:.85rem">{{ $b['title'] }}</div>
          <div style="font-size:.75rem;opacity:.8;margin-top:2px">{{ $b['desc'] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    <div style="padding:28px">
      <div style="font-family:'Lora',serif;font-size:1rem;font-weight:700;margin-bottom:20px;color:var(--ink)">📝 Form Pengajuan Penulis</div>

      @if($errors->any())
      <div class="alert alert-error">
        <ul style="margin:0;padding-left:16px">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form action="{{ route('reader.author-request.submit') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Nama<span style="color:var(--red)">*</span></label>
          <input class="form-input" name="pen_name" value="{{ old('pen_name', auth()->user()->name) }}" placeholder="Nama yang akan tampil sebagai penulis" required/>
        </div>

        <div class="form-group">
          <label class="form-label">Genre Favorit <span style="color:var(--red)">*</span></label>
          <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:4px">
            @foreach(['Fantasy','Romance','Action','Horror','Mystery','Sci-Fi','Isekai','School Life','Slice of Life','Xianxia','Historical','System'] as $genre)
            <label style="cursor:pointer">
              <input type="checkbox" name="genres[]" value="{{ $genre }}" style="display:none" class="genre-check" onchange="toggleGenreLabel(this)"/>
              <span class="genre-pill" style="cursor:pointer" id="genre-label-{{ Str::slug($genre) }}">{{ $genre }}</span>
            </label>
            @endforeach
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Sinopsis Novel Pertamamu <span style="color:var(--red)">*</span></label>
          <textarea class="form-textarea" name="sinopsis_pertama" rows="4" placeholder="Ceritakan sedikit tentang novel yang ingin kamu tulis..." required style="min-height:120px">{{ old('sinopsis_pertama') }}</textarea>
          <div class="form-error" id="synopsis-count" style="color:var(--ink-3)">0 / 500 karakter</div>
        </div>

        <div class="form-group">
          <label class="form-label">Pengalaman Menulis</label>
          <select class="form-select" name="pengalaman">
            <option value="">-- Pilih --</option>
            <option value="pemula">Pemula (belum pernah menulis)</option>
            <option value="hobi">Hobi (menulis sebagai hobi)</option>
            <option value="semi_pro">Semi-Profesional (punya karya terpublikasi)</option>
            <option value="profesional">Profesional (penulis aktif)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Motivasi & Alasan</label>
          <textarea class="form-textarea" name="motivasi" rows="3" placeholder="Kenapa kamu ingin jadi penulis di Novela?">{{ old('motivasi') }}</textarea>
        </div>

        <div style="background:var(--amber-lt);border:1px solid rgba(241,168,61,.2);border-radius:12px;padding:14px;margin-bottom:20px">
          <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer">
            <input type="checkbox" name="setuju" required style="margin-top:3px;accent-color:var(--blue)"/>
            <span style="font-size:.85rem;color:var(--ink-2);line-height:1.6">Saya menyetujui <a href="#" style="color:var(--blue)">syarat dan ketentuan penulis</a> Novela dan berkomitmen untuk mempublikasikan konten orisinal yang tidak melanggar hak cipta orang lain.</span>
          </label>
        </div>

        <button type="submit" class="btn-primary btn-block btn-lg">
          ✍️ Kirim Permintaan Jadi Penulis
        </button>
      </form>
    </div>
  </div>

  {{-- Info card --}}
  <div style="background:var(--blue-lt);border:1.5px solid var(--blue-md);border-radius:var(--radius);padding:20px">
    <div class="flex items-center gap-8 mb-10">
      <span style="font-size:1rem">ℹ️</span>
      <span style="font-weight:700;color:var(--blue);font-size:.9rem">Yang Perlu Diketahui</span>
    </div>
    <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
      @foreach([
        'Proses review memakan waktu 1–3 hari kerja',
        'Akun harus sudah terverifikasi email',
        'Konten yang dibuat harus orisinal dan tidak plagiat',
        'Penulis wajib update minimal 1 chapter per minggu',
      ] as $info)
      <li style="display:flex;align-items:flex-start;gap:8px;font-size:.85rem;color:var(--ink-2)">
        <span style="color:var(--blue);font-weight:700;flex-shrink:0">✓</span>
        {{ $info }}
      </li>
      @endforeach
    </ul>
  </div>
  @endif

</div>

@endsection

@section('extra-js')
<script>
function toggleGenreLabel(input){
  const label=document.getElementById('genre-label-'+input.value.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9-]/g,''));
  if(input.checked){label.style.background='var(--blue)';label.style.color='white';label.style.borderColor='var(--blue)'}
  else{label.style.background='var(--white)';label.style.color='var(--ink-2)';label.style.borderColor='var(--line)'}
}

const syn=document.querySelector('[name=sinopsis_pertama]');
const cnt=document.getElementById('synopsis-count');
if(syn&&cnt){
  syn.addEventListener('input',()=>{
    const l=syn.value.length;
    cnt.textContent=l+' / 500 karakter';
    cnt.style.color=l>500?'var(--red)':'var(--ink-3)';
  });
}
</script>
@endsection