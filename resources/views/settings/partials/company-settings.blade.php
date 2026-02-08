{{-- Company Settings Form Partial --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                <i class="bi bi-building text-primary fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-semibold">Informasi Perusahaan</h5>
                <p class="text-muted small mb-0">Kelola informasi dasar perusahaan Anda</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Success Message --}}
        @if(session('company_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('company_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any() && collect($errors->keys())->contains(fn($k) => str_starts_with($k, 'company_')))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        @if(str_contains(strtolower($error), 'company') || str_contains(strtolower($error), 'nama') || str_contains(strtolower($error), 'alamat') || str_contains(strtolower($error), 'telepon') || str_contains(strtolower($error), 'email'))
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('settings.company.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row g-3">
                {{-- Company Name --}}
                <div class="col-12">
                    <label for="company_name" class="form-label fw-medium">
                        Nama Perusahaan <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-building text-muted"></i>
                        </span>
                        <input type="text" id="company_name" name="company_name"
                               class="form-control border-start-0 @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $company['name'] ?? 'UD. Lestari Batako') }}"
                               placeholder="Masukkan nama perusahaan" required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="col-12">
                    <label for="company_address" class="form-label fw-medium">
                        Alamat <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 align-items-start pt-2">
                            <i class="bi bi-geo-alt text-muted"></i>
                        </span>
                        <textarea id="company_address" name="company_address" rows="3"
                                  class="form-control border-start-0 @error('company_address') is-invalid @enderror"
                                  placeholder="Masukkan alamat lengkap" required>{{ old('company_address', $company['address'] ?? '') }}</textarea>
                        @error('company_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Phone --}}
                <div class="col-md-6">
                    <label for="company_phone" class="form-label fw-medium">
                        Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-telephone text-muted"></i>
                        </span>
                        <input type="tel" id="company_phone" name="company_phone"
                               class="form-control border-start-0 @error('company_phone') is-invalid @enderror"
                               value="{{ old('company_phone', $company['phone'] ?? '') }}"
                               placeholder="Contoh: 0812-3456-7890" required>
                        @error('company_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="company_email" class="form-label fw-medium">
                        Email
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-envelope text-muted"></i>
                        </span>
                        <input type="email" id="company_email" name="company_email"
                               class="form-control border-start-0 @error('company_email') is-invalid @enderror"
                               value="{{ old('company_email', $company['email'] ?? '') }}"
                               placeholder="contoh@email.com">
                        @error('company_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Website --}}
                <div class="col-md-6">
                    <label for="company_website" class="form-label fw-medium">
                        Website
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-globe text-muted"></i>
                        </span>
                        <input type="url" id="company_website" name="company_website"
                               class="form-control border-start-0 @error('company_website') is-invalid @enderror"
                               value="{{ old('company_website', $company['website'] ?? '') }}"
                               placeholder="https://www.contoh.com">
                        @error('company_website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- NPWP --}}
                <div class="col-md-6">
                    <label for="company_npwp" class="form-label fw-medium">
                        NPWP
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-file-earmark-text text-muted"></i>
                        </span>
                        <input type="text" id="company_npwp" name="company_npwp"
                               class="form-control border-start-0 @error('company_npwp') is-invalid @enderror"
                               value="{{ old('company_npwp', $company['npwp'] ?? '') }}"
                               placeholder="XX.XXX.XXX.X-XXX.XXX">
                        @error('company_npwp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="col-12 mt-2">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
