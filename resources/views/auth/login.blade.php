@extends('layouts.default.app')

@section('body.className', 'bg-default')

@section('header')
    <div class="container">
        <div class="header-body text-center mb-7">
            <h1 class="text-white">Masuk</h1>
            <p class="text-lead text-white">Untuk memulai sesi silahkan masuk dengan akun kamu</p>
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
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><small>Masuk menggunakan</small></div>
                    <div class="btn-wrapper text-center">
                        <a href="#" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon"><img src="{{ url('icons/google.svg') }}"></span>
                            <span class="btn-inner--text">Google</span>
                        </a>
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>Atau gunakan kredensial</small>
                    </div>
                    <form action="{{ route('login') }}" method="POST" role="form">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email" type="email" name="email" value="{{ old('email') }}" autofocus required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
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
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="remember" @if(old('remember') == 'on') checked @endif>
                            <label class="custom-control-label" for="customCheckLogin">
                                <span class="text-muted">Ingat saya</span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary my-4">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <a href="#" class="text-light"><small>Lupa kata sandi?</small></a>
                </div>
                <div class="col-6 text-right">
                    <a href="#" class="text-light"><small>Buat akun</small></a>
                </div>
            </div>
        </div>
    </div>
@endsection
