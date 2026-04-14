@extends('layouts.app')
@section('title', 'Jadi Penulis - Novela')
@section('content')

<div class="content-wrap" style="max-width:680px">

  {{-- Hero --}}
  <div style="text-align:center;margin-bottom:2rem">
    <div style="width:72px;height:72px;background:var(--blue-lt);border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem">✍️</div>
    <h1 style="font-family:'Lora',serif;font-size:1.5rem;font-weight:700;color:var(--ink);margin-bottom:.5rem">Jadi Penulis di Novela</h1>
    <p style="color:var(--ink-3);font-size:.875rem;max-width:420px;margin:0 auto;line-height:1.7">Wujudkan ceritamu dan bagikan karya kepada pembaca. Ajukan akses author dari akun reader-mu.</p>
  </div>


  @if(isset($currentUser) && $currentUser->author_request !== 'none')
    @php $status = $currentUser->author_request; @endphp
    @if($status === 'pending')
      {{-- ... status pending (tidak berubah) ... --}}
    @elseif($status === 'approved')
      {{-- ... status approved (tidak berubah) ... --}}
    @elseif($status === 'rejected')
      {{-- ... status rejected (tidak berubah) ... --}}
    @endif
  @else

  <div style="background:var(--white);border-radius:var(--radius-lg);border:0.5px solid var(--line);overflow:hidden;margin-bottom:1.5rem">

    {{-- Header benefits --}}
    <div style="background:linear-gradient(135deg,#1e2f9e,#3d5af1);padding:1.25rem 1.5rem;color:white">
      <div style="font-family:'Lora',serif;font-size:.95rem;font-weight:700;margin-bottom:1rem;opacity:.9">Keuntungan jadi penulis</div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem">
        @foreach([['Tulis Novel','Buat & publikasikan novel sendiri'],['Statistik','Pantau views & pembaca'],['Interaksi','Balas komentar pembaca']] as $b)
        <div style="background:rgba(255,255,255,.1);border-radius:10px;padding:.875rem 1rem;border:0.5px solid rgba(255,255,255,.15)">
          <div style="font-size:.8rem;font-weight:700;margin-bottom:.2rem">{{ $b[0] }}</div>
          <div style="font-size:.7rem;opacity:.7;line-height:1.5">{{ $b[1] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Form body --}}
    <div style="padding:1.5rem">
      <div style="font-family:'Lora',serif;font-size:1rem;font-weight:700;margin-bottom:1.25rem;color:var(--ink)">Form pengajuan penulis</div>

      @if($errors->any())
      <div class="alert alert-error">
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
      @endif

      <form action="{{ route('reader.author-request.submit') }}" method="POST">
        @csrf

        {{-- Nama Pena --}}
        <div class="form-group">
          <label class="form-label">Nama Pena <span style="color:var(--red)">*</span></label>
          <input class="form-input" name="pen_name" value="{{ old('pen_name', auth()->user()->name) }}" placeholder="Nama yang akan tampil sebagai penulis" required />
        </div>

        {{-- Genre — diambil dari $genres yang dikirim controller --}}
        <div class="form-group">
          <label class="form-label">Genre Favorit</label>
          <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-top:.25rem">
            @foreach($genres as $genre)
            <label style="cursor:pointer">
              <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                style="display:none" class="genre-check"
                onchange="toggleGenre(this,'genre-{{ $genre->id }}')"
                {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }} />
              <span id="genre-{{ $genre->id }}" class="genre-pill {{ in_array($genre->id, old('genres', [])) ? 'active' : '' }}">
                {{ $genre->name }}
              </span>
            </label>
            @endforeach
          </div>
        </div>

        <hr style="border:none;border-top:0.5px solid var(--line);margin:1.25rem 0">

        {{-- Sinopsis --}}
        <div class="form-group">
          <label class="form-label">Sinopsis novel pertamamu <span style="color:var(--red)">*</span></label>
          <textarea class="form-textarea" name="sinopsis_pertama" id="sinopsis" rows="4"
            placeholder="Ceritakan sedikit tentang novel yang ingin kamu tulis..." required
            style="min-height:110px">{{ old('sinopsis_pertama') }}</textarea>
          <div style="font-size:.75rem;color:var(--ink-3);margin-top:.35rem"><span id="synopsis-count">0</span> / 500 karakter</div>
        </div>

        {{-- Pengalaman --}}
        <div class="form-group">
          <label class="form-label">Pengalaman Menulis</label>
          <select class="form-select" name="pengalaman">
            <option value="">— Pilih level —</option>
            @foreach(['pemula'=>'Pemula','hobi'=>'Hobi','semi_pro'=>'Semi-Profesional','profesional'=>'Profesional'] as $val=>$label)
            <option value="{{ $val }}" {{ old('pengalaman')==$val?'selected':'' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        {{-- Motivasi --}}
        <div class="form-group">
          <label class="form-label">Motivasi & Alasan</label>
          <textarea class="form-textarea" name="motivasi" rows="3" placeholder="Kenapa kamu ingin jadi penulis di Novela?">{{ old('motivasi') }}</textarea>
        </div>

        {{-- Setuju --}}
        <div style="background:var(--bg-2);border:0.5px solid var(--line);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.75rem">
          <input type="checkbox" name="setuju" id="setuju" required style="margin-top:2px;accent-color:var(--blue);width:15px;height:15px;flex-shrink:0" />
          <label for="setuju" style="font-size:.825rem;color:var(--ink-2);line-height:1.6;cursor:pointer">
            Saya menyetujui syarat dan ketentuan penulis Novela dan berkomitmen untuk mempublikasikan konten orisinal.
          </label>
        </div>

        <button type="submit" class="btn-primary btn-block btn-lg">Kirim Permintaan Jadi Penulis</button>
      </form>
    </div>
  </div>
  @endif
</div>

@endsection

@section('scripts')
<script>
function toggleGenre(input, id) {
  const pill = document.getElementById(id);
  if (!pill) return;
  pill.classList.toggle('active', input.checked);
}

const syn = document.getElementById('sinopsis');
const cnt = document.getElementById('synopsis-count');
if (syn && cnt) {
  const update = () => {
    const l = syn.value.length;
    cnt.textContent = l;
    cnt.style.color = l > 500 ? 'var(--red)' : 'var(--ink-3)';
  };
  syn.addEventListener('input', update);
  update();
}
</script>
@endsection
