@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    {{-- Dashboard Header --}}
    @component('components.page-header', [
        'title' => 'Dashboard Admin',
        'subtitle' => date('d M Y') . ' · ' . (Auth::user()->name ?? 'Admin'),
        'breadcrumbs' => [
            ['label' => 'Dashboard']
        ]
    ])
    @endcomponent

    {{-- Statistic Cards --}}
    @include('dashboard.partials.stats')

    {{-- Main Grid --}}
    <div class="row mb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            @component('components.card', ['title' => 'Pesanan Terbaru'])
                @include('dashboard.partials.pesanan-table')
            @endcomponent
        </div>
        <div class="col-lg-6">
            @component('components.card', ['title' => 'Produksi Karyawan'])
                @include('dashboard.partials.produksi-table')
            @endcomponent
        </div>
    </div>

    {{-- History Section --}}
    @component('components.card', ['title' => 'History Produksi'])
        @include('dashboard.partials.history')
    @endcomponent
</div>
@endsection
