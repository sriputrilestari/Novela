@extends('author.layouts.app')

@section('content')
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <h6 class="text-primary">Total Novel</h6>
                <h4>{{ $totalNovel }}</h4>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <h6 class="text-warning">Novel Pending</h6>
                <h4>{{ $novelPending }}</h4>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <h6 class="text-success">Total Chapter</h6>
                <h4>{{ $totalChapter }}</h4>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <h6 class="text-info">Total View</h6>
                <h4>{{ $totalView }}</h4>
            </div>
        </div>
    </div>

</div>
@endsection
