@props(['type' => 'default', 'label'])

@php
    $map = [
        'success' => 'bg-success text-white',
        'warning' => 'bg-warning text-dark',
        'danger' => 'bg-danger text-white',
        'info' => 'bg-info text-dark',
        'default' => 'bg-secondary text-white'
    ];
    $class = $map[$type] ?? $map['default'];
@endphp

<span class="badge {{ $class }}">{{ $label }}</span>
