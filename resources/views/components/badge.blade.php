{{-- Badge Component
     Consistent badge styling with dark mode support
     Usage:
     <x-badge type="success">Active</x-badge>
     <x-badge type="danger" :pill="true">9+</x-badge>
--}}
@props([
    'type' => 'secondary',
    'pill' => false
])

@php
    $typeClasses = [
        'success' => 'bg-success',
        'warning' => 'bg-warning text-dark',
        'danger' => 'bg-danger',
        'info' => 'bg-info text-dark',
        'primary' => 'bg-primary',
        'secondary' => 'bg-secondary',
        'dark' => 'bg-dark',
        'light' => 'bg-light text-dark',
    ];

    $badgeClass = $typeClasses[$type] ?? $typeClasses['secondary'];
    $pillClass = $pill ? 'rounded-pill' : '';
@endphp

<span class="badge {{ $badgeClass }} {{ $pillClass }}">
    {{ $slot }}
</span>
