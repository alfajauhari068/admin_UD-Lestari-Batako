<header class="page-header page-header--sticky bg-white shadow-sm rounded-3 mb-4">
  <div class="d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-outline-secondary d-md-none" id="menu-toggle-header" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
      <div class="d-flex align-items-center">
        <h5 class="mb-0 brand">@yield('title', config('app.name', 'UD Lestari Batako'))</h5>
      </div>
    </div>

    <div class="d-flex align-items-center gap-3">
      <div class="d-none d-md-flex text-muted small align-items-center">
        <i class="bi bi-geo-alt-fill me-1"></i> Jl. Raya Batako No. 123
      </div>
      <div class="d-none d-md-flex text-muted small align-items-center">
        <i class="bi bi-telephone-fill me-1"></i> +62 815-5367-5279
      </div>
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          {{ Auth::user()->name ?? 'User' }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
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
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menu-toggle-header');
    const menuToggle = document.getElementById('menu-toggle');
    if (toggle && menuToggle) {
      toggle.addEventListener('click', function () { menuToggle.click(); });
    }
  });
</script>