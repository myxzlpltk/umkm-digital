<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('/icons/logo64.png') }}" class="navbar-brand-img mr-3" alt="...">
                <span><strong>{{ __(Auth::user()->role) }}</strong></span>
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('manage') ? 'active' : '' }}" href="{{ route('manage') }}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">
                    <span class="docs-normal">Data Primer</span>
                </h6>
                <ul class="navbar-nav">
                    @can('view-any', \App\Models\Buyer::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'buyers' ? 'active' : '' }}" href="{{ route('manage.buyers.index') }}">
                            <i class="ni ni-user-run text-orange"></i>
                            <span class="nav-link-text">Pembeli</span>
                        </a>
                    </li>
                    @endcan

                    @can('view-any', \App\Models\Seller::class)
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'sellers' ? 'active' : '' }}" href="{{ route('manage.sellers.index') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Penjual</span>
                        </a>
                    </li>
                    @endcan
                </ul>
                @can('isAdmin')
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="ni ni-box-2 text-yellow"></i>
                                <span class="nav-link-text">Produk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="ni ni-money-coins text-default"></i>
                                <span class="nav-link-text">Transaksi</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Alat</span>
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ni ni-chart-pie-35"></i>
                                <span class="nav-link-text">Statistik Penjualan</span>
                            </a>
                        </li>
                    </ul>
                @elsecan('isSeller')
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="ni ni-box-2 text-orange"></i>
                                <span class="nav-link-text">Produk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="ni ni-tag text-primary"></i>
                                <span class="nav-link-text">Kategori</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="ni ni-money-coins text-default"></i>
                                <span class="nav-link-text">Transaksi</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">
                        <span class="docs-normal">Alat</span>
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="ni ni-chart-pie-35"></i>
                                <span class="nav-link-text">Statistik Penjualan</span>
                            </a>
                        </li>
                    </ul>
                @endcan
            </div>
        </div>
    </div>
</nav>
