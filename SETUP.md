Spatie, migrations, and export setup
===================================

Run these commands locally to finish setup after pulling changes from the repository.

1) (Optional) Install Spatie Permission package if not present:

```bash
composer require spatie/laravel-permission
```

2) Publish Spatie resources and run migrations:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate
```

3) Seed permissions created by the project seeder:

```bash
php artisan db:seed --class=\Database\Seeders\PermissionSeeder
```

4) Apply new project migrations (including `dark_mode` migration added by the assistant):

```bash
php artisan migrate
```

5) Cache config & routes for production (optional):

```bash
php artisan config:cache
php artisan route:cache
```

6) Quick export test (CSV + PDF):

- Visit the Produk export URLs in the browser (authenticated as a user with `admin` role):
  - `/produk/export/csv`
  - `/produk/export/pdf`
  - `/produk/export/excel`
- Visit Pesanan CSV export URL:
  - `/pesanan/export/csv`

If exports fail due to Dompdf font issues, ensure the `barryvdh/laravel-dompdf` package is installed and configured.

Notes
-----
- The seeder is idempotent and will not duplicate existing permissions or roles.
- The code uses `class_exists` guards around Spatie calls so the app will not fatal if Spatie is not installed; installing and running the publish/migrate/seed steps enables the full permission checks.
Post-setup: Permissions & PDF export

Jika Anda menambahkan dependensi untuk permission dan PDF exports, jalankan perintah berikut di root proyek:

```bash
# tambahkan paket (jika belum ditambahkan ke composer.json)
composer require spatie/laravel-permission
composer require barryvdh/laravel-dompdf

# publish config dan migration Spatie
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# jalankan migrasi (termasuk migration baru `dark_mode` yang dibuat)
php artisan migrate

# jalankan seeder untuk permission/role
php artisan db:seed --class=PermissionSeeder

# (opsional) clear caches
php artisan config:cache
php artisan route:cache
```

Catatan: `PermissionSeeder` dibuat di `database/seeders/PermissionSeeder.php` dan akan memeriksa apakah paket Spatie terinstal sebelum mencoba membuat permission/role.
