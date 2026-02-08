@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid py-4">
    @component('components.page-header', [
        'title' => 'Profil Saya',
        'subtitle' => 'Kelola informasi profil dan akun Anda',
        'breadcrumbs' => [
            ['label' => 'Profil']
        ]
    ])
    @endcomponent

    <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
            {{-- Profile Card --}}
            @component('components.card')
                <div class="text-center py-4">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    @php
                        $roles = $user->getRoleNames();
                        $roleDisplay = $roles->isNotEmpty() ? $roles->first() : 'User';
                    @endphp
                    <span class="badge bg-primary">{{ $roleDisplay }}</span>
                </div>
                <div class="card-footer bg-transparent py-3 border-top">
                    <div class="row text-center small">
                        <div class="col">
                            <div class="text-muted">Bergabung</div>
                            <div class="fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            @endcomponent

            {{-- Quick Info --}}
            @component('components.card')
                <h6 class="fw-semibold mb-3">Informasi Akun</h6>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Status Email</span>
                    @if($user->email_verified_at)
                        <span class="badge bg-success-subtle text-success">Terverifikasi</span>
                    @else
                        <span class="badge bg-warning-subtle text-warning">Belum Verifikasi</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Terakhir Update</span>
                    <span class="small">{{ $user->updated_at->format('d M Y') }}</span>
                </div>
            @endcomponent
        </div>

        <div class="col-lg-8">
            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                        <i class="bi bi-person me-2"></i>Informasi Profil
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                        <i class="bi bi-key me-2"></i>Ubah Password
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="profileTabContent">
                {{-- Update Profile --}}
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    @include('profile.partials.update-profile')
                </div>

                {{-- Update Password --}}
                <div class="tab-pane fade" id="password" role="tabpanel">
                    @include('profile.partials.update-password')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
