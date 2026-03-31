{{-- resources/views/reader/report/create.blade.php --}}
{{-- Panggil dari halaman novel reader dengan:              --}}
{{-- <a href="{{ route('reader.report.show', $novel->id) }}"> --}}

@extends('layouts.app') {{-- sesuaikan layout reader kamu --}}

@section('title', 'Laporkan Novel')

@section('content')
    <div class="container py-5" style="max-width:640px;">

        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4"
                style="border-left:4px solid #1cc88a;">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" style="border-left:4px solid #e74a3b;">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="card shadow-sm" style="border-radius:.5rem; overflow:hidden;">

            {{-- Header --}}
            <div class="card-header py-4 px-4 border-0" style="background:linear-gradient(135deg,#2e3a59 0%,#3d4f78 100%);">
                <h5 class="text-white font-weight-bold mb-0">
                    <i class="fas fa-flag mr-2"></i>Laporkan Novel
                </h5>
                <small class="text-white-50">
                    Laporan kamu akan ditinjau dalam 1–3 hari kerja
                </small>
            </div>

            <div class="card-body px-4 py-4">

                {{-- Info kuota reader --}}
                @php
                    $sisa = \App\Models\NovelReport::remainingQuota(Auth::id());
                    $resetAt = \App\Models\NovelReport::quotaResetsAt(Auth::id());
                @endphp

                @if ($sisa === 0)
                    <div class="alert d-flex align-items-start mb-4"
                        style="background:#fff5f5; border-left:4px solid #e74a3b;
                            color:#7b1d1d; font-size:.85rem; border-radius:.35rem;">
                        <i class="fas fa-ban mr-2 mt-1"></i>
                        <div>
                            Kuota laporan kamu sudah habis untuk 7 hari ini.
                            @if ($resetAt)
                                Reset pada <strong>{{ $resetAt->translatedFormat('d F Y, H:i') }}</strong>.
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert d-flex align-items-center mb-4"
                        style="background:#eff6ff; border-left:4px solid #5B8DEF;
                            color:#1e3a5f; font-size:.85rem; border-radius:.35rem;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Sisa kuota: <strong class="mx-1">{{ $sisa }} novel</strong> dalam 7 hari ini.
                    </div>
                @endif

                <form method="POST" action="{{ route('reader.report.store', $novel->id) }}">
                    @csrf

                    {{-- Pilih Alasan --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-gray-700 mb-2" style="font-size:.9rem;">
                            Alasan Laporan <span class="text-danger">*</span>
                        </label>

                        @foreach ([
            'konten_dewasa' => ['label' => 'Konten Dewasa / Tidak Pantas', 'icon' => 'fa-eye-slash', 'color' => '#e74a3b'],
            'ujaran_kebencian' => ['label' => 'Ujaran Kebencian', 'icon' => 'fa-angry', 'color' => '#fd7e14'],
            'spam' => ['label' => 'Spam / Promosi Berlebihan', 'icon' => 'fa-ban', 'color' => '#858796'],
            'plagiarisme' => ['label' => 'Plagiarisme / Pencurian Karya', 'icon' => 'fa-copy', 'color' => '#f6c23e'],
            'kekerasan' => ['label' => 'Kekerasan Grafis', 'icon' => 'fa-exclamation-triangle', 'color' => '#e74a3b'],
            'lainnya' => ['label' => 'Lainnya', 'icon' => 'fa-ellipsis-h', 'color' => '#5B8DEF'],
        ] as $value => $opt)
                            <div class="mb-2">
                                <label class="d-flex align-items-center p-3 rounded cursor-pointer border"
                                    style="cursor:pointer; border-color:#e3e6f0; font-size:.88rem;
                                          transition:all .15s ease;"
                                    onmouseover="this.style.borderColor='#5B8DEF'; this.style.background='#f0f5ff'"
                                    onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#e3e6f0'; this.style.background=''}">
                                    <input type="radio" name="alasan" value="{{ $value }}" class="mr-3" required
                                        {{ old('alasan') === $value ? 'checked' : '' }}
                                        onchange="document.querySelectorAll('[data-report-label]')
                                                   .forEach(el => {
                                                       el.style.borderColor='#e3e6f0';
                                                       el.style.background='';
                                                   });
                                                 this.closest('[data-report-label]').style.borderColor='#5B8DEF';
                                                 this.closest('[data-report-label]').style.background='#f0f5ff';"
                                        data-report-input>
                                    <i class="fas {{ $opt['icon'] }} mr-2"
                                        style="color:{{ $opt['color'] }}; width:16px;"></i>
                                    {{ $opt['label'] }}
                                </label>
                            </div>
                        @endforeach

                        @error('alasan')
                            <small class="text-danger"><i
                                    class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Deskripsi tambahan --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-gray-700 mb-2" style="font-size:.9rem;">
                            Deskripsi Tambahan
                            <span class="text-muted font-weight-normal">(opsional)</span>
                        </label>
                        <textarea name="deskripsi" rows="4" maxlength="1000"
                            placeholder="Jelaskan masalah yang kamu temukan secara singkat..."
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            style="font-size:.88rem; background:#f8f9fc;
                                     border-color:#d1d3e2; resize:none;">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maks. 1000 karakter</small>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex" style="gap:.75rem;">
                        <button type="submit" class="btn btn-primary {{ $sisa === 0 ? 'disabled' : '' }}"
                            {{ $sisa === 0 ? 'disabled' : '' }}>
                            <i class="fas fa-flag mr-1"></i>Kirim Laporan
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
