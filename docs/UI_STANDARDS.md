# UI Standards Documentation

## UD. Lestari Batako - Laravel Blade UI Consistency Standards

This document outlines the UI standards applied to ensure consistency across all pages in the application.

---

## 1. Layout Structure

### Main Layout

- **File**: [`resources/views/layouts/app.blade.php`](resources/views/layouts/app.blade.php)
- **Features**:
    - Flexbox-based layout with fixed sidebar
    - Responsive design with mobile sidebar toggle
    - Dark mode support with CSS variables
    - Global tooltip initialization
    - Consistent header and footer

### Sidebar

- **File**: [`resources/views/layouts/sidebar.blade.php`](resources/views/layouts/sidebar.blade.php)
- **Features**:
    - Fixed width (250px)
    - Collapsible on mobile (< 768px)
    - Active route highlighting
    - Dark mode compatible
    - User dropdown with profile and logout

### Navbar

- **File**: [`resources/views/layouts/navbar.blade.php`](resources/views/layouts/navbar.blade.php)
- **Features**:
    - Sticky header
    - Mobile menu toggle
    - Company info (desktop)
    - User dropdown menu

---

## 2. Blade Components

### Page Header

**File**: [`resources/views/components/page-header.blade.php`](resources/views/components/page-header.blade.php)

Usage:

```blade
@component('components.page-header', [
    'title' => 'Daftar Produk',
    'subtitle' => 'Manajemen produk UD. Lestari Batako',
    'breadcrumbs' => [
        ['label' => 'Produk', 'url' => route('produk.index')]
    ],
    'actions' => '
        <a href="'.route('produk.create').'" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah
        </a>
    '
])
@endcomponent
```

### Card

**File**: [`resources/views/components/card.blade.php`](resources/views/components/card.blade.php)

Usage:

```blade
@component('components.card', ['title' => 'Card Title'])
    Content here
@endcomponent
```

### Button

**File**: [`resources/views/components/btn.blade.php`](resources/views/components/btn.blade.php)

Usage:

```blade
@component('components.btn', ['variant' => 'primary', 'size' => 'md', 'icon' => 'plus'])
    Button Text
@endcomponent

{{-- Variants: primary, secondary, success, danger, warning, info, outline-* --}}
{{-- Sizes: sm, md, lg --}}
```

### Table

**File**: [`resources/views/components/table.blade.php`](resources/views/components/table.blade.php)

Usage:

```blade
@component('components.table', ['headers' => ['id' => 'No', 'nama' => 'Nama']])
    @foreach($data as $row)
        <tr>
            <td>{{ $row->id }}</td>
            <td>{{ $row->nama }}</td>
        </tr>
    @endforeach
@endcomponent
```

### Empty State

**File**: [`resources/views/components/empty-state.blade.php`](resources/views/components/empty-state.blade.php)

Usage:

```blade
@component('components.empty-state', [
    'icon' => 'inbox',
    'title' => 'Tidak ada data',
    'actionLabel' => 'Tambah Baru',
    'actionRoute' => route('route.name')
])
@endcomponent
```

---

## 3. Page Structure Pattern

All CRUD pages should follow this structure:

```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<div class="container-fluid py-4">
    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Page Title',
        'subtitle' => 'Page description',
        'breadcrumbs' => [
            ['label' => 'Module', 'url' => route('module.index')],
            ['label' => 'Page']
        ],
        'actions' => '<a href="..." class="btn btn-primary btn-sm">...</a>'
    ])
    @endcomponent

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Content Card --}}
    @component('components.card')
        {{-- Table or form content --}}
    @endcomponent
</div>
@endsection
```

---

## 4. CSS Variables (Dark Mode Ready)

The main layout defines these CSS variables for consistency:

```css
:root {
    --sidebar-width: 250px;
    --header-height: 64px;
    --bg-color: #f8fafc;
    --text-color: #1e293b;
    --card-bg: #ffffff;
    --sidebar-bg: #1e293b;
    --border-color: #e2e8f0;
    --primary-color: #0ea5a3;
    --primary-hover: #0d9488;
}

[data-theme="dark"] {
    --bg-color: #0f172a;
    --text-color: #e2e8f0;
    --card-bg: #1e293b;
    --sidebar-bg: #0f172a;
    --border-color: #334155;
    --primary-color: #06b6d4;
    --primary-hover: #0891b2;
}
```

---

## 5. Responsive Breakpoints

- **Mobile**: < 768px (sidebar collapses, hamburger menu appears)
- **Tablet**: 768px - 991px
- **Desktop**: ≥ 992px

---

## 6. Icon System

Using Bootstrap Icons (`bi-*` classes) and Font Awesome (`fa-*` classes).

Common icons:

- `bi-plus-circle` - Add/Create
- `bi-pencil` - Edit
- `bi-eye` - View/Show
- `bi-trash` - Delete
- `bi-arrow-left` - Back
- `bi-check-circle` - Success/Confirm

---

## 7. Form Standards

### Form Group Component

**File**: [`resources/views/components/form-group.blade.php`](resources/views/components/form-group.blade.php)

Usage:

```blade
@include('components.form-group', [
    'label' => 'Nama Produk',
    'name' => 'nama_produk',
    'type' => 'text',
    'required' => true,
    'placeholder' => 'Masukkan nama produk',
    'value' => old('nama_produk', $produk->nama_produk ?? '')
])
```

---

## 8. Alert Standards

Success alert pattern (used in all pages):

```blade
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
```

---

## 9. Global JavaScript

Tooltip initialization is handled globally in `layouts/app.blade.php`:

```javascript
document.addEventListener("DOMContentLoaded", function () {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]'),
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
```

**Do NOT add inline tooltip scripts in individual pages.**

---

## 10. Files Modified for Consistency

### Removed Duplicates

- `resources/views/partials/navbar.blade.php` (merged into `layouts/navbar.blade.php`)

### Standardized Pages

- `resources/views/welcome.blade.php` - Removed conflicting Tailwind CSS
- `resources/views/dashboard/index.blade.php` - Added consistent structure
- `resources/views/profile/index.blade.php` - Added page header and card components
- `resources/views/settings/index.blade.php` - Added page header component

### Cleaned Pages (Removed Redundant Scripts)

- `resources/views/produksi/index.blade.php`
- `resources/views/produk/index.blade.php`
- `resources/views/pelanggan/index.blade.php`
- `resources/views/pengiriman/index.blade.php`
- `resources/views/pesanan/index.blade.php`
- `resources/views/karyawans/index.blade.php`

---

## 11. Best Practices

1. **Always extend `layouts.app`** - Never create custom layouts
2. **Use Blade components** - Don't use raw HTML for cards, headers, buttons
3. **Use `container-fluid py-4`** - Consistent page padding
4. **No inline scripts** - Use global initialization
5. **Dark mode compatible** - Use CSS variables for colors
6. **Responsive first** - Test on mobile breakpoints
7. **Consistent button styles** - Use Bootstrap variants consistently
8. **Success alerts** - Always show success messages with icons

---

## 12. Color Palette

| Element    | Light Mode | Dark Mode |
| ---------- | ---------- | --------- |
| Primary    | #0ea5a3    | #06b6d4   |
| Secondary  | #6c757d    | #94a3b8   |
| Success    | #22c55e    | #22c55e   |
| Danger     | #ef4444    | #ef4444   |
| Warning    | #f59e0b    | #f59e0b   |
| Background | #f8fafc    | #0f172a   |
| Card       | #ffffff    | #1e293b   |
| Border     | #e2e8f0    | #334155   |

---

_Last Updated: 2026-02-07_
