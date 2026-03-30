@extends('author.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Novel</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('author.novel.update', $novel->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- JUDUL --}}
                <div class="form-group">
                    <label>Judul Novel</label>
                    <input type="text"
                           name="judul"
                           class="form-control"
                           value="{{ $novel->judul }}"
                           required>
                </div>

                {{-- GENRE --}}
                <div class="form-group">
                    <label>Genre</label>
                    <select name="genre_id" class="form-control" required>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}"
                                {{ $novel->genre_id == $genre->id ? 'selected' : '' }}>
                                {{ $genre->nama_genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SINOPSIS --}}
                <div class="form-group">
                    <label>Sinopsis</label>
                    <textarea name="sinopsis"
                              rows="4"
                              class="form-control"
                              required>{{ $novel->sinopsis }}</textarea>
                </div>

                {{-- COVER --}}
                <div class="form-group">
                    <label>Cover Novel</label><br>

                    @if ($novel->cover)
                        <img src="{{ asset('storage/' . $novel->cover) }}"
                             width="120"
                             class="mb-2 d-block rounded shadow">
                    @endif

                    <input type="file"
                           name="cover"
                           class="form-control-file">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti cover
                    </small>
                </div>

                {{-- STATUS --}}
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="ongoing"
                            {{ $novel->status == 'ongoing' ? 'selected' : '' }}>
                            Ongoing
                        </option>
                        <option value="completed"
                            {{ $novel->status == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <div class="text-right">
                    <a href="{{ route('author.novel.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-warning">
                         <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
