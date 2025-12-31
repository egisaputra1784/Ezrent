<nav class="navbar col-lg-12 col-12 fixed-top shadow-sm bg-white px-0">
    <div class="d-flex align-items-center w-100">

        {{-- LEFT : BRAND --}}
        <div class="d-flex align-items-center px-3" style="min-width:220px;">
            <a class="navbar-brand d-flex align-items-center mb-0" href="{{ route('dashboard') }}">
                <i class="typcn typcn-archive text-primary mr-2" style="font-size:1.4rem;"></i>
                <span class="font-weight-bold">EZRent</span>
            </a>
        </div>

        {{-- CENTER : NAMA PERUSAHAAN --}}
        <div class="flex-grow-1 d-flex justify-content-center">
            @if (Auth::user()->owner)
                <span class="badge badge-light px-4 py-2 shadow-sm text-center" style="font-size:1rem;">
                    <i class="typcn typcn-briefcase mr-1 text-primary"></i>
                    {{ Auth::user()->owner->nama_usaha }}
                </span>
            @else
                <span class="badge badge-light px-4 py-2 shadow-sm text-center">
                    <i class="typcn typcn-shield mr-1 text-primary"></i>
                    System Administrator
                </span>
            @endif
        </div>

        {{-- RIGHT : USER --}}
        <div class="d-flex align-items-center justify-content-end px-3" style="min-width:220px;">
            <ul class="navbar-nav">
                <li class="nav-item dropdown nav-profile">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
                        <i class="typcn typcn-user-outline mr-1"></i>
                        <span class="nav-profile-name">{{ Auth::user()->nama }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                        <div class="dropdown-item text-center text-muted small">
                            {{ ucfirst(Auth::user()->role) }}
                        </div>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="typcn typcn-power mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>

            {{-- MOBILE --}}
            <button class="navbar-toggler d-lg-none ml-2" type="button" data-toggle="offcanvas">
                <span class="typcn typcn-th-menu"></span>
            </button>
        </div>

    </div>
</nav>
