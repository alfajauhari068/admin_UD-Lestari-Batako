{{-- Modal Component
     Consistent modal with Bootstrap and dark mode support
     Usage:
     <x-modal name="editUser" :show="$showModal">
         <x-slot:header>
             <h5 class="modal-title">Edit User</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </x-slot:header>
         <x-slot:body>
             Modal content here
         </x-slot:body>
         <x-slot:footer>
             <x-btn variant="secondary" data-bs-dismiss="modal">Cancel</x-btn>
             <x-btn variant="primary">Save</x-btn>
         </x-slot:footer>
     </x-modal>
--}}
@props([
    'name' => 'modal',
    'show' => false,
    'size' => 'md',
    'centered' => true
])

@php
    $sizeClasses = match($size) {
        'sm' => 'modal-sm',
        'lg' => 'modal-lg',
        'xl' => 'modal-xl',
        default => ''
    };
@endphp

<div
    x-data="{
        show: @js($show),
        init() {
            this.$watch('show', value => {
                if (value) {
                    document.body.classList.add('modal-open');
                } else {
                    document.body.classList.remove('modal-open');
                }
            });
        }
    }"
    x-show="show"
    x-transition.opacity
    class="modal fade"
    id="{{ $name }}"
    tabindex="-1"
    aria-labelledby="{{ $name }}Label"
    aria-hidden="true"
>
    <div class="modal-dialog {{ $sizeClasses }} {{ $centered ? 'modal-dialog-centered' : '' }}">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('{{ $name }}');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
            });
        }
    });
</script>
@endpush
