{{-- Form Group Component
     Consistent form field styling
     Usage:
     @include('components.form-group', [
         'label' => 'Nama Produk',
         'name' => 'nama_produk',
         'type' => 'text',
         'required' => true,
         'placeholder' => 'Masukkan nama produk'
     ])
--}}
@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => null,
    'help' => null,
    'options' => null, // for select
    'textarea' => false,
    'rows' => 4
])

@php
    $errorKey = $name ?? '';
    $hasError = $errors->has($errorKey);
    $oldValue = old($name, $value);
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label fw-medium {{ $required ? 'required' : '' }}">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    @if($textarea)
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder ?? $label }}"
            {{ $required ? 'required' : '' }}
        >{{ $oldValue }}</textarea>
    @elseif($options)
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-select @error($name) is-invalid @enderror"
            {{ $required ? 'required' : '' }}
        >
            <option value="">-- {{ $label ?: 'Pilih' }} --</option>
            @foreach($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" {{ $oldValue == $optValue ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>
    @else
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $oldValue }}"
            class="form-control @error($name) is-invalid @enderror"
            placeholder="{{ $placeholder ?? $label }}"
            {{ $required ? 'required' : '' }}
            @if($type === 'number') step="any" @endif
        >
    @endif

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if($help)
        <div class="form-text text-muted small mt-1">{{ $help }}</div>
    @endif
</div>
