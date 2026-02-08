{{-- Card Component
     Consistent card styling with dark mode support
     Usage:
     <x-card title="Card Title">
         Content here
     </x-card>
--}}
@props([
    'title' => null,
    'class' => ''
])

<div class="card {{ $class }}">
    @if($title)
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="card-title mb-0 fw-semibold">{{ $title }}</h5>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
