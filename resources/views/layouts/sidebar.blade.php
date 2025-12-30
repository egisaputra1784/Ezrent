<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- PROFILE --}}
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-image">
                    <img src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/images/faces/face29.png">
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name">
                        {{ Auth::user()->nama }}
                    </p>
                    <p class="sidebar-designation">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>
                </div>
            </div>

            <p class="sidebar-menu-title">Menu</p>
        </li>

        {{-- DASHBOARD (SEMUA ROLE) --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- MENU SUPERADMIN --}}
        @if (Auth::user()->role === 'superadmin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.users.index') }}">
                    <i class="typcn typcn-group menu-icon"></i>
                    <span class="menu-title">Users (Admin)</span>
                </a>
            </li>
        @endif


    </ul>
</nav>
