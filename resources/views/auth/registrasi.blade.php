<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UD. Lestari Batako') }} - Register</title>
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
        .logo-small {
            max-height: 40px;
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
        <!-- Bagian Kiri (Form Register) -->
        <div id="auth-left">
            <div class="auth-logo text-center mb-4">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('template/assets/images/logo/logo.svg') }}" alt="Logo" class="logo-small">
                </a>
            </div>
            <h5 class="auth-title text-center mb-2">Create an Account</h5>
            <p class="auth-subtitle text-center text-muted mb-4">Fill in the form below to create your account.</p>

            <form action="" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Username" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('name')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block shadow-sm mt-3">Sign Up</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="font-bold text-primary text-decoration-none">Log in</a>.</p>
            </div>
        </div>

        <!-- Bagian Kanan (Konten Tambahan) -->
        <div id="auth-right">
            <div class="text-center px-5">
                <h1 class="display-6 fw-bold mb-3">UD. Lestari Batako</h1>
                <p class="fs-6 opacity-75">Bergabunglah dan mulai kelola akun Anda dengan mudah.</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
