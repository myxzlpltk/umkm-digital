@extends('layouts.default.app')

@section('title', 'Selamat Datang')
@section('body.className', 'bg-gradient-primary')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endpush

@section('header')
@endsection

@section('content')
    <div class="container py-7 py-lg-8 pt-lg-9">
        @include('layouts.flash')
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
                                    <a href="{{ route('profile.google') }}" class="btn btn-sm btn-danger btn-block mr-4"><i class="fab fa-google fa-fw"></i> Hubungkan</a>
                                @else
                                    <hr/>
                                    <p class="card-title font-weight-bold">Akun Google</p>
                                    <img src="{{ route('profile.google.avatar') }}" alt="" class="avatar rounded-circle" data-toggle="tooltip" data-original-title="{{ $user->google_email }}">
                                    <p>{{ $user->google_name }}</p>
                                    <a href="{{ route('profile.google.disconnect') }}" class="btn btn-sm btn-danger btn-block mr-4"><i class="fab fa-google fa-fw"></i> Putuskan</a>
                                @endempty
                            </div>
                        </div>
                    </div>
                </div>

                @can('isSeller')
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
                    @else
                        <div class="card bg-gradient-orange">
                            <div class="card-body text-white">
                                <h3 class="card-title"><i class="fas fa-exclamation-triangle fa-fw"></i> Waduh....</h3>
                                <p class="card-subtitle">Kamu belum memiliki toko. Silahkan membuat mengisi formulir informasi penjual!</p>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
            <div class="col-md-6 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Edit profil </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Nama Lengkap <x-required/></label>
                                        <input type="text" id="input-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') ?: $user->name }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address <x-required/></label>
                                        <div class="input-group input-group-merge">
                                            <input type="email" id="input-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email') ?: $user->email }}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    @if($user->hasVerifiedEmail())
                                                        <i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" data-original-title="Terverifikasi"></i>
                                                    @else
                                                        <i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" data-original-title="Tidak Terverifikasi"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-avatar">Foto Profil</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="input-avatar" name="avatar" accept="image/*">
                                    <label class="custom-file-label" for="input-avatar">Pilih file</label>
                                </div>
                                @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
                        </form>
                        @can('isBuyerOrSeller')
                            <form action="@can('isBuyer') {{ route('profile.buyer') }} @elsecan('isSeller') {{ route('profile.seller') }} @endcan" method="POST" enctype="multipart/form-data">
                                @csrf
                                <hr class="my-4" />
                                @if(Gate::allows('isSeller') && $user->seller == NULL)
                                    <p class="text-info">Silahkan daftarkan data tokomu disini</p>
                                @endif
                                <h6 class="heading-small text-muted mb-4">Informasi {{ __($user->role) }}</h6>

                                <div class="row">
                                    <div class="col-md-12">
                                        @can('isSeller')
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-logo">Logo Toko <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-original-title="Rasio 1:1"></i></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="input-logo" name="logo" accept="image/*">
                                                    <label class="custom-file-label" for="input-logo">Pilih file</label>
                                                </div>
                                                @error('logo')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-banner">Banner Toko <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" data-original-title="Rasio 3:2"></i></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('banner') is-invalid @enderror" id="input-banner" name="banner" accept="image/*">
                                                    <label class="custom-file-label" for="input-banner">Pilih file</label>
                                                </div>
                                                @error('banner')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-store-name">Nama Toko <x-required/></label>
                                                <input id="input-store-name" name="store_name" class="form-control @error('store_name') is-invalid @enderror" placeholder="Masukkan nama toko" value="{{ old('store_name') ?: optional($user->userable)->store_name }}" type="text" required>
                                                @error('store_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endcan
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-address">Alamat Lengkap <x-required/></label>
                                            <input id="input-address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan alamat lengkap" value="{{ old('address') ?: optional($user->userable)->address }}" type="text" required>
                                            @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-phone-number">Nomor HP <x-required/></label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">+62</span>
                                                </div>
                                                <input id="input-phone-number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Masukkan nomor HP" value="{{ old('phone_number') ?: optional($user->userable)->phone_number }}" type="text" required>
                                            </div>
                                            @error('phone_number')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-bank-id">Nama Bank <x-required/></label>
                                            <select class="form-control @error('bank_id') is-invalid @enderror" name="bank_id" data-toggle="select" required>
                                                <option disabled hidden selected>--Pilih Bank--</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}" @if((old('bank_id') ?: optional($user->userable)->bank_id) == $bank->id) selected @endif>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('bank_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-account-number">Nomor Rekening <x-required/></label>
                                            <input type="text" id="input-account-number" name="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="Masukkan nomor rekening" value="{{ old('account_number') ?: optional($user->userable)->account_number }}" required>
                                        </div>
                                        @error('account_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-account-name">Atas Nama <x-required/></label>
                                            <input type="text" id="input-account-name" name="account_name" class="form-control @error('account_name') is-invalid @enderror" placeholder="Masukkan atas nama rekening" value="{{ old('account_name') ?: optional($user->userable)->account_name }}" required>
                                        </div>
                                        @error('account_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
                            </form>
                        @endcan
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Ganti Kata Sandi </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ $user->password == '' ? route('profile.password') : route('user-password.update') }}" method="post">
                            @method('put')
                            @csrf

                            @if($user->password)
                            <div class="form-group">
                                <label class="form-control-label" for="input-current-password">Kata Sandi Saat Ini <x-required/></label>
                                <input type="password" id="input-current-password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan kata sandi saat ini">
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="form-control-label" for="input-password">Kata Sandi Baru <x-required/></label>
                                <input type="password" id="input-password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi baru">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-password-confirmation">Konfirmasi Kata Sandi Baru <x-required/></label>
                                <input type="password" id="input-password-confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ketik ulang kata sandi baru">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Perbarui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/i18n/id.js') }}"></script>
@endpush
