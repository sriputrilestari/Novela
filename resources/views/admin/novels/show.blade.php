@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Detail Novel</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body bg-white p-4">

            <div class="row">
                
                {{-- COVER --}}
                <div class="col-md-4 text-center">
                    @if($novel->cover)
                        <img src="{{ asset('storage/' . $novel->cover) }}" 
                             alt="Cover Novel" 
                             class="img-fluid rounded shadow"
                             style="max-width:250px;">
                    @else
                        <div class="border p-5 text-muted">
                            Tidak ada cover
                        </div>
                    @endif
                </div>

                {{-- DETAIL --}}
                <div class="col-md-8">

                    <h3 class="font-weight-bold">
                        {{ $novel->judul ?? $novel->title }}
                    </h3>

                    <hr>

                    <p>
                        <strong>Author:</strong> 
                        {{ $novel->author?->name }}
                    </p>

                    <p>
                        <strong>Genre:</strong> 
                        {{ $novel->genre?->nama_genre }}
                    </p>

                    <p>
                        <strong>Status:</strong> 
                        <span class="badge 
                            {{ $novel->approval_status == 'pending' ? 'badge-warning' : ($novel->approval_status == 'published' ? 'badge-success' : 'badge-danger') }}">
                            {{ ucfirst($novel->approval_status) }}
                        </span>
                    </p>

                    <hr>

                    <h5>Deskripsi</h5>
                    <div class="border rounded p-3 bg-light">
                        {{ $novel->description }}
                    </div>

                   <div class="mt-4 d-flex">

                    {{-- TOMBOL PUBLISH --}}
                    @if($novel->approval_status !== 'published')
                        <form action="{{ route('admin.novels.updateStatus', $novel->id) }}" 
                            method="POST" 
                            class="mr-2">
                            @csrf
                            <input type="hidden" name="approval_status" value="published">
                            <button type="submit" 
                                    class="btn btn-success"
                                    onclick="return confirm('Publish novel ini?')">
                                Publish
                            </button>
                        </form>
                    @endif


                    {{-- TOMBOL REJECT --}}
                    @if($novel->approval_status !== 'rejected')
                        <form action="{{ route('admin.novels.updateStatus', $novel->id) }}" 
                            method="POST" 
                            class="mr-2">
                            @csrf
                            <input type="hidden" name="approval_status" value="rejected">
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('Tolak novel ini?')">
                                Reject
                            </button>
                        </form>
                    @endif


                    {{-- KEMBALI --}}
                    <a href="{{ route('admin.novels.index') }}" 
                    class="btn btn-secondary">
                        Kembali
                    </a>

                </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
