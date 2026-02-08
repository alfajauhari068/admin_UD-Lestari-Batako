{{-- Breadcrumb Component
     Flexible breadcrumb navigation with dark mode support
     Usage:
     <x-breadcrumb :items="[
         ['label' => 'Dashboard', 'url' => route('dashboard')],
         ['label' => 'Produk', 'url' => route('produk.index')],
         ['label' => 'Tambah']
     ]" />
--}}
@props([
    'items' => []
])

@php
    // Build items array with Dashboard as first item if not present
    $breadcrumbItems = $items;
    if(empty($breadcrumbItems) || (is_array($breadcrumbItems[0] ?? null) && ($breadcrumbItems[0]['label'] ?? '') !== 'Dashboard')) {
        array_unshift($breadcrumbItems, [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ]);
    }
@endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumbItems as $index => $item)
            @php
                $isLast = $loop->last;
                $hasUrl = isset($item['url']) && !empty($item['url']);
            @endphp
            @if($isLast || !$hasUrl)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}" class="text-decoration-none">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
