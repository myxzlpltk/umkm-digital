@extends('layouts.default.app')

@section('title', 'Selamat Datang')
@section('body.className', 'bg-white')

@push('stylesheets')
    <style>
        #geolocate{
            cursor: pointer;
        }
        #geolocate:hover{
            color: #0c85d0;
        }
    </style>
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
                                    <h3 class="card-title">{{ UserHelp::greeting() }} Makanannya mau diantar kemana?</h3>
                                    <div class="form-group">
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Masukkan Alamat" type="text" name="label" id="label" autofocus>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="geolocate"><i class="fas fa-search-location"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <input type="hidden" name="accuracy" id="accuracy">
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
    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js"
            type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js"
            type="text/javascript" charset="utf-8"></script>
    <script>
        var isGeolocationPossible = false;
        var latlng;

        if(navigator.geolocation){
            isGeolocationPossible = true;
            navigator.geolocation.getCurrentPosition(pos => {
                latlng = pos.coords.latitude+","+pos.coords.longitude+","+pos.coords.accuracy;
                $('#latitude').val(pos.coords.latitude);
                $('#longitude').val(pos.coords.longitude);
                $('#accuracy').val(pos.coords.accuracy);
                geolocation();
            });
        }
        else{
            $('#geolocate').parent().remove();
            console.warn("Browser tidak mendukung geolokasi");
        }

        $('#geolocate').click(function (event){
            geolocation();
        });

        var platform = new H.service.Platform({ apikey: '{{ env('HERE_API_KEY') }}' });
        var service = platform.getSearchService();

        function geolocation(){
            if(isGeolocationPossible && latlng != undefined){
                service.reverseGeocode({ at: latlng }, result => {
                   $('#label').val(result.items[0].address.label).focus();
                });
            }
        }
    </script>
@endpush
