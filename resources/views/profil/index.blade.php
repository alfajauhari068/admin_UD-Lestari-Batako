<!-- filepath: resources/views/profil/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header">
            <h3 class="mb-0">Profil Pengguna</h3>
        </div>
        <div class="card-body">
                <div class="flex-row">
                    <div>
                        <img src="{{ asset('images/user.png') }}" alt="Foto Profil" class="avatar" />
                    </div>
                    <div>
                        <h4>{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                        <p class="text-muted">{{ $user->phone ?? 'Nomor telepon belum diatur' }}</p>
                    </div>
                </div>
                <hr class="hr-rule" />

                <div class="grid-2">
                    <div>
                        <h6>Informasi Pribadi</h6>
                        <p><strong>Nama:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Nomor Telepon:</strong> {{ $user->phone ?? 'Belum diatur' }}</p>
                    </div>
                    <div>
                        <h6>Alamat</h6>
                        <p>{{ $user->address ?? 'Alamat belum diatur' }}</p>
                        <p><strong>Kota:</strong> {{ $user->city ?? 'Belum diatur' }}</p>
                        <p><strong>Negara:</strong> {{ $user->country ?? 'Belum diatur' }}</p>
                    </div>
                </div>
                <hr class="hr-rule" />

                <div style="text-align:right;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">Kembali</a>
                </div>
        </div>
    </div>
</div>
@endsection