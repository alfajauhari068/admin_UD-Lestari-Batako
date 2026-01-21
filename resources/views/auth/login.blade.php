@extends('layouts.app')

@section('content')
    <div id="auth">
        <!-- Bagian Kiri (Form Login) -->
        <div id="auth-left">
            <div class="auth-logo text-center mb-4">
                <a href="index.html"><img src="{{ asset('template/assets/images/logo/logo.svg') }}" alt="Logo"></a>
            </div>
            <h1 class="auth-title text-center">Welcome Back</h1>
            <p class="auth-subtitle text-center mb-4">Please log in to your account to continue.</p>

            <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                @csrf
                @if(session()->has('login_error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{session('login_error')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                    
                @endif
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="email" id="email" name="email" name="prevent_autofill" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off" required>
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group position-relative has-icon-left mb-3">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off" required>
                    <div class="form-control-icon">
                        <i class="bi bi-lock"></i>
                    </div>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-sm shadow-sm mt-3">Log in</button>
            </form>
            <div class="text-center mt-3">
                <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold text-primary">Sign up</a>.</p>
            </div>
        </div>

        <!-- Bagian Kanan (Konten Tambahan) -->
        <div id="auth-right">
            <div class="text-center text-white px-5">
                <h1 class="display-6 fw-bold">Welcome to Our Platform</h1>
                <p class="fs-6">Access all features and manage your account with ease.</p>
            </div>
        </div>
    </div>
    </div>
@endsection
