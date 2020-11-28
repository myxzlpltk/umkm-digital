@extends('layouts.console.app')

@section('title', 'Detail Transaksi')

@section('breadcrumbs', Breadcrumbs::render('manage.orders.show', $order))

@push('stylesheets')
@endpush

@section('actions')
@endsection

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-body">
                <dl>
                    <dt>Nomor Pesanan</dt>
                    <dd>{{ $order->no_invoice }}</dd>
                    <dt>Status</dt>
                    <dd>{{ $order->status }}</dd>
                    <dt>Nama Toko</dt>
                    <dd>
                        <a href="{{ route('sellers.show', $order->seller) }}">{{ $order->seller->store_name }}</a>
                        <p class="mb-0">Telp: +62{{ $order->seller->phone_number }}</p>
                    </dd>
                    <dt>Tanggal Pembelian</dt>
                    <dd>{{ $order->created_at->format('d M Y H:i') }}</dd>
                    <dt>Bukti Pembayaran</dt>
                    @if($order->payment_proof)
                        <dd><a href="{{ asset('storage/payments/'.$order->payment_proof) }}" target="_blank">Klik Disini</a></dd>
                    @else
                        <dd><em>Belum ada bukti pembayaran</em></dd>
                    @endif
                </dl>
            </div>
        </div>
        <div class="col-md-4">
            <x-bank-card :bank="$order->seller->bank" :number="$order->seller->account_number" :name="$order->seller->account_name" />
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3><i class="fa fa-list fa-fw"></i> Daftar Produk</h3>
            @foreach($order->details as $detail)
                    <x-order-detail-product :detail="$detail" :action="false" />
            @endforeach
            <p>Total belanja <span class="font-weight-bold text-orange">{{ UserHelp::idr($order->total) }}</span></p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3><i class="fa fa-shipping-fast fa-fw"></i> Pengiriman</h3>
            <p class="mb-0">Dikirim kepada <b class="font-weight-bold">{{ $order->buyer->user->name }}</b></p>
            <p class="mb-0">{{ $order->buyer->address }}</p>
            <p class="mb-0">Telp: +62{{ $order->buyer->phone_number }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3><i class="fa fa-history fa-fw"></i> Pelacakan</h3>

            @foreach($order->tracks->sortBy('created_at') as $track)
                <div class="row">
                    <div class="col-auto">
                        <small class="mb-0">{{ $track->created_at->format('d F Y H:i') }}</small>
                    </div>
                    <div class="col">
                        <p class="mb-0">{{ $track->status }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
@endpush
