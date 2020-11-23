@extends('layouts.default.app')

@section('title', 'Waduuhhh... Kamu harus login terlebih dahulu')
@section('body.className', 'bg-white')

@push('stylesheets')
    <div class="header bg-gradient-indigo py-7 py-lg-8 pt-lg-9">
        <div class="container">
            <div class="header-body text-center mb-7">
                <h1 class="text-white">Waduuhhh...</h1>
                <p class="text-lead text-white">Kamu harus masuk terlebih dahulu sebelum melanjutkan</p>
                <a href="{{ route('login') }}" class="btn btn-white"><i class="fa fa-sign-in-alt fa-fw"></i> Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-white"><i class="fa fa-user fa-fw"></i> Daftar</a>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
@endpush

@section('header')
@endsection

@section('content')
@endsection

@push('scripts')
@endpush
