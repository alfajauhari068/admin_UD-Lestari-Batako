{{-- Input Error Component
     Consistent error message styling with dark mode support
     Usage: @error('email')
           <x-input-error :messages="$message" />
           @enderror
--}}
@props(['messages'])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div {{ $attributes->merge(['class' => 'invalid-feedback d-block']) }}>
            {{ $message }}
        </div>
    @endforeach
@endif
