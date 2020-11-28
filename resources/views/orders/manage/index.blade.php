@extends('layouts.console.app')

@section('title', 'Transaksi')

@section('breadcrumbs', Breadcrumbs::render('manage.orders.index'))

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('actions')
@endsection

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Data Transaksi</h3>
        </div>
        <div class="table-responsive py-4">
            <table class="table align-items-center table-flush" id="datatable-basic">
                <thead class="thead-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <span>{{ $order->buyer->user->name }}</span>
                            <small class="d-block text-muted">{{ $order->address }}</small>
                        </td>
                        <td>{{ UserHelp::idr($order->total) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ route('manage.orders.show', $order) }}" class="table-action" data-toggle="tooltip" data-original-title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
