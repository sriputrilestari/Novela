@extends('author.layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

<style>
:root {
    --blue:    #3d5af1;
    --blue-lt: #eef0fe;
    --blue-md: #dde2fc;
    --green:   #00c9a7;
    --green-lt:#e0faf5;
    --amber:   #f1a83d;
    --amber-lt:#fef6e6;
    --red:     #f1523d;
    --red-lt:  #fef0ee;
    --purple:  #a855f7;
    --ink:     #18192a;
    --ink-2:   #5a5f7a;
    --ink-3:   #9698ae;
    --line:    #e8eaf3;
    --bg:      #f4f6fc;
    --white:   #ffffff;
    --radius:  16px;
    --shadow:  0 2px 16px rgba(24,25,42,.07);
    --shadow-h:0 8px 32px rgba(24,25,42,.13);
}

* { box-sizing: border-box; }

.dash {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink);
    padding-bottom: 72px;
}

/* ── Animations ── */
@keyframes up    { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
@keyframes bar   { from{width:100%} to{width:0%} }
@keyframes notIn { from{opacity:0;transform:translateY(16px) scale(.96)} to{opacity:1;transform:translateY(0) scale(1)} }
@keyframes notOt { to{opacity:0;transform:translateY(8px) scale(.94);max-height:0;padding:0;margin:0;overflow:hidden} }

.a1 { animation:up .5s .00s ease both; }
.a2 { animation:up .5s .07s ease both; }
.a3 { animation:up .5s .13s ease both; }
.a4 { animation:up .5s .19s ease both; }

/* ════════════════════════════════════
   NOTIFICATION
════════════════════════════════════ */
#ns {
    position:fixed; bottom:28px; right:28px; z-index:9999;
    display:flex; flex-direction:column-reverse; gap:10px; pointer-events:none;
}
.nt {
    pointer-events:all; position:relative; overflow:hidden;
    display:flex; align-items:center; gap:12px;
    background:rgba(255,255,255,.97); backdrop-filter:blur(20px);
    border:1px solid var(--line); border-radius:14px;
    padding:14px 16px; min-width:300px; max-width:350px;
    box-shadow:0 8px 28px rgba(24,25,42,.12);
    animation:notIn .4s cubic-bezier(.16,1,.3,1) both;
}
.nt.out      { animation:notOt .28s ease forwards; }
.nt-ico      { width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0; }
.nt-ttl      { font-size:13px;font-weight:700;color:var(--ink); }
.nt-msg      { font-size:12px;color:var(--ink-2);margin-top:1px;line-height:1.4; }
.nt-x        { margin-left:auto;flex-shrink:0;width:24px;height:24px;border-radius:6px;background:#f4f6fc;border:1px solid var(--line);color:var(--ink-3);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;transition:.18s; }
.nt-x:hover  { background:var(--line);color:var(--ink); }
.nt-bar      { position:absolute;bottom:0;left:0;height:2.5px;border-radius:99px;animation:bar 4.5s linear forwards; }

/* ════════════════════════════════════
   BANNER
════════════════════════════════════ */
.banner {
    background: linear-gradient(130deg, var(--blue) 0%, #2d48e0 50%, #1e3bce 100%);
    border-radius: 20px;
    padding: 30px 36px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    overflow: hidden;
}
.banner::before {
    content:'';position:absolute;inset:0;
    background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,.08) 0%, transparent 60%);
    pointer-events:none;
}
.bn-date { font-size:11.5px;font-weight:500;color:rgba(255,255,255,.55);letter-spacing:.4px;margin-bottom:8px; }
.bn-name { font-size:28px;font-weight:800;color:#fff;line-height:1; }
.bn-sub  { font-size:13px;color:rgba(255,255,255,.6);margin-top:8px; }
.bn-btns { display:flex;gap:10px;flex-wrap:wrap;position:relative;z-index:1; }
.btn {
    display:inline-flex;align-items:center;gap:7px;
    border-radius:10px;padding:10px 20px;
    font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;
    text-decoration:none;transition:.2s;cursor:pointer;
    white-space:nowrap;
}
.btn-ghost { background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.22);color:#fff; }
.btn-ghost:hover { background:rgba(255,255,255,.24);color:#fff;transform:translateY(-1px); }
.btn-white { background:#fff;border:1px solid #fff;color:var(--blue); }
.btn-white:hover { background:#eef0fe;color:var(--blue);transform:translateY(-1px); }

/* ════════════════════════════════════
   STATS ROW
════════════════════════════════════ */
.stats {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:20px;
}
@media(max-width:900px){ .stats{grid-template-columns:repeat(2,1fr);} }
@media(max-width:480px){ .stats{grid-template-columns:1fr;} }

.scard {
    background:var(--white);
    border:1px solid var(--line);
    border-radius:var(--radius);
    padding:22px;
    display:flex; flex-direction:column; gap:16px;
    box-shadow:var(--shadow);
    transition:.22s;
    cursor:default;
}
.scard:hover { transform:translateY(-3px);box-shadow:var(--shadow-h); }

.scard-top   { display:flex;align-items:flex-start;justify-content:space-between; }
.scard-ico   { width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:21px;flex-shrink:0; }
.scard-pill  { font-size:11px;font-weight:700;padding:4px 9px;border-radius:99px; }
.pill-green  { background:var(--green-lt);color:#00a88a; }
.pill-gray   { background:#f4f6fc;color:var(--ink-3); }

.scard-num { font-size:32px;font-weight:800;color:var(--ink);line-height:1; }
.scard-lbl { font-size:12px;font-weight:600;color:var(--ink-3);margin-top:3px; }

.scard-track { height:4px;background:#eef1f7;border-radius:99px;overflow:hidden; }
.scard-fill  { height:100%;border-radius:99px;width:0;transition:width 1.3s cubic-bezier(.16,1,.3,1); }

/* ════════════════════════════════════
   SHARED CARD SHELL
════════════════════════════════════ */
.box {
    background:var(--white);
    border:1px solid var(--line);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    overflow:hidden;
}
.box-head {
    display:flex;align-items:center;justify-content:space-between;
    padding:18px 22px 14px;
    border-bottom:1px solid var(--line);
}
.box-title { font-size:14.5px;font-weight:700;color:var(--ink); }
.box-sub   { font-size:12px;color:var(--ink-3);margin-top:2px; }
.box-body  { padding:18px 22px; }
.box-link  { font-size:12.5px;font-weight:700;color:var(--blue);text-decoration:none;white-space:nowrap; }
.box-link:hover { text-decoration:underline; }

/* ════════════════════════════════════
   STATUS PANEL  (2-col grid inside card)
════════════════════════════════════ */
.status-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    padding:18px 22px;
}
@media(max-width:600px){ .status-grid{grid-template-columns:1fr;} }

.status-item {
    display:flex;align-items:center;justify-content:space-between;
    background:#f8f9fe;
    border:1px solid var(--line);
    border-radius:12px;
    padding:14px 16px;
    transition:.2s;
}
.status-item:hover { border-color:var(--blue);background:var(--blue-lt); }
.si-label { font-size:13px;font-weight:700;color:var(--ink); }
.si-sub   { font-size:11.5px;color:var(--ink-3);margin-top:2px; }
.si-num   { font-size:18px;font-weight:800;flex-shrink:0;margin-left:12px; }

/* ════════════════════════════════════
   MAIN GRID
════════════════════════════════════ */
.main {
    display:grid;
    grid-template-columns:1fr 320px;
    gap:16px;
}
@media(max-width:960px){ .main{grid-template-columns:1fr;} }

.col-l { display:flex;flex-direction:column;gap:16px; }
.col-r { display:flex;flex-direction:column;gap:16px; }

/* ─── chart ─── */
.chart-wrap { position:relative;height:210px; }

/* ─── novel list ─── */
.nl-row             { display:flex;align-items:center;gap:14px;padding:11px 0;border-bottom:1px solid #f2f4fb; }
.nl-row:first-child { padding-top:0; }
.nl-row:last-child  { border-bottom:none;padding-bottom:0; }
.nl-thumb {
    width:40px;height:56px;border-radius:8px;
    object-fit:cover;border:1px solid var(--line);flex-shrink:0;
}
.nl-ph {
    width:40px;height:56px;border-radius:8px;flex-shrink:0;
    background:linear-gradient(135deg,var(--blue-lt),var(--blue-md));
    display:flex;align-items:center;justify-content:center;
    font-size:18px;border:1px solid var(--line);
}
.nl-info   { flex:1;min-width:0; }
.nl-name   { font-size:13.5px;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.nl-meta   { display:flex;align-items:center;gap:7px;flex-wrap:wrap;margin-top:4px; }
.nl-views  { font-size:12px;color:var(--ink-3);font-weight:600;flex-shrink:0;white-space:nowrap; }

/* badges */
.tag               { border-radius:99px;padding:2px 9px;font-size:10.5px;font-weight:700;white-space:nowrap; }
.tag-pub           { background:var(--green-lt);color:#00a08a;border:1px solid rgba(0,201,167,.18); }
.tag-pend          { background:var(--amber-lt);color:#b07010;border:1px solid rgba(241,168,61,.2); }
.tag-rej           { background:var(--red-lt);  color:#c03020;border:1px solid rgba(241,82,61,.18); }
.tag-done          { background:var(--green-lt);color:#00a08a;border:1px solid rgba(0,201,167,.18); }
.tag-ongoing       { background:var(--blue-lt); color:#3050d0;border:1px solid rgba(61,90,241,.18); }
.tag-genre         { background:var(--blue-lt); color:#3050d0;border:1px solid rgba(61,90,241,.18); }

/* ─── activity ─── */
.act-row              { display:flex;align-items:flex-start;gap:12px;padding:10px 0;border-bottom:1px solid #f2f4fb;animation:up .4s ease both; }
.act-row:first-child  { padding-top:0; }
.act-row:last-child   { border-bottom:none;padding-bottom:0; }
.act-ico              { width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0; }
.act-txt              { font-size:13px;color:var(--ink);line-height:1.5; }
.act-txt b            { color:var(--blue); }
.act-when             { font-size:11px;color:var(--ink-3);margin-top:2px; }
</style>

{{-- ── NOTIFICATION STACK ── --}}
<div id="ns"></div>
<script>
const NC={success:{b:'#00c9a7',i:'#e0faf5',t:'#00a88a',ic:'✓'},error:{b:'#f1523d',i:'#fef0ee',t:'#c43020',ic:'✗'},info:{b:'#3d5af1',i:'#eef0fe',t:'#2d48e0',ic:'ℹ'},warn:{b:'#f1a83d',i:'#fef6e6',t:'#c48020',ic:'!'}};
function showN(type,title,msg){
    const c=NC[type]||NC.info,el=document.createElement('div');
    el.className='nt';
    el.innerHTML=`<div class="nt-ico" style="background:${c.i};color:${c.t}">${c.ic}</div><div><div class="nt-ttl">${title}</div><div class="nt-msg">${msg}</div></div><button class="nt-x" onclick="closeN(this.parentElement)">✕</button>`;
    const bar=document.createElement('div');bar.className='nt-bar';bar.style.background=c.b;el.appendChild(bar);
    document.getElementById('ns').appendChild(el);
    setTimeout(()=>closeN(el),4500);
}
function closeN(el){if(!el||el.classList.contains('out'))return;el.classList.add('out');setTimeout(()=>el&&el.remove(),300);}
document.addEventListener('DOMContentLoaded',()=>{
    @if(session('success')) showN('success','Berhasil',@json(session('success'))); @endif
    @if(session('error'))   showN('error','Gagal',@json(session('error')));         @endif
    @if(session('warning')) showN('warn','Perhatian',@json(session('warning')));    @endif
    @if(session('info'))    showN('info','Info',@json(session('info')));             @endif
});
</script>

<div class="dash">

    {{-- ══════════════════════════════════════
         BANNER
    ═══════════════════════════════════════ --}}
    <div class="banner a1">
        <div>
            <div class="bn-date" id="bnDate"></div>
            <div class="bn-name">Halo, {{ auth()->user()->name }} 👋</div>
            <div class="bn-sub">Selamat berkarya — ceritamu menunggu untuk ditulis.</div>
        </div>
        <div class="bn-btns">
            <a href="{{ route('author.novel.create') }}" class="btn btn-white">✍️ Tulis Novel Baru</a>
            <a href="{{ route('author.novel.index') }}"  class="btn btn-ghost">📚 Novel Saya</a>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         STATS
    ═══════════════════════════════════════ --}}
    <div class="stats a2">

        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico" style="background:#eef0fe">📚</div>
                <span class="scard-pill pill-green">Total</span>
            </div>
            <div>
                <div class="scard-num ctr" data-v="{{ $totalNovel }}">0</div>
                <div class="scard-lbl">Total Novel</div>
            </div>
            <div class="scard-track">
                <div class="scard-fill" style="background:var(--blue)"
                     data-p="{{ min(100,$totalNovel*10) }}"></div>
            </div>
        </div>

        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico" style="background:#fef6e6">⏳</div>
                <span class="scard-pill pill-gray">Review</span>
            </div>
            <div>
                <div class="scard-num ctr" data-v="{{ $novelPending }}">0</div>
                <div class="scard-lbl">Novel Pending</div>
            </div>
            <div class="scard-track">
                <div class="scard-fill" style="background:var(--amber)"
                     data-p="{{ $totalNovel>0 ? min(100,($novelPending/$totalNovel)*100) : 0 }}"></div>
            </div>
        </div>

        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico" style="background:#e0faf5">📄</div>
                <span class="scard-pill pill-green">Total</span>
            </div>
            <div>
                <div class="scard-num ctr" data-v="{{ $totalChapter }}">0</div>
                <div class="scard-lbl">Total Chapter</div>
            </div>
            <div class="scard-track">
                <div class="scard-fill" style="background:var(--green)"
                     data-p="{{ min(100,$totalChapter*10) }}"></div>
            </div>
        </div>

        <div class="scard">
            <div class="scard-top">
                <div class="scard-ico" style="background:#f5f0fe">👁</div>
                <span class="scard-pill pill-green">Total</span>
            </div>
            <div>
                <div class="scard-num ctr" data-v="{{ $totalView }}">0</div>
                <div class="scard-lbl">Total View</div>
            </div>
            <div class="scard-track">
                <div class="scard-fill" style="background:var(--purple)" data-p="{{ min(100,$totalView*10) }}"></div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════
         STATUS NOVEL
    ═══════════════════════════════════════ --}}
    <div class="box a3" style="margin-bottom:16px;">
        <div class="box-head">
            <div>
                <div class="box-title">📋 Status Novel</div>
                <div class="box-sub">Ringkasan approval semua novelmu</div>
            </div>
        </div>
        <div class="status-grid">

            <div class="status-item">
                <div>
                    <div class="si-label">✅ Published</div>
                    <div class="si-sub">Novel yang sudah tayang</div>
                </div>
                <div class="si-num" style="color:var(--green)">{{ $publishedNovel }}</div>
            </div>

            <div class="status-item">
                <div>
                    <div class="si-label">⏳ Pending</div>
                    <div class="si-sub">Menunggu persetujuan admin</div>
                </div>
                <div class="si-num" style="color:var(--amber)">{{ $novelPending }}</div>
            </div>

            <div class="status-item">
                <div>
                    <div class="si-label">❌ Rejected</div>
                    <div class="si-sub">Perlu revisi ulang</div>
                </div>
                <div class="si-num" style="color:var(--red)">{{ $rejectedNovel }}</div>
            </div>

            <div class="status-item">
                <div>
                    <div class="si-label">💬 Komentar Baru</div>
                    <div class="si-sub">Dalam 24 jam terakhir</div>
                </div>
                <div class="si-num" style="color:var(--blue)">{{ $newComments }}</div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════
         MAIN GRID
    ═══════════════════════════════════════ --}}
    <div class="main a4">

        {{-- KIRI --}}
        <div class="col-l">

            {{-- Chart --}}
            <div class="box">
                <div class="box-head">
                    <div>
                        <div class="box-title">📈 Views 7 Hari Terakhir</div>
                        <div class="box-sub">Trafik pembaca novelmu per hari</div>
                    </div>
                    <span id="chartLbl" style="font-size:12px;color:var(--ink-3);font-weight:600;"></span>
                </div>
                <div class="box-body">
                    <div class="chart-wrap">
                        <canvas id="vc"></canvas>
                    </div>
                </div>
            </div>

            {{-- Novel List --}}
            <div class="box">
                <div class="box-head">
                    <div>
                        <div class="box-title">📚 Novel Saya</div>
                        <div class="box-sub">{{ $totalNovel }} novel terdaftar</div>
                    </div>
                    <a href="{{ route('author.novel.index') }}" class="box-link">Lihat Semua →</a>
                </div>
                <div class="box-body" style="padding-top:10px;">

                    @forelse($recentNovels as $novel)
                        <div class="nl-row">

                            @if($novel->cover)
                                <img src="{{ asset('storage/'.$novel->cover) }}"
                                     class="nl-thumb" alt="{{ $novel->judul }}">
                            @else
                                <div class="nl-ph">📖</div>
                            @endif

                            <div class="nl-info">
                                <div class="nl-name">{{ $novel->judul }}</div>
                                <div class="nl-meta">
                                    <span class="tag {{ $novel->approval_status==='published' ? 'tag-pub'
                                                       :($novel->approval_status==='rejected'  ? 'tag-rej'
                                                       :'tag-pend') }}">
                                        {{ ucfirst($novel->approval_status) }}
                                    </span>
                                    <span class="tag {{ $novel->status==='completed' ? 'tag-done' : 'tag-ongoing' }}">
                                        {{ ucfirst($novel->status) }}
                                    </span>
                                    @if($novel->genre)
                                        <span class="tag tag-genre">{{ $novel->genre->nama_genre }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="nl-views">👁 {{ number_format($novel->views ?? 0) }}</div>

                        </div>
                    @empty
                        <div style="text-align:center;padding:32px 0;color:var(--ink-3);font-size:13px;">
                            <div style="font-size:40px;margin-bottom:12px;">📝</div>
                            Belum ada novel.
                            <a href="{{ route('author.novel.create') }}"
                               style="color:var(--blue);font-weight:700;">Buat sekarang →</a>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>

        {{-- KANAN --}}
        <div class="col-r">

            {{-- Aktivitas --}}
            <div class="box">
                <div class="box-head">
                    <div>
                        <div class="box-title">🔔 Aktivitas Terbaru</div>
                        <div class="box-sub">Komentar & chapter baru</div>
                    </div>
                    <a href="{{ route('author.comment.index') }}" class="box-link">Semua →</a>
                </div>
                <div class="box-body" style="padding-top:10px;">

                    @forelse($recentActivities as $act)
                        <div class="act-row" style="animation-delay:{{ $loop->index*.05 }}s">
                            <div class="act-ico"
                                 style="background:{{ $act['bg'] }};color:{{ $act['color'] }}">
                                {{ $act['icon'] }}
                            </div>
                            <div>
                                <div class="act-txt">{!! $act['text'] !!}</div>
                                <div class="act-when">{{ $act['time'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:28px 0;color:var(--ink-3);font-size:13px;">
                            <div style="font-size:34px;margin-bottom:10px;">🔕</div>
                            Belum ada aktivitas.
                        </div>
                    @endforelse

                </div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // tanggal
    document.getElementById('bnDate').textContent =
        new Date().toLocaleDateString('id-ID',{weekday:'long',year:'numeric',month:'long',day:'numeric'});

    // counter
    document.querySelectorAll('.ctr').forEach(el => {
        const max = parseInt(el.dataset.v) || 0;
        let n = 0, step = Math.max(1, Math.ceil(max/50));
        const t = setInterval(() => {
            n = Math.min(n+step, max);
            el.textContent = n.toLocaleString('id-ID');
            if (n >= max) clearInterval(t);
        }, 28);
    });

    // bars
    setTimeout(() => {
        document.querySelectorAll('.scard-fill[data-p]').forEach(b => {
            b.style.width = b.dataset.p + '%';
        });
    }, 250);

    // chart
    const labels = @json($chartLabels);
    const data   = @json($chartData);
    document.getElementById('chartLbl').textContent =
        data.reduce((a,b)=>a+b,0).toLocaleString('id-ID') + ' total views';

    const ctx  = document.getElementById('vc').getContext('2d');
    const grad = ctx.createLinearGradient(0,0,0,210);
    grad.addColorStop(0,'rgba(61,90,241,.22)');
    grad.addColorStop(1,'rgba(61,90,241,0)');

    new Chart(ctx, {
        type:'line',
        data:{labels,datasets:[{
            data, borderColor:'#3d5af1', borderWidth:2.5,
            backgroundColor:grad, fill:true, tension:.42,
            pointBackgroundColor:'#3d5af1', pointRadius:3.5,
            pointHoverRadius:6, pointBorderColor:'#fff', pointBorderWidth:2,
        }]},
        options:{
            responsive:true, maintainAspectRatio:false,
            interaction:{intersect:false,mode:'index'},
            plugins:{
                legend:{display:false},
                tooltip:{
                    backgroundColor:'#18192a',titleColor:'#fff',bodyColor:'#9698ae',
                    padding:11,cornerRadius:9,
                    callbacks:{label:c=>' '+c.parsed.y.toLocaleString('id-ID')+' views'}
                }
            },
            scales:{
                x:{grid:{display:false},border:{display:false},
                   ticks:{color:'#9698ae',font:{size:11,family:"'Plus Jakarta Sans',sans-serif"}}},
                y:{grid:{color:'#eef1f7'},border:{display:false,dash:[3,3]},
                   ticks:{color:'#9698ae',font:{size:11,family:"'Plus Jakarta Sans',sans-serif"},
                          callback:v=>v.toLocaleString('id-ID')}}
            }
        }
    });

});
</script>

@endsection