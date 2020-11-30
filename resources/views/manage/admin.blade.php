@extends('layouts.console.app')

@section('title', 'Dashboard')

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
    <div class="row">
        <div class="col-xl-8">
            <div class="card bg-default">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-light text-uppercase ls-1 mb-1">Kilasan</h6>
                            <h5 class="h3 text-white mb-0">Nilai penjualan</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Kualitas Transaksi</h6>
                            <h5 class="h3 mb-0">Persentase</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <script>
        $(document).ready(function (){
            $('#chart-bars').data('chart').data = {
                labels: {!! $qualities->pluck('month')->toJSON() !!},
                datasets: [{
                    label: 'Penjualan',
                    data: {!! $qualities->pluck('stat')->toJSON() !!}
                }]
            };
            $('#chart-bars').data('chart').update();

            $('#chart-sales-dark').data('chart').data = {
                labels: {!! $sells->pluck('month')->toJSON() !!},
                    datasets: [{
                    label: 'Pendapatan',
                    data: {!! $sells->pluck('stat')->toJSON() !!}
                }]
            };
            $('#chart-sales-dark').data('chart').update();
        })
    </script>
@endpush
