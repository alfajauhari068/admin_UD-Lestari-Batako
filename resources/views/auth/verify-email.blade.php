@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Verifikasi Email</h2>
        
        <div class="mb-4 text-gray-700">
            <p>Terima kasih telah mendaftar! Sebelum melanjutkan, silakan verifikasi email Anda dengan mengklik tautan yang telah kami kirimkan.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                Tautan verifikasi baru telah dikirim ke email Anda.
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 text-gray-600 border border-gray-300 rounded hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
