{{-- Sidebar Component (Flexbox Layout)
     Single source of truth for navigation sidebar
--}}
@php
    $currentRoute = request()->route()->getName();
    $user = auth()->user();
    $showKaryawan = $user && method_exists($user, 'hasRole') ? $user->hasRole('admin') : true;
@endphp

{{-- Mobile Toggle Button --}}
<button class="btn btn-primary d-md-none menu-toggle-btn" id="menu-toggle" aria-label="Toggle sidebar">
    <i class="bi bi-list"></i>
</button>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="sidebar-brand text-center py-4 px-3 border-bottom">
        <a href="{{ route('dashboard') }}" class="sidebar-brand-link d-flex flex-column align-items-center text-decoration-none">
            <img src="{{ asset('assets/Logo-LB.jpg') }}" alt="Logo" class="brand-logo mb-2">
            <span class="brand-text text-white fw-semibold small">UD. Lestari Batako</span>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav py-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
                    <i class="bi bi-house-door me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('produk.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'produk.') ? 'active' : '' }}">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Produk</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pelanggan.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'pelanggan.') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i>
                    <span>Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pesanan.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'pesanan.') ? 'active' : '' }}">
                    <i class="bi bi-cart-check-fill me-2"></i>
                    <span>Pesanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pengiriman.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'pengiriman.') ? 'active' : '' }}">
                    <i class="bi bi-truck me-2"></i>
                    <span>Pengiriman</span>
                </a>
            </li>
            @if($showKaryawan)
            <li class="nav-item">
                <a href="{{ route('karyawans.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'karyawans.') ? 'active' : '' }}">
                    <i class="bi bi-person-badge me-2"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('produksi.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'produksi.') ? 'active' : '' }}">
                    <i class="bi bi-gear-wide-connected me-2"></i>
                    <span>Produksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tim_produksi.index') }}" class="nav-link {{ str_starts_with($currentRoute, 'tim_produksi.') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data me-2"></i>
                    <span>Tim Produksi</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Footer Section --}}
    <div class="sidebar-footer mt-auto pt-3 px-3 border-top">
        <div class="d-flex align-items-center justify-content-between py-2">
            {{-- Dark Mode Toggle --}}
            <button id="sidebar-dark-toggle" class="btn btn-sm btn-outline-light" title="Toggle dark mode">
                <i class="bi bi-moon-stars"></i>
            </button>

            {{-- User Menu Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-md-inline">{{ Auth::user()->name ?? 'User' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="bi bi-person me-2"></i>Profile
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('settings.index') }}">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>

<style>
    /* Sidebar Styles - Flexbox Layout */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background-color: #1e293b;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        overflow-y: auto;
        flex-shrink: 0;
    }

    [data-theme="dark"] .sidebar {
        background-color: #0f172a;
    }

    .sidebar-brand {
        border-color: rgba(255, 255, 255, 0.1);
    }

    .brand-logo {
        height: 50px;
        width: auto;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
    }

    /* Nav Links */
    .nav-link {
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        margin: 0.125rem 0.5rem;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .nav-link.active {
        background-color: #f59e0b;
        color: #1e293b;
        font-weight: 600;
    }

    [data-theme="dark"] .nav-link.active {
        color: #0f172a;
    }

    .nav-link i {
        font-size: 1.125rem;
        width: 1.5rem;
        text-align: center;
        flex-shrink: 0;
    }

    .sidebar-footer {
        border-color: rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
    }

    /* Mobile Toggle Button */
    .menu-toggle-btn {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1100;
        display: none;
    }

    /* Mobile: Collapsed sidebar */
    @media (max-width: 767.98px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.sidebar-open {
            transform: translateX(0);
        }

        .menu-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body.sidebar-open {
            overflow: hidden;
        }
    }
</style>
