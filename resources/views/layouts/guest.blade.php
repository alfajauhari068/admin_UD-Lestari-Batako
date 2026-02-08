<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UD. Lestari Batako') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap --}}
    <link href="{{ asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin-industrial.css') }}">

    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
        }
        [data-theme="dark"] {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
        }
        body {
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background-color: var(--card-bg);
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 420px;
        }
        [data-theme="dark"] .auth-card {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>
    {{-- Authentication Card --}}
    <div class="auth-card">
        {{-- Logo / Brand --}}
        <div class="text-center mb-4">
            <a href="/" class="text-decoration-none d-flex flex-column align-items-center">
                <img src="{{ asset('assets/Logo-LB.jpg') }}" alt="Logo" style="height: 60px;" class="mb-2">
                <span class="h5 mb-0 text-dark">UD. Lestari Batako</span>
            </a>
        </div>

        {{-- Content --}}
        {{ $slot }}
    </div>

    {{-- Bootstrap JS --}}
    <script src="{{ asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
