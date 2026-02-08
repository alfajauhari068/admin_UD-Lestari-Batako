{{-- Responsive Navigation Link Component
     Consistent responsive nav link styling with dark mode support
     Usage: <x-responsive-nav-link href="/dashboard" :active="$active">Dashboard</x-responsive-nav-link>
--}}
@props([
    'href' => '#',
    'active' => false,
    'icon' => null
])

@php
    $classes = $active
        ? 'nav-link active d-flex align-items-center gap-2'
        : 'nav-link d-flex align-items-center gap-2';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="bi bi-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
