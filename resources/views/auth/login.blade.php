<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UD. Lestari Batako') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin-industrial.css') }}">
    <style>
        :root {
            --bg-auth-left: #ffffff;
            --bg-auth-right: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        [data-theme="dark"] {
            --bg-auth-left: #1e293b;
        }
        #auth {
            display: flex;
            min-height: 100vh;
        }
        #auth-left {
            flex: 1;
            background-color: var(--bg-auth-left);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #auth-right {
            flex: 1;
            background: var(--bg-auth-right);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        @media (max-width: 991px) {
            #auth {
                flex-direction: column;
            }
            #auth-right {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div id="auth">
        <!-- Bagian Kiri (Form Login) -->
        <div id="auth-left">
            <div class="auth-logo text-center mb-4">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('template/assets/images/logo/logo.svg') }}" alt="Logo" style="max-height: 50px;">
                </a>
            </div>
            <h1 class="auth-title text-center mb-2">Welcome Back</h1>
            <p class="auth-subtitle text-center text-muted mb-4">Please log in to your account to continue.</p>

            @if(session()->has('login_error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('login_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                @csrf
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off" required>
                    <div class="form-control-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block shadow-sm mt-3">Log in</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="font-bold text-primary text-decoration-none">Sign up</a>.</p>
            </div>
        </div>

        <!-- Bagian Kanan (Konten Tambahan) -->
        <div id="auth-right">
            <div class="text-center px-5">
                <h1 class="display-6 fw-bold mb-3">UD. Lestari Batako</h1>
                <p class="fs-6 opacity-75">Sistem manajemen batako berkualitas untuk kebutuhan industri Anda.</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
