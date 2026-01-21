@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Dashboard Header --}}
    <section class="dashboard-header mb-3">
            <div class="dashboard-header__title">
                <h1>Dashboard Admin</h1>
                <p>
                    {{ date('d M Y') }} ·
                    <span class="text-muted">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                </p>
            </div>
        </section>

        {{-- Statistic Cards --}}
        @include('dashboard.partials.stats')

        {{-- Main Grid --}}
        <section class="dashboard-grid">
            <div class="dashboard-col dashboard-col--left">
                <div class="panel">
                    <div class="panel-header">
                        <h3>Pesanan Terbaru</h3>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.partials.pesanan-table')
                    </div>
                </div>
            </div>

            <div class="dashboard-col dashboard-col--right">
                <div class="panel">
                    <div class="panel-header">
                        <h3>Produksi Karyawan</h3>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.partials.produksi-table')
                    </div>
                </div>
            </div>
        </section>

        {{-- History Section --}}
        <section class="dashboard-history">
            <div class="panel">
                <div class="panel-header">
                    <h3>History Produksi</h3>
                </div>
                <div class="panel-body panel-body--scroll">
                    @include('dashboard.partials.history')
                </div>
            </div>
        </section>

    {{-- Footer --}}
    <footer class="app-footer mt-4">
        <span>&copy; {{ date('Y') }} UD. Lestari Batako</span>
    </footer>

</div>
@endsection
