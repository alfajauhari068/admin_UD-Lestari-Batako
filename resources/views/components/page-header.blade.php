{{-- Page Header Component
     Consistent header for all CRUD pages with dark mode support
     Usage:
     <x-page-header
         title="Daftar Produk"
         subtitle="Manajemen produk UD. Lestari Batako"
         :breadcrumbs="[
             ['name' => 'Produk', 'url' => route('produk.index')]
         ]"
     >
         <x-btn href="{{ route('produk.create') }}" icon="plus-circle">Tambah</x-btn>
     </x-page-header>
--}}
@props([
    'title' => '',
    'subtitle' => null,
    'breadcrumbs' => [],
    'actions' => null
])

<div class="page-header mb-4">
    {{-- Breadcrumb --}}
    @if(!empty($breadcrumbs))
        <div class="mb-3">
            <x-breadcrumb :items="$breadcrumbs" />
        </div>
    @endif

    {{-- Title Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
        <div>
            <h1 class="page-title h3 mb-1">{{ $title }}</h1>
            @if($subtitle)
                <p class="page-subtitle text-muted mb-0">{{ $subtitle }}</p>
            @endif
        </div>
        @if($actions)
            <div class="page-actions d-flex gap-2">
                {!! $actions !!}
            </div>
        @endif
    </div>
</div>
