@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Check Current Status -->
            @if(auth()->user()->author_request === 'pending')
            
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i> Pengajuan Sedang Diproses
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-hourglass-half fa-5x text-warning mb-4"></i>
                    <h4>Pengajuan Anda Sedang Ditinjau</h4>
                    <p class="text-muted">
                        Pengajuan untuk menjadi author telah dikirim pada 
                        <strong>{{ auth()->user()->author_request_date->format('d M Y H:i') }}</strong>
                    </p>
                    <p class="mb-4">Tim admin kami akan segera meninjau pengajuan Anda. Harap bersabar.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            @elseif(auth()->user()->author_request === 'rejected')
            
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-times-circle"></i> Pengajuan Ditolak
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-sad-tear fa-5x text-danger mb-4"></i>
                    <h4>Pengajuan Author Ditolak</h4>
                    <p class="text-muted mb-4">
                        Maaf, pengajuan Anda untuk menjadi author ditolak. 
                        Anda dapat mengajukan kembali setelah beberapa waktu.
                    </p>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#reapplyModal">
                        <i class="fas fa-redo"></i> Ajukan Kembali
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            @else
            
            <!-- Application Form -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-pen-fancy"></i> Ajukan Menjadi Author
                    </h5>
                </div>
                <div class="card-body">
                    
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi</h6>
                        <p class="mb-0">
                            Dengan menjadi author, Anda dapat menulis dan menerbitkan novel Anda sendiri di platform kami.
                            Silakan isi form di bawah ini untuk mengajukan diri menjadi author.
                        </p>
                    </div>

                    <form action="{{ route('reader.author-request.submit') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="{{ auth()->user()->email }}" 
                                   disabled>
                            <small class="form-text text-muted">Email tidak dapat diubah</small>
                        </div>

                        <div class="form-group">
                            <label for="author_request_note">
                                Alasan Ingin Menjadi Author <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('author_request_note') is-invalid @enderror" 
                                      id="author_request_note" 
                                      name="author_request_note" 
                                      rows="5" 
                                      placeholder="Ceritakan mengapa Anda ingin menjadi author dan genre apa yang ingin Anda tulis..."
                                      required>{{ old('author_request_note') }}</textarea>
                            @error('author_request_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Minimal 50 karakter</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                       class="custom-control-input @error('agree') is-invalid @enderror" 
                                       id="agree" 
                                       name="agree" 
                                       required>
                                <label class="custom-control-label" for="agree">
                                    Saya setuju dengan <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a> menjadi author
                                </label>
                                @error('agree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg btn-block">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            @endif

        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan Author</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>1. Kewajiban Author</h6>
                <ul>
                    <li>Menulis konten original dan tidak plagiat</li>
                    <li>Tidak mengandung unsur SARA, pornografi, atau kekerasan berlebihan</li>
                    <li>Bertanggung jawab atas konten yang dipublikasikan</li>
                </ul>

                <h6>2. Hak Author</h6>
                <ul>
                    <li>Menerbitkan novel di platform</li>
                    <li>Mengelola novel dan chapter sendiri</li>
                    <li>Berinteraksi dengan pembaca</li>
                </ul>

                <h6>3. Larangan</h6>
                <ul>
                    <li>Melakukan plagiarisme atau copy-paste karya orang lain</li>
                    <li>Membuat konten yang melanggar hukum</li>
                    <li>Spam atau promosi berlebihan</li>
                </ul>

                <h6>4. Sanksi</h6>
                <p>Pelanggaran dapat mengakibatkan pemblokiran akun author.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Reapply Modal -->
<div class="modal fade" id="reapplyModal" tabindex="-1" role="dialog" aria-labelledby="reapplyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reapplyModalLabel">Ajukan Kembali</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reader.author-request.reapply') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengajukan kembali untuk menjadi author?</p>
                    <div class="form-group">
                        <label for="new_note">Alasan Pengajuan Ulang</label>
                        <textarea class="form-control" id="new_note" name="author_request_note" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Ajukan Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
    }
</style>
@endsection