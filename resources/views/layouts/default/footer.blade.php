<footer class="py-5 bg-default">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-6">
                <div class="copyright text-center text-xl-left text-muted">
                    &copy; 2020 <a href="{{ url('/')  }}" class="font-weight-bold ml-1" target="_blank">{{ config('app.name', 'UMKM Digital') }}</a>
                </div>
            </div>
            <div class="col-xl-6">
                <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                    <li class="nav-item">
                        <a href="{{ url('about-us') }}" class="nav-link" target="_blank">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('license') }}" class="nav-link" target="_blank">Lisensi</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
