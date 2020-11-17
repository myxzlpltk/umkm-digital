@auth
    <li class="nav-item dropdown">
        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                    <img alt="Avatar" src="{{ auth()->user() ? asset('storage/avatars/'.auth()->user()->avatar) : asset('img/theme/team-4.jpg') }}">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ head(explode(' ', trim(auth()->user()->name))) }}</span>
                </div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Selamat Datang!</h6>
            </div>
            @can('isAdmin')
            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                <i class="ni ni-tv-2"></i>
                <span>Konsol Admin</span>
            </a>
            @endcan
            <a href="{{ route('profile') }}" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>Profil</span>
            </a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="ni ni-user-run"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </li>
@else
    <li class="nav-item ml-lg-4">
        <a href="{{ route('login') }}" class="btn btn-neutral btn-icon">
            <span class="btn-inner--icon">
                <i class="fa fa-sign-in-alt mr-2"></i>
            </span>
            <span class="nav-link-inner--text">Masuk</span>
        </a>
    </li>
@endif
