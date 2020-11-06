@extends('layouts.default.app')

@section('title', 'Masuk')
@section('body.className', 'bg-default')

@section('header')
    <div class="header bg-gradient-blue py-7 py-lg-8 pt-lg-9">
        <div class="container">
            <div class="header-body text-center mb-7">
                <h1 class="text-white">Menunggu Verifikasi Email</h1>
                <p class="text-lead text-white">
                    Sebelum bisa melanjutkan akses, kamu harus memverifikasi email.<br>
                    Kami sudah mengirimkan pesan ke {{ auth()->user()->email }}.<br>
                    Silahkan cek di kotak masuk atau spam.
                </p>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text">{{ __(session('status')) }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="fa fa-times-circle"></i></span>
                        <span class="alert-text">{{ session('error') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form action="{{ route('verification.send') }}" method="POST" class="text-center">
                            @csrf
                            <p class="text-lead mb-0">Apabila kamu belum menerima email. Silahkan kirim ulang email konfirmasi</p>
                            <button type="submit" class="btn btn-primary my-4">Kirim Ulang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
