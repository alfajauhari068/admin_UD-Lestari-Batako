{{-- Dropdown Link Component
     Consistent dropdown link styling with dark mode support
     Usage: <x-dropdown-link href="/profile">Profile</x-dropdown-link>
--}}
@props([
    'href' => '#',
    'active' => false
])

<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'dropdown-item' . ($active ? ' active' : '')]) }}>
        {{ $slot }}
    </a>
</li>
