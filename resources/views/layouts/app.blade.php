<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UD. Lestari Batako') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Vite (Laravel default assets) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap and theme assets (centralized) --}}
    <link href="{{ asset('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin-industrial.css') }}">
    <style>
        :root{
            --bg-color: #ffffff;
            --text-color: #0f172a;
            --card-bg: #ffffff;
            --muted: #6b7280;
            --primary: #0ea5a3;
        }
        [data-theme="dark"]{
            --bg-color: #0b1220;
            --text-color: #e6eef6;
            --card-bg: #061021;
            --muted: #9ca3af;
            --primary: #06b6d4;
        }
        body{background-color:var(--bg-color); color:var(--text-color)}
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

    {{-- Site chrome: sidebar (global) --}}
    @include('layouts.sidebar')

    {{-- Main wrapper: header + page content (must be the single global wrapper) --}}
    <div class="main-wrapper" style="margin-left:250px">

        {{-- Header (contextual) inside main wrapper --}}
        @include('layouts.navbar')

        <div class="content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>

    </div>

    {{-- Bootstrap JS centralized --}}
    <script src="{{ asset('assets/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Non-Vite helper scripts (copied to public/js to avoid Vite manifest dependency) --}}
    <script src="{{ asset('js/dark-mode.js') }}"></script>

    {{-- Small global helpers: show/hide loading overlay if present --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Expose simple loading helpers for components
            window.showTableLoading = function(id){
                const el = document.getElementById(id);
                if(el) el.classList.add('show-loading');
            };
            window.hideTableLoading = function(id){
                const el = document.getElementById(id);
                if(el) el.classList.remove('show-loading');
            };
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

</body>
</html>
