@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-primary text-center">Detail Pengiriman</h2>

    <div class="card shadow border-0 mx-auto" style="max-width: 600px; border-radius: 16px;">
        <div class="card-body p-4">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>ID Pengiriman:</strong> {{ $pengiriman->id_pengiriman }}</li>
                <li class="list-group-item"><strong>Nama Pelanggan:</strong> {{ $pengiriman->pesanan->pelanggan->nama }}</li>
                <li class="list-group-item"><strong>Alamat Pengiriman:</strong> {{ $pengiriman->alamat_pengiriman }}</li>
                <li class="list-group-item"><strong>Tanggal Pengiriman:</strong> 
                    {{ $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('d M Y') : '-' }}
                </li>
                <li class="list-group-item"><strong>Jasa Kurir:</strong> {{ $pengiriman->jasa_kurir ?? '-' }}</li>
                <li class="list-group-item"><strong>No Resi:</strong> {{ $pengiriman->no_resi ?? '-' }}</li>
            </ul>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}" 
                   class="btn btn-warning rounded-pill px-4 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <a href="{{ route('pengiriman.index') }}" 
                   class="btn btn-secondary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </div>
        </div>

@endsection