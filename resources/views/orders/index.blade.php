@extends('layouts.default.app')

@section('title', 'Pesanan Saya')
@section('body.className', 'bg-default')

@push('stylesheets')
@endpush

@section('header')
    <div class="header bg-gradient-indigo py-5">
        <div class="container">
            <div class="header-body text-center">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid bg-gradient-indigo">
        <div class="container py-5">
            @include('layouts.flash')

            <h1 class="text-center text-white mb-4">Pesanan Saya</h1>

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(2) == '') active @endif" href="{{ route('orders.index') }}">Menunggu Pembayaran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(2) == 'process') active @endif" href="{{ route('orders.index', "process") }}">Sedang Proses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(2) == 'complete') active @endif" href="{{ route('orders.index', "complete") }}">Selesai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Request::segment(2) == 'cancel') active @endif" href="{{ route('orders.index', "cancel") }}">Pembatalan</a>
                        </li>
                    </ul>
                </div>
            </div>

            @forelse($orders as $order)
            <div class="card">
                <div class="card-header py-1 px-3">
                    <small class="mb-0">{{ $order->created_at->format('d M Y') }}</small>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="mb-0"><a href="{{ route('sellers.show', $order->seller) }}">{{ $order->seller->store_name }}</a></h4>
                            <small>{{ $order->no_invoice }}</small>
                        </div>
                        <div class="col-md-4 border-left">
                            <h5 class="mb-0">Status</h5>
                            <h4 class="mb-0 text-blue"><strong>{{ $order->status }}</strong></h4>
                        </div>
                        <div class="col-md-4 border-left">
                            <h5 class="mb-0">Total Belanja</h5>
                            <h4 class="mb-0 text-orange"><strong>{{ UserHelp::idr($order->total) }}</strong></h4>
                        </div>
                    </div>
                    <hr class="my-3" />
                    <x-order-detail-product :detail="$order->details->first()" />

                    @if($order->details->count() > 1)
                    <div class="collapse collapsible-details" id="collapse-details-{{ $order->id }}">
                        @foreach($order->details as $detail)
                            @if(!$loop->first)
                            <x-order-detail-product :detail="$detail" />
                            @endif
                        @endforeach
                    </div>
                    <a class="d-block text-center collapse-details mb-0" data-toggle="collapse" href="#collapse-details-{{ $order->id }}" role="button">
                        <small><span>Lihat</span> {{ $order->details->count()-1 }} produk lainnya</small>
                    </a>
                    @endif
                </div>
                <div class="card-footer px-3 py-2">
                    <a href="{{ route('orders.show', $order) }}" class="small"><i class="fa fa-eye fa-fw"></i> Lihat Detail Pesanan</a>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                Tidak ada data
            </div>
            @endforelse


            {{ $orders->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.collapsible-details').on('show.bs.collapse', function (e){
            $(e.target).siblings('a').find('span').text('Tutup');
        });
        $('.collapsible-details').on('hide.bs.collapse', function (e){
            $(e.target).siblings('a').find('span').text('Lihat');
        });
    </script>
@endpush
