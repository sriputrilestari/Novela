@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            {{-- Alerts --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-lg mr-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            @endif

            {{-- ======================== --}}
            {{-- STATE: PENDING           --}}
            {{-- ======================== --}}
            @if(auth()->user()->author_request === 'pending')

            <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-warning text-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-clock mr-2"></i>Pengajuan Sedang Diproses
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4" style="font-size: 64px; color: #f6c23e; line-height: 1;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <h4 class="font-weight-bold text-gray-800 mb-2">Pengajuan Anda Sedang Ditinjau</h4>
                    <p class="text-muted mb-1">
                        Pengajuan dikirim pada
                        <strong>{{ auth()->user()->author_request_date ? \Carbon\Carbon::parse(auth()->user()->author_request_date)->format('d M Y, H:i') : '-' }}</strong>
                    </p>
                    <p class="text-muted mb-4">Tim admin kami akan segera meninjau pengajuan Anda. Harap bersabar.</p>
                    <a href="{{ route('home') }}" class="btn btn-warning text-white px-4">
                        <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- ======================== --}}
            {{-- STATE: REJECTED          --}}
            {{-- ======================== --}}
            @elseif(auth()->user()->author_request === 'rejected')

            <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-danger text-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-times-circle mr-2"></i>Pengajuan Ditolak
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4" style="font-size: 64px; color: #e74a3b; line-height: 1;">
                        <i class="fas fa-sad-tear"></i>
                    </div>
                    <h4 class="font-weight-bold text-gray-800 mb-2">Pengajuan Author Ditolak</h4>
                    <p class="text-muted mb-4">
                        Maaf, pengajuan Anda untuk menjadi author belum dapat disetujui.<br>
                        Anda dapat mengajukan kembali dengan alasan yang lebih lengkap.
                    </p>
                    <button type="button" class="btn btn-warning px-4 mr-2" data-toggle="modal" data-target="#reapplyModal">
                        <i class="fas fa-redo mr-2"></i>Ajukan Kembali
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-light border px-4">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                </div>
            </div>

            {{-- ======================== --}}
            {{-- STATE: FORM              --}}
            {{-- ======================== --}}
            @else

            <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-pen-fancy mr-2"></i>Ajukan Menjadi Author
                    </h5>
                </div>
                <div class="card-body p-4">

                    <div class="alert border-0 mb-4" style="background-color: #e8f4fd; border-left: 4px solid #4e73df !important; border-radius: 8px;">
                        <div class="d-flex">
                            <i class="fas fa-info-circle text-primary mt-1 mr-3"></i>
                            <div>
                                <strong class="text-primary">Informasi</strong>
                                <p class="mb-0 small mt-1 text-muted">
                                    Dengan menjadi author, Anda dapat menulis dan menerbitkan novel di platform kami.
                                    Isi form berikut untuk mengajukan diri sebagai author.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reader.author-request.submit') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 small">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 small">Email</label>
                            <input type="email" class="form-control bg-light" value="{{ auth()->user()->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>

                        {{-- Alasan --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700 small">
                                Alasan Ingin Menjadi Author <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control @error('author_request_note') is-invalid @enderror"
                                name="author_request_note"
                                rows="5"
                                placeholder="Ceritakan mengapa Anda ingin menjadi author dan genre apa yang ingin Anda tulis..."
                                required>{{ old('author_request_note') }}</textarea>
                            @error('author_request_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 50 karakter</small>
                        </div>

                        {{-- Persetujuan --}}
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                    class="custom-control-input @error('agree') is-invalid @enderror"
                                    id="agree" name="agree" required>
                                <label class="custom-control-label small" for="agree">
                                    Saya setuju dengan
                                    <a href="#" data-toggle="modal" data-target="#termsModal" class="text-primary">
                                        syarat dan ketentuan
                                    </a>
                                    menjadi author
                                </label>
                                @error('agree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-light border px-4">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            @endif

        </div>
    </div>
</div>

{{-- ======================== --}}
{{-- MODAL: Syarat & Ketentuan --}}
{{-- ======================== --}}
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="termsModalLabel">
                    <i class="fas fa-file-contract mr-2"></i>Syarat dan Ketentuan Author
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 py-4">

                <div class="mb-4">
                    <h6 class="font-weight-bold text-primary mb-2">
                        <i class="fas fa-tasks fa-fw mr-2"></i>1. Kewajiban Author
                    </h6>
                    <ul class="text-muted small pl-3" style="line-height: 2;">
                        <li>Menulis konten original dan tidak plagiat</li>
                        <li>Tidak mengandung unsur SARA, pornografi, atau kekerasan berlebihan</li>
                        <li>Bertanggung jawab atas konten yang dipublikasikan</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h6 class="font-weight-bold text-success mb-2">
                        <i class="fas fa-star fa-fw mr-2"></i>2. Hak Author
                    </h6>
                    <ul class="text-muted small pl-3" style="line-height: 2;">
                        <li>Menerbitkan novel di platform</li>
                        <li>Mengelola novel dan chapter sendiri</li>
                        <li>Berinteraksi dengan pembaca</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h6 class="font-weight-bold text-danger mb-2">
                        <i class="fas fa-ban fa-fw mr-2"></i>3. Larangan
                    </h6>
                    <ul class="text-muted small pl-3" style="line-height: 2;">
                        <li>Melakukan plagiarisme atau menyalin karya orang lain</li>
                        <li>Membuat konten yang melanggar hukum</li>
                        <li>Spam atau promosi berlebihan</li>
                    </ul>
                </div>

                <div class="alert alert-warning border-0 mb-0" style="border-radius: 8px;">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Sanksi:</strong>
                    <span class="small"> Pelanggaran dapat mengakibatkan pemblokiran akun author secara permanen.</span>
                </div>

            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-light border px-4" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- ======================== --}}
{{-- MODAL: Ajukan Kembali    --}}
{{-- ======================== --}}
<div class="modal fade" id="reapplyModal" tabindex="-1" role="dialog" aria-labelledby="reapplyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title font-weight-bold" id="reapplyModalLabel">
                    <i class="fas fa-redo mr-2"></i>Ajukan Kembali
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('reader.author-request.reapply') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <p class="text-muted small mb-3">
                        Tuliskan alasan pengajuan ulang Anda dengan lebih jelas agar peluang diterima lebih besar.
                    </p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-gray-700 small">
                            Alasan Pengajuan Ulang <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" name="author_request_note" rows="4"
                            placeholder="Jelaskan alasan dan rencana Anda sebagai author..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light border px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white px-4">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Ulang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endsection