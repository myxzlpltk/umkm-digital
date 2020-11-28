@extends('layouts.console.app')

@section('title', 'Toko Saya')

@section('breadcrumbs', Breadcrumbs::render('manage'))

@push('stylesheets')
@endpush

@section('card-stats')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Produk</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $stat_product }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-box-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Kategori</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $stat_category }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-tag"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Total Transaksi</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $stat_transaction }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Transaksi Gagal</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $stat_canceled }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('header')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Data Transaksi Saat Ini</h3>
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
@endpush
