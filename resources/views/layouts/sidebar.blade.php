<!-- filepath: resources/views/layouts/sidebar.blade.php -->
<link href="..public\assets\bootstrap-5.3.6-dist\css\bootstrap.min.css" rel="stylesheet">
<script src="..public\assets\bootstrap-5.3.6-dist\js\bootstrap.bundle.min.js"></script>
<style>
/* Pastikan sidebar memiliki padding yang cukup */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #f8f9fa; /* Warna latar belakang terang */
    color: #333; /* Warna teks gelap */
    overflow-y: auto;
    z-index: 1000;
    padding: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

/* Responsivitas */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.show {
        transform: translateX(0);
    }
}

/* Pastikan navigasi rata kiri */
.nav-link {
    font-size: 16px;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 5px;
    text-align: left; /* Rata kiri */
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Aktifkan warna untuk link aktif */
.nav-link.active {
    background-color: #007bff;
    color: #fff !important;
}

/* Hover efek */
.nav-link:hover {
    background-color: #e9ecef;
    color: #007bff !important;
}

/* Dropdown menu styling */
.dropdown-menu {
    text-align: left; /* Rata kiri untuk dropdown */
}
</style>

<!-- Toggle Button -->
<button class="btn btn-primary d-md-none" id="menu-toggle" style="position: fixed; top: 10px; left: 10px; z-index: 1100;">
    <i class="bi bi-list"></i>
</button>

<!-- Overlay -->
<div class="overlay" id="sidebar-overlay"></div>

<!-- Sidebar -->
<div class="sidebar " id="sidebar">
   
    <hr class="border-light">
    <ul class="nav flex-column mt-5">
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
        <li class="nav-item mb-2">
            <a href="{{ route('karyawans.index') }}" class="nav-link {{ request()->is('karyawans') || request()->is('karyawans/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-person-badge me-2"></i> Karyawan
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('produksi.index') }}" class="nav-link {{ request()->is('produksi') || request()->is('produksi/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-gear-wide-connected me-2"></i> Produksi
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('produksi_karyawan.index') }}" class="nav-link {{ request()->is('produksi-karyawan') || request()->is('produksi-karyawan/*') ? 'active' : 'link-dark' }}">
                <i class="bi bi-clipboard-data me-2"></i> Karyawan Produksi
            </a>
        </li>
    </ul>
    <hr class="border-light">
    <div class="dropdown text-center">
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