<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/pages/auth.css') }}">
    @include('include.style')
</head>

<body>
    <div id="auth">
        <!-- Bagian Kiri (Form Register) -->
        <div id="auth-left">
            <div class="auth-logo text-center mb-3">
                <a href="index.html"><img src="{{ asset('template/assets/images/logo/logo.svg') }}" alt="Logo" class="logo-small"></a>
            </div>
            <h5 class="auth-title text-center title-small">Create an Account</h5>
            <p class="auth-subtitle text-center mb-4">Fill in the form below to create your account.</p>

            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Username" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('name')
                    <small class="btn btn-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email" required>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    @error('email')
                    <small class="btn btn-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    @error('password')
                    <small class="btn btn-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" name="password_confirmation" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-sm shadow-sm mt-3">Sign Up</button>
            </form>
            <div class="text-center mt-3">
                <p class="text-gray-600">Already have an account? <a href="{{ route('login') }}" class="font-bold text-primary">Log in</a>.</p>
            </div>
        </div>

        <!-- Bagian Kanan (Konten Tambahan) -->
        <div id="auth-right" class="d-flex align-items-center justify-content-center">
            <div class="text-center text-white px-5">
                <h1 class="display-6 fw-bold">Welcome to Our Platform</h1>
                <p class="fs-6">Join us and start managing your account with ease. Enjoy all the features we offer to make your experience seamless and efficient.</p>
            </div>
        </div>
    </div>
</body>

</html>
