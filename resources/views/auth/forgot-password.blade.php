@extends('layouts.default.app')

@section('title', 'Lupa Kata Sandi')
@section('body.className', 'bg-default')

@section('header')
    <div class="container">
        <div class="header-body text-center mb-7">
            <h1 class="text-white">Lupa Kata Sandi</h1>
            <p class="text-lead text-white">Tenang! Kami mengerti. Masukkan alamat email kamu untuk mereset kata sandi.</p>
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
            <div class="card bg-secondary border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <form action="{{ route('password.email') }}" method="POST" role="form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Alamat Email</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email" type="email" name="email" id="email" value="{{ old('email') }}" autofocus required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-4">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
