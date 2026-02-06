@extends('author.layouts.app')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Edit Novel</h1>

        <div class="card shadow">
            <div class="card-body">

                <form action="{{ route('author.novels.update', $novel->id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Judul Novel</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ $novel->title }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Genre</label>
                        <select name="genre_id" class="form-control">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}"
                                    {{ $novel->genre_id == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description"
                                  rows="4"
                                  class="form-control">{{ $novel->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="draft"
                                {{ $novel->status == 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>
                            <option value="pending"
                                {{ $novel->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="publish"
                                {{ $novel->status == 'publish' ? 'selected' : '' }}>
                                Publish
                            </option>
                        </select>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('author.novels.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit"
                                class="btn btn-warning">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
