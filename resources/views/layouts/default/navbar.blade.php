<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('/icons/logo64.png') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
            <div class="navbar-collapse-header">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/icons/logo64.png') }}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <span class="nav-link-inner--text">Beranda</span>
                    </a>
                </li>
            </ul>
            <hr class="d-lg-none" />
            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                @if(Auth::guest() || Auth::user()->can('isBuyer'))
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ url('cart') }}" data-toggle="tooltip" data-original-title="Keranjang">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="nav-link-inner--text d-lg-none">Keranjang</span>
                    </a>
                </li>
                @endif

                @can('isSeller')
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ url('manage') }}" data-toggle="tooltip" data-original-title="Kelola Toko Saya">
                        <i class="fas fa-store"></i>
                        <span class="nav-link-inner--text d-lg-none">Kelola Toko Saya</span>
                    </a>
                </li>
                @endcan

                @include('layouts.login-button')
            </ul>
        </div>
    </div>
</nav>
