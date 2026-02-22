<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('company.name', config('app.name', 'UD. Lestari Batako')) }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Vite (Laravel default assets) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap and theme assets (centralized) --}}
    <link href="{{ asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin-industrial.css') }}">

    {{-- Layout CSS Variables --}}
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 64px;
            --bg-color: #f8fafc;
            --text-color: #1e293b;
            --card-bg: #ffffff;
            --sidebar-bg: #1e293b;
            --border-color: #e2e8f0;
            --primary-color: #0ea5a3;
            --primary-hover: #0d9488;
        }

        [data-theme="dark"] {
            --bg-color: #0f172a;
            --text-color: #e2e8f0;
            --card-bg: #1e293b;
            --sidebar-bg: #0f172a;
            --border-color: #334155;
            --primary-color: #06b6d4;
            --primary-hover: #0891b2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
        }

        /* App Layout - Flexbox */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content Area */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0; /* Prevent flex overflow */
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .app-header {
            height: var(--header-height);
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Content */
        .app-content {
            flex: 1;
            padding: 1.5rem;
        }

        /* Footer */
        .app-footer {
            padding: 1rem 1.5rem;
            text-align: center;
            color: #6c757d;
            font-size: 0.875rem;
            border-top: 1px solid var(--border-color);
            background-color: var(--card-bg);
        }

        /* Card */
        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }

        /* Table */
        .table {
            --bs-table-bg: var(--card-bg);
            --bs-table-color: var(--text-color);
            --bs-table-border-color: var(--border-color);
        }

        .table-light {
            --bs-table-bg: #f1f5f9;
        }

        [data-theme="dark"] .table-light {
            --bs-table-bg: #334155;
        }

        /* Form controls */
        .form-control, .form-select {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: var(--card-bg);
        }

        /* Mobile: Collapsed sidebar */
        @media (max-width: 767.98px) {
            .main-area {
                margin-left: 0;
            }
        }
    </style>
</head>

@php
    $darkPref = false;
    if(auth()->check()){
        $darkPref = (bool) (auth()->user()->dark_mode ?? false);
    } else {
        $darkPref = session('dark_mode', false);
    }
@endphp

<body data-theme="{{ $darkPref ? 'dark' : 'light' }}">

    {{-- App Layout Wrapper --}}
    <div class="app-layout">

        {{-- Sidebar (global for authenticated users) --}}
        @auth
            @include('layouts.sidebar')
        @endauth

        {{-- Main Content Area --}}
        <div class="main-area" id="main-area">

            {{-- Header --}}
            @auth
                @include('layouts.navbar')
            @endauth

            {{-- Page Content --}}
            <main class="app-content">
                @yield('content')
            </main>

            {{-- Footer --}}
            @auth
                <footer class="app-footer">
                    <span>&copy; {{ date('Y') }} {{ setting('company.name', 'UD. Lestari Batako') }}. All rights reserved.</span>
                </footer>
            @endauth
        </div>
    </div>

    {{-- Confirmation Modal (global) --}}
    @include('components.confirm-modal')

    {{-- Bootstrap JS --}}
    <script src="{{ asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Dark Mode Toggle Script --}}
    <script src="{{ asset('js/dark-mode.js') }}"></script>

    {{-- Global helpers --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Mobile sidebar toggle
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const mainArea = document.getElementById('main-area');

            if (menuToggle && sidebar) {
                menuToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('sidebar-open');
                    document.body.classList.toggle('sidebar-open');
                });
            }
        });
    </script>
</body>
</html>
