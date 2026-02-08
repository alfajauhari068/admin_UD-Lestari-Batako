{{-- Secondary Button Component
     Consistent secondary button styling with dark mode support
     Usage: <x-secondary-button>Cancel</x-secondary-button>
--}}
@props([
    'type' => 'button',
    'disabled' => false
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-secondary d-inline-flex align-items-center justify-content-center gap-2 px-4 py-2 transition-all ease-in-out']) }}
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>
