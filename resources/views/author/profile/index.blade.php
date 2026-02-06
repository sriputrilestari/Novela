@extends('author.layouts.app')

@section('content')
<h1 class="h3 mb-4">Profile Author</h1>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('author.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio" class="form-control">{{ auth()->user()->bio }}</textarea>
            </div>

            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="form-group">
                <label>Sosial Media</label>
                <input type="text" name="social" class="form-control"
                    value="{{ auth()->user()->social }}">
            </div>

            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
