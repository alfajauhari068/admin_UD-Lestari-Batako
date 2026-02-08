@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid py-4">
    @component('components.page-header', [
        'title' => 'Pengaturan Sistem',
        'subtitle' => 'Kelola pengaturan perusahaan, tampilan, dan preferensi sistem',
        'breadcrumbs' => [
            ['label' => 'Pengaturan']
        ]
    ])
    @endcomponent

    {{-- Admin Access Notice --}}
    @auth
        @if(auth()->user()->hasRole('admin'))
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-shield-check fs-5 me-2"></i>
                <div>
                    <strong>Mode Administrator</strong>
                    <span class="ms-1">Anda memiliki akses penuh untuk mengelola semua pengaturan.</span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endauth

    {{-- Settings Tabs --}}
    <ul class="nav nav-tabs mb-4" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab">
                <i class="bi bi-building me-2"></i>
                <span class="d-none d-md-inline">Perusahaan</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ui-tab" data-bs-toggle="tab" data-bs-target="#ui" type="button" role="tab">
                <i class="bi bi-palette me-2"></i>
                <span class="d-none d-md-inline">Tampilan</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab">
                <i class="bi bi-gear me-2"></i>
                <span class="d-none d-md-inline">Sistem</span>
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="settingsTabContent">
        {{-- Company Settings --}}
        <div class="tab-pane fade show active" id="company" role="tabpanel">
            @include('settings.partials.company-settings')
        </div>

        {{-- UI Settings --}}
        <div class="tab-pane fade" id="ui" role="tabpanel">
            @include('settings.partials.ui-settings')
        </div>

        {{-- System Settings --}}
        <div class="tab-pane fade" id="system" role="tabpanel">
            @include('settings.partials.system-settings')
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        color: #64748b;
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        border: none;
        border-bottom: 2px solid transparent;
        background: none;
        transition: all 0.2s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #0ea5a3;
        border-bottom-color: rgba(14, 165, 163, 0.3);
    }

    .nav-tabs .nav-link.active {
        color: #0ea5a3;
        border-bottom-color: #0ea5a3;
        background: none;
    }

    .nav-tabs .nav-link i {
        font-size: 1.1rem;
    }

    @media (max-width: 767.98px) {
        .nav-tabs {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
        }
    }
</style>
@endsection
