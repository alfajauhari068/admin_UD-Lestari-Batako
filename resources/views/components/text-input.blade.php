{{-- Text Input Component
     Consistent input styling with dark mode support
     Usage: <x-text-input name="email" type="email" />
--}}
@props([
    'disabled' => false,
    'type' => 'text',
    'placeholder' => null,
    'error' => false
])

<input
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'form-control' . ($error ? ' is-invalid' : '')]) }}
    @if($disabled) disabled @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
/>
