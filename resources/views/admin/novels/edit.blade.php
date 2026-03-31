@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Novel</h1>
                <p class="mb-0 text-muted small mt-1">Ubah informasi novel:
                    <strong>{{ $novel->judul ?? $novel->title }}</strong></p>
            </div>
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.novels.index') }}">Novel</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle fa-lg mr-3 mt-1"></i>
                            <ul class="mb-0 pl-0" style="list-style:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="card-header py-3" style="border-left: 4px solid #f6c23e; background: #f8f9fc;">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="fas fa-pencil-alt mr-2"></i>Form Edit Novel
                        </h6>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('admin.novels.update', $novel->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Judul --}}
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-gray-700 small">
                                    Judul Novel <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-book text-warning"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $novel->judul ?? $novel->title) }}"
                                        placeholder="Judul novel..." required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Genre --}}
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-gray-700 small">
                                    Genre <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-tags text-warning"></i>
                                        </span>
                                    </div>
                                    <select name="genre_id" class="form-control @error('genre_id') is-invalid @enderror">
                                        <option value="">-- Pilih Genre --</option>
                                        @foreach ($genres as $genre)
                                            <option value="{{ $genre->id }}"
                                                {{ old('genre_id', $novel->genre_id) == $genre->id ? 'selected' : '' }}>
                                                {{ $genre->nama_genre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('genre_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-gray-700 small">Sinopsis / Deskripsi</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5"
                                    placeholder="Sinopsis novel...">{{ old('description', $novel->sinopsis ?? $novel->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Approval --}}
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-gray-700 small">
                                    Status Approval <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-check-circle text-warning"></i>
                                        </span>
                                    </div>
                                    <select name="approval_status"
                                        class="form-control @error('approval_status') is-invalid @enderror">
                                        <option value="pending"
                                            {{ old('approval_status', $novel->approval_status) == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="published"
                                            {{ old('approval_status', $novel->approval_status) == 'published' ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="rejected"
                                            {{ old('approval_status', $novel->approval_status) == 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>
                                    @error('approval_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.novels.show', $novel->id) }}" class="btn btn-light border px-4">
                                    <i class="fas fa-arrow-left mr-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-warning text-white px-5">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
