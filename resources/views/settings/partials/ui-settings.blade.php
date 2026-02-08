{{-- UI Settings Form Partial --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                <i class="bi bi-palette text-info fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-semibold">Pengaturan Tampilan</h5>
                <p class="text-muted small mb-0">Sesuaikan tampilan dan tema aplikasi</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Success Message --}}
        @if(session('ui_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('ui_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('settings.ui.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row g-4">
                {{-- Dark Mode Toggle --}}
                <div class="col-12">
                    <div class="p-3 rounded bg-light border">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-dark bg-opacity-10 rounded p-2 me-3">
                                    <i class="bi bi-moon-stars fs-5 text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Mode Gelap</h6>
                                    <p class="text-muted small mb-0">Aktifkan tema gelap untuk kenyamanan mata</p>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="dark_mode"
                                       name="dark_mode" value="1"
                                       {{ old('dark_mode', $ui['dark_mode'] ?? false) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Compact Mode --}}
                <div class="col-12">
                    <div class="p-3 rounded bg-light border">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary bg-opacity-10 rounded p-2 me-3">
                                    <i class="bi bi-layout-text-sidebar fs-5 text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">Mode Compact</h6>
                                    <p class="text-muted small mb-0">Tampilkan lebih banyak konten dengan spasi yang lebih rapat</p>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="compact_mode"
                                       name="compact_mode" value="1"
                                       {{ old('compact_mode', $ui['compact_mode'] ?? false) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Position --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Posisi Sidebar</label>
                    <div class="btn-group w-100" role="group" aria-label="Sidebar position">
                        <input type="radio" class="btn-check" name="sidebar_position" id="sidebar_left"
                               value="left" {{ old('sidebar_position', $ui['sidebar_position'] ?? 'left') === 'left' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="sidebar_left">
                            <i class="bi bi-arrow-left me-1"></i> Kiri
                        </label>

                        <input type="radio" class="btn-check" name="sidebar_position" id="sidebar_right"
                               value="right" {{ old('sidebar_position', $ui['sidebar_position'] ?? '') === 'right' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="sidebar_right">
                            Kanan <i class="bi bi-arrow-right ms-1"></i>
                        </label>
                    </div>
                </div>

                {{-- Table Density --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Kepadatan Tabel</label>
                    <select class="form-select @error('table_density') is-invalid @enderror" name="table_density">
                        <option value="comfortable" {{ old('table_density', $ui['table_density'] ?? 'comfortable') === 'comfortable' ? 'selected' : '' }}>
                            Nyaman
                        </option>
                        <option value="compact" {{ old('table_density', $ui['table_density'] ?? '') === 'compact' ? 'selected' : '' }}>
                            Compact
                        </option>
                        <option value="spacious" {{ old('table_density', $ui['table_density'] ?? '') === 'spacious' ? 'selected' : '' }}>
                            Luas
                        </option>
                    </select>
                    @error('table_density')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date Format --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Format Tanggal</label>
                    <select class="form-select @error('date_format') is-invalid @enderror" name="date_format">
                        <option value="d/m/Y" {{ old('date_format', $ui['date_format'] ?? 'd/m/Y') === 'd/m/Y' ? 'selected' : '' }}>
                            31/12/2025
                        </option>
                        <option value="Y-m-d" {{ old('date_format', $ui['date_format'] ?? '') === 'Y-m-d' ? 'selected' : '' }}>
                            2025-12-31
                        </option>
                        <option value="d M Y" {{ old('date_format', $ui['date_format'] ?? '') === 'd M Y' ? 'selected' : '' }}>
                            31 Des 2025
                        </option>
                        <option value="M d, Y" {{ old('date_format', $ui['date_format'] ?? '') === 'M d, Y' ? 'selected' : '' }}>
                            Des 31, 2025
                        </option>
                    </select>
                    @error('date_format')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Currency Format --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Format Mata Uang</label>
                    <select class="form-select @error('currency_format') is-invalid @enderror" name="currency_format">
                        <option value="Rp" {{ old('currency_format', $ui['currency_format'] ?? 'Rp') === 'Rp' ? 'selected' : '' }}>
                            Rp 1.000.000
                        </option>
                        <option value="IDR" {{ old('currency_format', $ui['currency_format'] ?? '') === 'IDR' ? 'selected' : '' }}>
                            IDR 1.000.000
                        </option>
                        <option value="Rp " {{ old('currency_format', $ui['currency_format'] ?? '') === 'Rp ' ? 'selected' : '' }}>
                            Rp 1.000.000 (dengan spasi)
                        </option>
                    </select>
                    @error('currency_format')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="col-12 mt-2">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-info text-white">
                            <i class="bi bi-check-lg me-2"></i>
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-check-input:checked {
        background-color: #0ea5a3;
        border-color: #0ea5a3;
    }
</style>
