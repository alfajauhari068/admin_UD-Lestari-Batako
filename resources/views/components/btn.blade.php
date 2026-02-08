{{-- Universal Button Component
     Consistent button styling with dark mode support
     Variants: primary, secondary, success, danger, warning, info, outline-primary, outline-secondary, etc.
     Sizes: sm, md, lg
--}}
@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    // Base classes - consistent sizing and transitions
    $baseClasses = 'btn d-inline-flex align-items-center justify-content-center gap-2 transition-all ease-in-out';
    
    // Size classes - consistent sizing
    $sizeClasses = match($size) {
        'sm' => 'btn-sm px-3 py-1.5',
        'lg' => 'btn-lg px-4 py-2',
        default => 'px-4 py-2' // md - matches Bootstrap default
    };
    
    // Variant classes - all Bootstrap variants with dark mode support
    $variantClasses = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'info' => 'btn-info',
        'dark' => 'btn-dark',
        'light' => 'btn-light text-dark',
        'outline-primary' => 'btn-outline-primary',
        'outline-secondary' => 'btn-outline-secondary',
        'outline-success' => 'btn-outline-success',
        'outline-danger' => 'btn-outline-danger',
        'outline-warning' => 'btn-outline-warning',
        'outline-info' => 'btn-outline-info',
        'outline-dark' => 'btn-outline-dark',
        'ghost' => 'btn-link text-decoration-none',
        default => 'btn-primary'
    };
    
    // Focus and hover states for better UX
    $focusClasses = 'focus:shadow-sm';
    
    $classes = trim("{$baseClasses} {$sizeClasses} {$variantClasses} {$focusClasses}");
    
    $iconHtml = $icon ? "<i class=\"bi bi-{$icon}\"></i>" : '';
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}
       @if($disabled) aria-disabled="true" tabindex="-1" @endif>
        @if($icon && $iconPosition === 'left'){!! $iconHtml !!}@endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right'){!! $iconHtml !!}@endif
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @if($disabled) disabled @endif>
        @if($icon && $iconPosition === 'left'){!! $iconHtml !!}@endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right'){!! $iconHtml !!}@endif
    </button>
@endif
