@extends('layouts.console.app')

@section('title', 'Data '.ucwords(__($user->role)))

@section('breadcrumbs', Breadcrumbs::render('manage.users.show', $user))

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
                <div class="card-body">
                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 140px;">
                    <div class="pt-4 text-center">
                        <h5 class="h3 title">
                            <span class="d-block mb-1">{{ $user->name }}</span>
                            <small class="h4 font-weight-light text-muted">{{ __($user->role) }}</small>
                        </h5>
                        <div class="mt-3">
                            @empty($user->google_email)
                                <button type="button" class="btn btn-sm btn-danger btn-block mr-4"><i class="fab fa-google fa-fw"></i> Tidak Terhubung</button>
                            @else
                                <hr/>
                                <p class="card-title font-weight-bold">Akun Google</p>
                                <img src="{{ $user->google_avatar }}" alt="" class="avatar rounded-circle" data-toggle="tooltip" data-original-title="{{ $user->google_email }}">
                                <p>{{ $user->google_name }}</p>
                            @endempty
                        </div>
                    </div>
                </div>
            </div>

            @if($user->isSeller)
                @if($user->seller)
                    <div class="card card-profile">
                        <img src="{{ asset('storage/banners/'.$user->seller->banner) }}" alt="Banner Toko" class="card-img-top">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="{{ asset('storage/logos/'.$user->seller->logo) }}" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-end">
                                <span class="btn btn-sm btn-default float-right">Toko</span>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="text-center">
                                <h5 class="h3">{{ $user->seller->store_name }}</h5>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="col-md-6 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Data profil </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Nama Lengkap</h4>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h4>Email address</h4>
                            <p>
                                {{ $user->email }}
                                @if($user->hasVerifiedEmail())
                                    <i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" data-original-title="Terverifikasi"></i>
                                @else
                                    <i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" data-original-title="Tidak Terverifikasi"></i>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr class="my-2"/>
                    <h6 class="heading-small text-muted mb-4">Informasi {{ __($user->role) }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            @if($user->isSeller)
                                <h4>Nama Toko</h4>
                                <p>{{ optional($user->userable)->store_name }}</p>
                            @endif
                            <h4>Alamat Lengkap</h4>
                            <p>{{ optional($user->userable)->address }}</p>
                            <h4>Nomor HP</h4>
                            <p>+62{{ optional($user->userable)->phone_number }}</p>
                        </div>
                        <div class="col-lg-4">
                            <h4>Nama bank</h4>
                            <p>{{ optional(optional($user->userable)->bank)->name }}</p>
                            <h4>Nomor Rekening</h4>
                            <p>{{ optional($user->userable)->account_number }}</p>
                            <h4>Atas Nama</h4>
                            <p>{{ optional($user->userable)->account_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
