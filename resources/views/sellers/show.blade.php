@extends('layouts.default.app')

@section('title', $seller->store_name)
@section('body.className', 'bg-white')

@push('stylesheets')
    <style>
        .description{
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 12px;
            font-size: 12px;
        }
        .header{
            background-image: url("{{ asset('storage/banners/'.$seller->banner) }}");
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }
    </style>
@endpush

@section('header')
    <div class="header">
        <div class="header-body">
            <div class="container pt-7">
                <div class="row">
                    <div class="col-12 col-sm-4 col-md-3">
                        <div class="card">
                            <img src="{{ asset('storage/logos/'.$seller->logo) }}" class="card-img">
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-9">
                        <div class="card card-body bg-gradient-white">
                            <div class="row">
                                <div class="col-12 col-md-8 mb-3 mb-md-0">
                                    <h1 class="h2">{{ $seller->store_name }}</h1>

                                    @if($isOpen)
                                        <span class="badge badge-success badge-lg mr-3">BUKA</span>
                                        <span>Tutup jam {{ \Carbon\Carbon::parse($tomorrow->pivot->end)->format('H:i') }}</span>
                                    @else
                                        <span class="badge badge-danger badge-lg mr-3">TUTUP</span>
                                        <span>Buka lagi jam {{ \Carbon\Carbon::parse($tomorrow->pivot->start)->format('H:i') }} @if($tomorrow == $today) hari ini @else besok @endif</span>
                                    @endif

                                    <div class="mt-3">
                                        @foreach($seller->days as $day)
                                            <p class="mb-0 d-flex justify-content-between">
                                                <span class="font-weight-bold">{{ $day->name }}</span>
                                                <span>{{ \Carbon\Carbon::parse($tomorrow->pivot->start)->format('H:i') }}-{{\Carbon\Carbon::parse($tomorrow->pivot->end)->format('H:i')}}</span>
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3 mb-md-0">
                                    <h4>Alamat</h4>
                                    <p>{{ $seller->address }}</p>
                                    <a href="{{ url('https://www.google.com/maps/search/?api=1&query='.urlencode($seller->address)) }}" target="_blank" class="card-link"><i class="fa fa-map-marked fa-fw"></i> Lihat Peta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container bg-white py-5">
        @foreach($seller->categories as $category)
        <div id="{{ Str::slug($category->name) }}">
            <h3>{{ $category->name }}</h3>

            <div class="row">
                @foreach($category->products as $product)
                    <div class="col-12 col-sm-6 col-md-4 p-2">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
@endpush
