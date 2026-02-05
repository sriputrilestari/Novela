@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.novels.update', $novel->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Judul</label>
    <input type="text" name="title" value="{{ $novel->title }}" class="form-control">

    <label>Genre</label>
    <select name="genre_id" class="form-control">
        @foreach($genres as $genre)
            <option value="{{ $genre->id }}" {{ $novel->genre_id == $genre->id ? 'selected' : '' }}>
                {{ $genre->name }}
            </option>
        @endforeach
    </select>

    <label>Deskripsi</label>
    <textarea name="description" class="form-control">{{ $novel->description }}</textarea>

    <label>Status Approval</label>
    <select name="approval_status" class="form-control">
        <option value="pending" {{ $novel->approval_status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="published" {{ $novel->approval_status == 'published' ? 'selected' : '' }}>Published</option>
        <option value="rejected" {{ $novel->approval_status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>

    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
</form>
@endsection