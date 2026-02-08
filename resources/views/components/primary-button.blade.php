{{-- Primary Button Component
     Consistent primary button styling with dark mode support
     Usage: <x-primary-button>Click me</x-primary-button>
--}}
@props([
    'type' => 'submit',
    'disabled' => false
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 px-4 py-2 transition-all ease-in-out']) }}
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>
