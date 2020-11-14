@extends('layouts.default.app')

@section('title', 'Selamat Datang')
@section('body.className', 'bg-white')

@push('stylesheets')
@endpush

@section('header')
    <div class="header bg-gradient-indigo py-7">
        <div class="container">
            <div class="header-body">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="pr-5">
                            <h1 class="display-2 text-white font-weight-bold mb-0">Warung Semur</h1>
                            <p class="text-white">Warung serba murah berkomitmen untuk menghubungkan penjual dan pembeli dalam satu genggaman.</p>
                            <div class="card mt-5">
                                <div class="card-body">
                                    <h3 class="card-title">{{ UserHelp::greeting() }} Kamu mau pesan apa?</h3>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Pesan apa aja..." type="text" name="label" id="label" autofocus>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{ asset('img/undraw_healthy_options_sdo3.svg') }}" alt="" class="img-fluid p-5">
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
@endsection

@section('content')
    <div class="container py-5 bg-white">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-3 text-dark">Lihat-lihat makanan enak, pilih yang kamu suka.</h3>
            </div>
            @foreach($sellers as $seller)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card text-dark">
                    <img src="{{ asset('storage/logos/'.$seller->logo) }}" class="card-img-top" alt="{{ $seller->store_name }}">
                    <div class="card-body">
                        <h5 class="h4 card-title mb-0">{{ $seller->store_name }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12 text-center">
                <a href="#" class="btn btn-primary">Tampilkan lebih banyak penjual</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
