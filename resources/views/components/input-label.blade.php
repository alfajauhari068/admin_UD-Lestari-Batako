{{-- Input Label Component
     Consistent label styling with dark mode support
     Usage: <x-input-label for="email" value="Email Address" />
--}}
@props(['for' => null, 'value' => null, 'required' => false])

<label {{ $for ? "for=\"$for\"" : '' }} {{ $attributes->merge(['class' => 'form-label mb-1 fw-medium']) }}>
    {{ $value ?? $slot }}
    @if($required)<span class="text-danger">*</span>@endif
</label>
