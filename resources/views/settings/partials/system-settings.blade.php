{{-- System Settings Form Partial --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                <i class="bi bi-gear text-warning fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-semibold">Pengaturan Sistem</h5>
                <p class="text-muted small mb-0">Konfigurasi default dan preferensi sistem</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Success Message --}}
        @if(session('system_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('system_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('settings.system.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row g-4">
                {{-- Default Dashboard --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Halaman Dashboard Utama</label>
                    <select class="form-select @error('default_dashboard') is-invalid @enderror" name="default_dashboard">
                        <option value="dashboard" {{ old('default_dashboard', $system['default_dashboard'] ?? 'dashboard') === 'dashboard' ? 'selected' : '' }}>
                            Dashboard Utama
                        </option>
                        <option value="produk" {{ old('default_dashboard', $system['default_dashboard'] ?? '') === 'produk' ? 'selected' : '' }}>
                            Daftar Produk
                        </option>
                        <option value="pesanan" {{ old('default_dashboard', $system['default_dashboard'] ?? '') === 'pesanan' ? 'selected' : '' }}>
                            Daftar Pesanan
                        </option>
                        <option value="produksi" {{ old('default_dashboard', $system['default_dashboard'] ?? '') === 'produksi' ? 'selected' : '' }}>
                            Produksi
                        </option>
                    </select>
                    @error('default_dashboard')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Halaman yang ditampilkan saat pertama kali login</div>
                </div>

                {{-- Items Per Page --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Item per Halaman</label>
                    <select class="form-select @error('items_per_page') is-invalid @enderror" name="items_per_page">
                        <option value="10" {{ old('items_per_page', $system['items_per_page'] ?? 10) == 10 ? 'selected' : '' }}>
                            10 item
                        </option>
                        <option value="25" {{ old('items_per_page', $system['items_per_page'] ?? 25) == 25 ? 'selected' : '' }}>
                            25 item
                        </option>
                        <option value="50" {{ old('items_per_page', $system['items_per_page'] ?? 50) == 50 ? 'selected' : '' }}>
                            50 item
                        </option>
                        <option value="100" {{ old('items_per_page', $system['items_per_page'] ?? 100) == 100 ? 'selected' : '' }}>
                            100 item
                        </option>
                    </select>
                    @error('items_per_page')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Jumlah data yang ditampilkan dalam tabel</div>
                </div>

                {{-- Default Order Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Status Pesanan Default</label>
                    <select class="form-select @error('default_order_status') is-invalid @enderror" name="default_order_status">
                        <option value="pending" {{ old('default_order_status', $system['default_order_status'] ?? 'pending') === 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="confirmed" {{ old('default_order_status', $system['default_order_status'] ?? '') === 'confirmed' ? 'selected' : '' }}>
                            Dikonfirmasi
                        </option>
                        <option value="processing" {{ old('default_order_status', $system['default_order_status'] ?? '') === 'processing' ? 'selected' : '' }}>
                            Diproses
                        </option>
                    </select>
                    @error('default_order_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Status default untuk pesanan baru</div>
                </div>

                {{-- Default Production Status --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Status Produksi Default</label>
                    <select class="form-select @error('default_production_status') is-invalid @enderror" name="default_production_status">
                        <option value="planned" {{ old('default_production_status', $system['default_production_status'] ?? 'planned') === 'planned' ? 'selected' : '' }}>
                            Direncanakan
                        </option>
                        <option value="in_progress" {{ old('default_production_status', $system['default_production_status'] ?? '') === 'in_progress' ? 'selected' : '' }}>
                            Sedang Berjalan
                        </option>
                        <option value="completed" {{ old('default_production_status', $system['default_production_status'] ?? '') === 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                    </select>
                    @error('default_production_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text small">Status default untuk produksi baru</div>
                </div>

                {{-- Notification Settings --}}
                <div class="col-12">
                    <label class="form-label fw-medium mb-3">Notifikasi</label>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notify_order"
                                       name="notify_order" value="1"
                                       {{ old('notify_order', $system['notify_order'] ?? true) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label ms-2" for="notify_order">
                                    <strong>Pesanan Baru</strong>
                                    <p class="text-muted small mb-0">Terima notifikasi saat ada pesanan baru</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notify_production"
                                       name="notify_production" value="1"
                                       {{ old('notify_production', $system['notify_production'] ?? true) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label ms-2" for="notify_production">
                                    <strong>Update Produksi</strong>
                                    <p class="text-muted small mb-0">Terima notifikasi update produksi</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notify_low_stock"
                                       name="notify_low_stock" value="1"
                                       {{ old('notify_low_stock', $system['notify_low_stock'] ?? true) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label ms-2" for="notify_low_stock">
                                    <strong>Stok Menipis</strong>
                                    <p class="text-muted small mb-0">Terima notifikasi saat stok produk menipis</p>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notify_daily_report"
                                       name="notify_daily_report" value="1"
                                       {{ old('notify_daily_report', $system['notify_daily_report'] ?? false) ? 'checked' : '' }}
                                       style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label ms-2" for="notify_daily_report">
                                    <strong>Laporan Harian</strong>
                                    <p class="text-muted small mb-0">Terima ringkasan aktivitas setiap hari</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Auto Refresh Interval --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Interval Refresh Otomatis</label>
                    <select class="form-select @error('auto_refresh_interval') is-invalid @enderror" name="auto_refresh_interval">
                        <option value="0" {{ old('auto_refresh_interval', $system['auto_refresh_interval'] ?? 0) == 0 ? 'selected' : '' }}>
                            Tidak Otomatis
                        </option>
                        <option value="30" {{ old('auto_refresh_interval', $system['auto_refresh_interval'] ?? '') == 30 ? 'selected' : '' }}>
                            Setiap 30 detik
                        </option>
                        <option value="60" {{ old('auto_refresh_interval', $system['auto_refresh_interval'] ?? '') == 60 ? 'selected' : '' }}>
                            Setiap 1 menit
                        </option>
                        <option value="300" {{ old('auto_refresh_interval', $system['auto_refresh_interval'] ?? '') == 300 ? 'selected' : '' }}>
                            Setiap 5 menit
                        </option>
                    </select>
                    @error('auto_refresh_interval')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Language --}}
                <div class="col-md-6">
                    <label class="form-label fw-medium">Bahasa</label>
                    <select class="form-select @error('language') is-invalid @enderror" name="language">
                        <option value="id" {{ old('language', $system['language'] ?? 'id') === 'id' ? 'selected' : '' }}>
                            Indonesia
                        </option>
                        <option value="en" {{ old('language', $system['language'] ?? '') === 'en' ? 'selected' : '' }}>
                            English
                        </option>
                    </select>
                    @error('language')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="col-12 mt-2">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
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
        background-color: #f59e0b;
        border-color: #f59e0b;
    }
</style>
