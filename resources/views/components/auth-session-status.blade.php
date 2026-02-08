{{-- Authentication Session Status Component
     Displays session status messages with dark mode support
     Usage: <x-auth-session-status :status="session('status')" />
--}}
@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success alert-dismissible fade show shadow-sm border-0']) }} role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ $status }}</span>
        </div>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
