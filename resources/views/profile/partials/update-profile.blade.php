{{-- Update Profile Form Partial --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-semibold">Informasi Profil</h5>
        <p class="text-muted small mb-0">Perbarui informasi profil dan alamat email Anda</p>
    </div>
    <div class="card-body">
        {{-- Success Message --}}
        @if(session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                Profil berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Session Success Message --}}
        @if(session('profile_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('profile_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Nama Lengkap',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => old('name', $user->name),
                        'required' => true,
                        'placeholder' => 'Masukkan nama lengkap',
                        'autocomplete' => 'name',
                    ])
                </div>
                <div class="col-md-6">
                    @include('components.form-group', [
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => old('email', $user->email),
                        'required' => true,
                        'placeholder' => 'Masukkan email',
                        'autocomplete' => 'email',
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
