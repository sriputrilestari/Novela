@extends('author.layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-body">

        <form action="{{ route('author.novel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Judul Novel</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

           <div class="form-group">
                <label>Genre</label>
                <select name="genre_id" class="form-control" required>
                    <option value="">-- Pilih Genre --</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">
                            {{ $genre->nama_genre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Sinopsis</label>
                <textarea name="sinopsis" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" class="form-control">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label>Cover Novel</label>
                <input type="file" name="cover" class="form-control-file">
            </div>

            <button class="btn btn-primary">Simpan</button>

        </form>

    </div>
</div>
@endsection
