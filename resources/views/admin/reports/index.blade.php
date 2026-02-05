@extends('layouts.admin')

@section('content')
<h4>Laporan Novel</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Pelapor</th>
            <th>Novel</th>
            <th>Alasan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
        <tr>
            <td>{{ $report->user->name }}</td>
            <td>{{ $report->novel->judul }}</td>
            <td>{{ $report->alasan }}</td>
            <td>
                <span class="badge badge-warning">
                    {{ $report->status }}
                </span>
            </td>
            <td>
                <form method="POST" action="{{ route('admin.reports.updateStatus', [$report->id, 'reviewed']) }}">
                    @csrf
                    <button class="btn btn-sm btn-success">Tandai</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
