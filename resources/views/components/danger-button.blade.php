{{-- Danger Button Component
     Consistent danger button styling with dark mode support
     Usage: <x-danger-button>Delete</x-danger-button>
--}}
@props([
    'type' => 'submit',
    'disabled' => false
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-danger d-inline-flex align-items-center justify-content-center gap-2 px-4 py-2 transition-all ease-in-out']) }}
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>
