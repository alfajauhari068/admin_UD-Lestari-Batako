{{-- Navbar Component
     Header for authenticated layout - works with sidebar
--}}
@php
    $currentRoute = request()->route()->getName();
@endphp

<header class="app-header" id="app-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        {{-- Left: Mobile Toggle & Brand --}}
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-outline-secondary d-md-none" id="menu-toggle-header" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="d-flex align-items-center">
                <h5 class="mb-0 fw-semibold">@yield('title', 'Dashboard')</h5>
            </div>
        </div>

        {{-- Right: Quick Actions --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Company Info (Desktop) --}}
            <div class="d-none d-md-flex text-muted small align-items-center gap-3">
                <span><i class="bi bi-geo-alt-fill me-1"></i> Jl. Raya Batako No. 123</span>
                <span><i class="bi bi-telephone-fill me-1"></i> +62 815-5367-5279</span>
            </div>

            {{-- User Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}">
                        <i class="bi bi-person me-2"></i>Profile
                    </a></li>
                    <li><a class="dropdown-item" href="/settings">
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
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('menu-toggle-header');
        const menuToggle = document.getElementById('menu-toggle');
        if (toggle && menuToggle) {
            toggle.addEventListener('click', function () {
                menuToggle.click();
            });
        }
    });
</script>
