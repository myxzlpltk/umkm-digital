@extends('layouts.default.app')

@section('title', 'Informasi Pemesanan')
@section('body.className', 'bg-default')

@push('stylesheets')
@endpush

@section('header')
    <div class="header bg-gradient-info py-5">
        <div class="container">
            <div class="header-body text-center">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid bg-gradient-info">
        <div class="container py-5">
            @include('layouts.flash')

            <h1 class="text-center text-white mb-4">Detail Pesanan</h1>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
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

                        @can('delivery-complete', $order)
                        <div class="card-footer">
                            <form class="d-inline" action="{{ route('order.delivery-complete', $order) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <a href="javascript:void(0)" class="btn btn-success btn-sm btn-alert"><i class="fa fa-check fa-fw"></i> Pesanan Telah Diterima</a>
                            </form>
                        </div>
                        @endcan
                        @can('cancel', $order)
                        <div class="card-footer">
                            <form class="d-inline" action="{{ route('order.cancel', $order) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-alert"><i class="fa fa-ban fa-fw"></i> Batalkan Pesanan</a>
                            </form>
                        </div>
                        @endcan
                        @can('request-refund', $order)
                        <div class="card-footer">
                            <form class="d-inline" action="{{ route('order.request-refund', $order) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-alert"><i class="fa fa-ban fa-fw"></i> Batalkan & Minta Kembalikan Dana</a>
                            </form>
                        </div>
                        @endcan
                        @can('refund-complete', $order)
                        <div class="card-footer">
                            <form class="d-inline" action="{{ route('order.refund-complete', $order) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <a href="javascript:void(0)" class="btn btn-success btn-sm btn-alert"><i class="fa fa-check fa-fw"></i> Dana Telah Dikembalikan</a>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
                <div class="col-md-4">
                    @if($order->status_code == \App\Models\Order::PAYMENT_PENDING)
                        <div class="alert alert-info">
                            Segera lakukan sebesar <b class="font-weight-bold">{{ UserHelp::idr($order->total) }}</b> pembayaran ke penjual
                        </div>
                    @elseif($order->status_code == \App\Models\Order::PAYMENT_IN_PROCESS)
                        <div class="alert alert-info">
                            Pembayaran kamu masih diproses
                        </div>
                    @endif
                    <x-bank-card :bank="$order->seller->bank" :number="$order->seller->account_number" :name="$order->seller->account_name" />

                    @if($order->status_code == \App\Models\Order::PAYMENT_PENDING || $order->status_code == \App\Models\Order::PAYMENT_IN_PROCESS)
                    <div class="card card-body">
                        <form action="{{ route('orders.payment', $order) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class="form-control-label" for="input-payment-proof">Bukti Transfer</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('payment_proof-proof') is-invalid @enderror" id="input-payment-proof" name="payment_proof" accept="image/*">
                                    <label class="custom-file-label" for="input-payment-proof">Pilih file</label>
                                </div>
                                @error('payment_proof')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> Simpan</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3><i class="fa fa-list fa-fw"></i> Daftar Produk</h3>
                    @foreach($order->details as $detail)
                        <x-order-detail-product :detail="$detail" />
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

        </div>
    </div>
@endsection

@push('scripts')
@endpush
