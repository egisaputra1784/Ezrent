<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- PROFILE --}}
        <li class="nav-item nav-profile">
            <div class="d-flex align-items-center px-3 py-4">

                {{-- AVATAR ICON --}}
                <div class="sidebar-profile-image d-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                    style="width:50px;height:50px;">
                    <i class="typcn typcn-user-outline" style="font-size:26px;"></i>
                </div>

                <div class="ml-3">
                    <p class="mb-0 font-weight-bold" style="color: white">
                        {{ Auth::user()->nama }}
                    </p>
                    <small class="text-muted">
                        {{ ucfirst(Auth::user()->role) }}
                    </small>
                </div>
            </div>

            <p class="sidebar-menu-title px-3 mt-2">MAIN MENU</p>
        </li>

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="typcn typcn-home-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- SUPERADMIN --}}
        @if (Auth::user()->role === 'superadmin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.users.index') }}">
                    <i class="typcn typcn-user-add-outline menu-icon"></i>
                    <span class="menu-title">Admin</span>
                </a>
            </li>
        @endif

        {{-- ADMIN --}}
        @if (Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('owner.index') }}">
                    <i class="typcn typcn-briefcase menu-icon"></i>
                    <span class="menu-title">Perusahaan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user-owner.index') }}">
                    <i class="typcn typcn-user-outline menu-icon"></i>
                    <span class="menu-title">Owner</span>
                </a>
            </li>
        @endif

        {{-- OWNER --}}
        @if (Auth::user()->role === 'owner')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user-kasir.index') }}">
                    <i class="typcn typcn-user-outline menu-icon"></i>
                    <span class="menu-title">Kasir</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('laporan.transaksi') }}">
                    <i class="typcn typcn-chart-bar-outline menu-icon"></i>
                    <span class="menu-title">Laporan</span>
                </a>
            </li>
        @endif

        {{-- KASIR --}}
        @if (Auth::user()->role === 'kasir')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.index') }}">
                    <i class="typcn typcn-group-outline menu-icon"></i>
                    <span class="menu-title">Customer</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('kategori.index') }}">
                    <i class="typcn typcn-th-large-outline menu-icon"></i>
                    <span class="menu-title">Kategori</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('produk.index') }}">
                    <i class="typcn typcn-box-outline menu-icon"></i>
                    <span class="menu-title">Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('transaksi.index') }}">
                    <i class="typcn typcn-clipboard menu-icon"></i>
                    <span class="menu-title">Transaksi</span>
                </a>
            </li>
        @endif

    </ul>
</nav>
