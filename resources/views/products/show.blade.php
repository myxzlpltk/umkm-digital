@extends('layouts.console.app')

@section('title', 'Lihat Produk')

@section('breadcrumbs', Breadcrumbs::render('manage.products.show', $product))

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
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <img src="{{ asset('storage/products/'.$product->image) }}" alt="" class="card-img-top">

                <div class="card-body">
                    <h5 class="h3 card-title mb-0">{{ $product->name }}</h5>
                    <small class="text-muted">{{ $product->description }}</small>
                    <p class="card-text font-weight-bold mt-4">{{ UserHelp::idr($product->priceAfterDiscount) }}</p>
                    @if($product->discount > 0)
                    <span class="badge badge-default badge-lg bg-gradient-orange">Diskon {{ $product->discount }}% Off</span>
                    @endif
                </div>
            </div>

            @can('update', $product)
            <div class="card">
                <div class="card-body">
                    <h5 class="h3 card-title">Stok Tersedia</h5>
                    <form action="{{ route('manage.products.update-stock', $product) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="form-group input-stock">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-minus"></i></button>
                                </div>
                                <input type="number" value="{{ old('stock', $product->stock) }}" class="form-control text-center @error('stock') is-invalid @enderror" name="stock" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            @error('stock')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Perbarui</button>
                    </form>
                </div>
            </div>
            @endcan
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="h3 mb-0">Info Produk</h5>
                    <div>
                        @can('update', $product)
                        <a href="{{ route('manage.products.edit', $product) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
                        @endcan
                        @can('delete', $product)
                        <form class="d-inline" action="{{ route('manage.products.destroy', $product) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash fa-fw"></i> Hapus</a>
                        </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <dl>
                        @can('isAdmin')
                        <dt>Nama Toko</dt>
                        <dd>{{ $product->seller->store_name }}</dd>
                        @endcan
                        <dt>Nama</dt>
                        <dd>{{ $product->name }} <span class="badge badge-primary">{{ $product->category->name }}</span></dd>
                        <dt>Deskripsi</dt>
                        <dd>{{ $product->description }}</dd>
                        <dt>Harga</dt>
                        <dd>{{ UserHelp::idr($product->price) }}</dd>
                        @can('isAdmin')
                        <dt>Stok</dt>
                        <dd>{{ $product->stock }} Tersisa</dd>
                        @endcan
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
