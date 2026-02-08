{{-- Dropdown Component
     Consistent dropdown with Bootstrap and dark mode support
     Usage:
     <x-dropdown align="right">
         <x-slot:trigger>
             <x-btn>Options <i class="bi bi-chevron-down"></i></x-btn>
         </x-slot:trigger>
         <x-dropdown-link href="/profile">Profile</x-dropdown-link>
         <x-dropdown-link href="/settings">Settings</x-dropdown-link>
     </x-dropdown>
--}}
@props([
    'align' => 'right',
    'trigger' => null
])

@php
    $alignmentClasses = match($align) {
        'left' => 'dropdown-menu-start',
        'right' => 'dropdown-menu-end',
        default => 'dropdown-menu-end'
    };
@endphp

<div class="dropdown">
    {{ $trigger }}

    <ul class="dropdown-menu {{ $alignmentClasses }}">
        {{ $slot }}
    </ul>
</div>
