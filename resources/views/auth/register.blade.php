@extends('layouts.default.app')

@section('title', 'Pendaftaran')
@section('body.className', 'bg-default')

@push('stylesheets')
    <style>
        #tabs-text .nav-link.active{
            background-color: #24a46d!important;
        }
    </style>
@endpush

@section('header')
    <div class="container">
        <div class="header-body text-center mb-7">
            <h1 class="text-white">Pendaftaran</h1>
            <p class="text-lead text-white">Buat akun kamu sekarang juga</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text">{{ session('status') }}</span>
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
            <ul class="nav nav-pills nav-fill flex-column flex-sm-row mb-3" id="tabs-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 @if(old('role') != 'seller') active @endif" id="pembeli-tab" data-value="buyer" data-toggle="tab" href="#pembeli" role="tab" aria-controls="pembeli" aria-selected="true">Pembeli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-sm-3 mb-md-0 @if(old('role') == 'seller') active @endif" id="penjual-tab" data-value="seller" data-toggle="tab" href="#penjual" role="tab" aria-controls="penjual" aria-selected="false">Penjual</a>
                </li>
            </ul>
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><small>Daftar sebagai <span id="role_text">pembeli</span> menggunakan</small></div>
                    <div class="btn-wrapper text-center">
                        <form action="{{ route('register.google') }}" method="get">
                            <input type="hidden" id="role2" name="role" value="{{ old('role', 'buyer') }}">
                            <button type="submit" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ url('icons/google.svg') }}"></span>
                                <span class="btn-inner--text">Google</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-1">
                    <div class="text-center text-muted mb-4">
                        <small>Atau daftarkan diri secara manual</small>
                    </div>
                    <form action="{{ route('register') }}" method="POST" role="form" id="form-register">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input class="form-control" placeholder="Nama Lengkap" type="text" name="name" value="{{ old('name') }}" autofocus required>
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="Kata Sandi" type="password" name="password" required>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="Ketik Ulang Kata Sandi" type="password" name="password_confirmation" required>
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" id="role" name="role" value="{{ old('role', 'buyer') }}">
                        <div class="text-center">
                            <button type="button" class="btn btn-primary my-4 g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onSubmit" data-action="submit">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <a href="{{ route('login') }}" class="text-light"><small>Sudah punya akun?</small></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#role, #role2').val($(e.target).data('value'));
            $('#role_text').text($(e.target).text().toLowerCase());
        });

        function onSubmit(token) {
            $('#form-register').submit();
        }
    </script>
@endpush
