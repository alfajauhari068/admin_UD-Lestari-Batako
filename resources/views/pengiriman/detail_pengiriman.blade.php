@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
    <h2 class="mb-4 pt-5 fw-bold text-primary text-center">Detail Pengiriman</h2>
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px; border-radius: 12px;">
        <div class="card-body p-4">
            <p><strong>ID Pengiriman:</strong> {{ $pengiriman->id_pengiriman }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $pengiriman->pesanan->pelanggan->nama }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $pengiriman->alamat_pengiriman }}</p>
            <p><strong>Tanggal Pengiriman:</strong> {{ $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('d M Y') : '-' }}</p>
            <p><strong>Jasa Kurir:</strong> {{ $pengiriman->jasa_kurir }}</p>
            <p><strong>No Resi:</strong> {{ $pengiriman->no_resi ?? '-' }}</p>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}" class="btn btn-warning rounded-pill shadow-sm px-4">
                    <i class="bi bi-pencil-square"></i> Edit Pengiriman
                </a>
                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary rounded-pill shadow-sm px-4">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection