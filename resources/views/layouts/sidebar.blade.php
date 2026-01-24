<style>
/* Industrial Theme - Sidebar */

/* Sidebar base styling */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #1E293B;
    color: #FFFFFF;
    overflow-y: auto;
    z-index: 1000;
    padding: 1.5rem 0;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Responsiveness */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.show {
        transform: translateX(0);
    }
}

/* Sidebar brand wrapper */
.sidebar-brand-wrapper {
    padding: 1rem 1.5rem !important;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-brand {
    text-decoration: none;
}

.sidebar-brand img {
    max-height: 50px;
    object-fit: contain;
}

/* Horizontal divider */
.sidebar hr {
    border-color: rgba(255, 255, 255, 0.1) !important;
    margin: 0.5rem 0;
}

/* Navigation list */
.sidebar .nav {
    padding: 0.5rem 0;
}

.sidebar .nav-item {
    padding: 0 0.75rem;
}

/* Navigation link styling */
.sidebar .nav-link {
    font-size: 0.9375rem;
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    text-align: left;
    color: rgba(255, 255, 255, 0.8);
    transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sidebar .nav-link i {
    font-size: 1.1rem;
    opacity: 0.8;
}

/* Inactive link hover */
.sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #FFFFFF;
}

.sidebar .nav-link:hover i {
    opacity: 1;
}

/* Active link styling */
.sidebar .nav-link.active {
    background-color: #F59E0B;
    color: #1E293B;
    font-weight: 600;
}

.sidebar .nav-link.active i {
    color: #1E293B;
    opacity: 1;
}

/* Bootstrap link-dark override for sidebar context */
.sidebar .link-dark {
    color: rgba(255, 255, 255, 0.8) !important;
}

.sidebar .link-dark:hover {
    color: #FFFFFF !important;
}

/* Dropdown menu styling */
.sidebar .dropdown-menu {
    background-color: rgba(30, 41, 59, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 0.5rem 0;
}

.sidebar .dropdown-item {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.sidebar .dropdown-item:hover,
.sidebar .dropdown-item:focus {
    background-color: rgba(255, 255, 255, 0.1);
    color: #FFFFFF;
}

/* Dropdown toggle button */
.sidebar .btn-outline-primary {
    color: #FFFFFF;
    border-color: rgba(255, 255, 255, 0.3);
    background-color: transparent;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
}

.sidebar .btn-outline-primary:hover,
.sidebar .btn-outline-primary:focus {
    color: #1E293B;
    background-color: #F59E0B;
    border-color: #F59E0B;
}

.sidebar .dropdown-toggle::after {
    border-top-color: currentColor;
}

/* Dropdown divider */
.sidebar .dropdown-divider {
    border-color: rgba(255, 255, 255, 0.1);
}

/* Overlay for mobile view */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
    transition: opacity 150ms cubic-bezier(0.4, 0, 0.2, 1);
}

.overlay.show {
    display: block;
    opacity: 1;
}

/* Mobile menu toggle button */
#menu-toggle {
    background-color: #1E293B;
    border: 1px solid #E2E8F0;
    color: #FFFFFF;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

#menu-toggle:hover {
    background-color: #0F172A;
}

#menu-toggle i {
    font-size: 1.25rem;
}

/* positioned toggle for small screens */
.menu-toggle-btn{position:fixed; top:10px; left:10px; z-index:1100}

/* logo sizes in sidebar */
.sidebar .brand-logo img{height:70px; width:auto}
.sidebar .brand-logo-mini img{height:30px; width:auto}
</style>

<!-- Toggle Button -->
<button class="btn btn-primary d-md-none menu-toggle-btn" id="menu-toggle">
    <i class="bi bi-list"></i>
</button>

<!-- Overlay -->
<div class="overlay" id="sidebar-overlay"></div>

<!-- Sidebar -->
<div class="sidebar layout-sidebar" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center justify-content-center pt-5">
        <a class="sidebar-brand brand-logo" href="index.html">
            <img src="{{ asset('assets/Logo-LB.jpg') }}" alt="logo" />
        </a>
        <a class="sidebar-brand brand-logo-mini d-md-none" href="index.html">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo-mini" />
        </a>
    </div>
    <hr class="border-light">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : 'link-dark' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('produk.index') }}" class="nav-link {{ request()->is('produk') || request()->is('produk/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-box-seam me-2"></i> Produk
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->is('pelanggan') || request()->is('pelanggan/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-people-fill me-2"></i> Pelanggan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->is('pesanan') || request()->is('pesanan/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-cart-check-fill me-2"></i> Pesanan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('pengiriman.index') }}" class="nav-link {{ request()->is('pengiriman') || request()->is('pengiriman/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-truck me-2"></i> Pengiriman
            </a>
        </li>
        @php
            $user = auth()->user();
            // If Spatie role methods exist, require 'admin' role for Karyawan menu; otherwise show by default
            $showKaryawan = $user && method_exists($user, 'hasRole') ? $user->hasRole('admin') : true;
        @endphp
        @if($showKaryawan)
        <li class="nav-item mb-2">
            <a href="{{ route('karyawans.index') }}" class="nav-link {{ request()->is('karyawans') || request()->is('karyawans/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-person-badge me-2"></i> Karyawan
            </a>
        </li>
        @endif
        <li class="nav-item mb-2">
            <a href="{{ route('produksi.index') }}" class="nav-link {{ request()->is('produksi') || request()->is('produksi/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-gear-wide-connected me-2"></i> Produksi
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('tim_produksi.index') }}" class="nav-link {{ request()->is('tim-produksi') || request()->is('tim-produksi/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-clipboard-data me-2"></i> Tim Produksi
            </a>
        </li>
    </ul>
    <hr class="border-light">
    <div class="text-center mb-3">
        <div class="d-flex justify-content-center align-items-center gap-2 px-3">
            <button id="sidebar-dark-toggle" class="btn btn-sm btn-outline-light" title="Toggle dark mode">
                <i class="bi bi-moon-stars"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name ?? 'User' }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li><a class="dropdown-item" href="/settings">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuToggle = document.getElementById('menu-toggle');

        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    });
</script>