@extends('layouts.admin')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

@if($novelPending > 0)
<div class="alert alert-warning d-flex align-items-center shadow-sm">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Ada <strong class="mx-1">{{ $novelPending }}</strong> novel menunggu persetujuan
    <a href="#pending" class="ml-auto btn btn-sm btn-warning">
        Review Sekarang
    </a>
</div>
@endif


<div class="row">

    <!-- Total Novel -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Novel
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalNovel }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Author -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Author
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalAuthor }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-edit fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reader -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Reader
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalReader }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Novel Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $novelPending }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Tabel Novel Pending -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Novel Menunggu Persetujuan
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingNovels as $novel)
                    <tr>
                        <td>{{ $novel->judul }}</td>
                        <td>{{ $novel->author->name }}</td>
                        <td>
                            <span class="badge badge-warning">Pending</span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                            <a href="#" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Tidak ada novel pending
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- statistik -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Perbandingan Data
        </h6>
    </div>
    <div class="card-body">
        <div class="chart-pie pt-4">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById("donutChart");

    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Total Novel', 'Author', 'Reader', 'Pending'],
                datasets: [{
                    data: [
                        {{ $totalNovel }},
                        {{ $totalAuthor }},
                        {{ $totalReader }},
                        {{ $novelPending }}
                    ],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9',
                        '#17a673',
                        '#2c9faf',
                        '#dda20a'
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>

<!-- Top Readers -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Top Readers Paling Aktif
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Baca</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topReaders as $reader)
                    <tr>
                        <td>{{ $reader->name }}</td>
                        <td>{{ $reader->reading_histories_count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Belum ada data pembaca
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
