@extends('layouts.console.app')

@section('title', 'Edit Produk')

@section('breadcrumbs', Breadcrumbs::render('manage.products.edit', $product))

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endpush

@section('actions')
@endsection

@section('card-stats')
@endsection

@section('header')
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="h3 mb-0">Formulir</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('manage.products.update', $product) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <div class="form-group">
                    <label class="form-control-label" for="input-category-id">Kategori <x-required/></label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="input-category-id" name="category_id" data-toggle="select" required>
                        <option disabled hidden selected>--Pilih Kategori--</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-image">Gambar Produk (opsional) <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-original-title="Rasio 1:1"></i></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="input-image" name="image" accept="image/*">
                        <label class="custom-file-label" for="input-image">Pilih file</label>
                    </div>
                    @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-food-name">Nama Produk <x-required/></label>
                    <input id="input-food-name" name="food_name" class="form-control @error('food_name') is-invalid @enderror" placeholder="Masukkan nama produk" value="{{ old('food_name', $product->name) }}" type="text" required>
                    @error('food_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="input-description">Deskripsi Produk</label>
                    <input id="input-description" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi produk" value="{{ old('description', $product->description) }}" type="text">
                    @error('description')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="input-stock">Stok Tersedia <x-required/></label>
                            <input id="input-stock" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="Masukkan stok" value="{{ old('stock', $product->stock) }}" type="number" min="0" required>
                            @error('stock')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="input-price">Harga Produk <x-required/></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp. </span>
                                </div>
                                <input id="input-price" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Masukkan harga produk" value="{{ old('price', $product->price) }}" type="number" min="1000" required>
                            </div>
                            @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="input-discount">Diskon <x-required/></label>
                            <div class="input-group">
                                <input id="input-discount" name="discount" class="form-control @error('discount') is-invalid @enderror" placeholder="Masukkan diskon produk" value="{{ old('discount', $product->discount) }}" type="number" min="0" max="95" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            @error('discount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/i18n/id.js') }}"></script>
@endpush
