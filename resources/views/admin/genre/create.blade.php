@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Genre</h1>
                <p class="mb-0 text-muted small mt-1">Buat kategori genre novel baru</p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.genre.index') }}">Genre</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">

                {{-- Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle fa-lg mr-3 mt-1"></i>
                            <ul class="mb-0 pl-0" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="card-header py-3" style="border-left: 4px solid #4e73df; background: #f8f9fc;">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-plus-circle mr-2"></i>Form Tambah Genre
                        </h6>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('admin.genre.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-gray-700 small">
                                    Nama Genre <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-tag text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nama_genre"
                                        class="form-control @error('nama_genre') is-invalid @enderror"
                                        placeholder="Contoh: Romantis, Fantasi, Thriller..." value="{{ old('nama_genre') }}"
                                        required autofocus>
                                    @error('nama_genre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Nama genre harus unik dan belum pernah ditambahkan
                                    sebelumnya.</small>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.genre.index') }}" class="btn btn-light border px-4">
                                    <i class="fas fa-arrow-left mr-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-save mr-2"></i>Simpan Genre
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
