{{-- Empty State Component
     Displays when no data is available with dark mode support
     Usage: <x-empty-state icon="box" title="No products" action-route="route('produk.create')" action-label="Add Product" />
--}}
@props([
    'icon' => 'inbox',
    'title' => 'Tidak ada data',
    'description' => null,
    'actionLabel' => null,
    'actionRoute' => null,
    'actionIcon' => 'plus-circle'
])

<div class="empty-state text-center py-5">
    <div class="empty-state__icon mb-3">
        <i class="bi bi-{{ $icon }} text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
    </div>
    <h5 class="empty-state__title fw-semibold text-muted mb-2">{{ $title }}</h5>
    @if($description)
        <p class="empty-state__description text-muted small mb-3">{{ $description }}</p>
    @endif
    @if($actionLabel && $actionRoute)
        <x-btn variant="primary" size="sm" :href="$actionRoute">
            <i class="bi bi-{{ $actionIcon }} me-1"></i>
            {{ $actionLabel }}
        </x-btn>
    @endif
</div>
