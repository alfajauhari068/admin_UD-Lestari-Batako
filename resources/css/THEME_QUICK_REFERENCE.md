# Industrial Theme - Quick Reference Guide

## Essential Colors

```
Primary:     #1E293B (Dark Slate)     ← Use for main UI, text, buttons
Secondary:   #334155 (Medium Slate)   ← Use for secondary actions
Accent:      #F59E0B (Amber)          ← Use for highlights, CTAs
Success:     #16A34A (Green)          ← Use for success states
Danger:      #DC2626 (Red)            ← Use for destructive actions
Background:  #F8FAFC (Light Slate)    ← Use for page background
Card:        #FFFFFF (White)          ← Use for cards, modals
```

## Common CSS Classes

### Layout

```html
<div class="main-content">
    <!-- Main area (sidebar + navbar aware) -->
    <div class="d-flex gap-2">
        <!-- Flexbox with 8px gap -->
        <div class="d-flex flex-column gap-3">
            <!-- Vertical flex with 16px gap -->
        </div>
    </div>
</div>
```

### Buttons

```html
<button class="btn btn-primary">Save</button>
<!-- Main action -->
<button class="btn btn-secondary">Back</button>
<!-- Secondary -->
<button class="btn btn-accent">Important</button>
<!-- Highlight -->
<button class="btn btn-danger">Delete</button>
<!-- Destructive -->
<button class="btn btn-outline">Cancel</button>
<!-- Low priority -->
<button class="btn btn-primary btn-sm">Small</button>
<!-- Small button -->
<button class="btn btn-primary btn-lg">Large</button>
<!-- Large button -->
```

### Cards

```html
<div class="card">
    <div class="card-header">Title</div>
    <div class="card-body">Content</div>
    <div class="card-footer">Footer</div>
</div>

<!-- Stat Card -->
<div class="card stat-card success">
    <div class="stat-card-icon"><i class="bi bi-check"></i></div>
    <div class="stat-card-content">
        <h6>Completed</h6>
        <div class="value">42</div>
    </div>
</div>
```

### Forms

```html
<div class="form-group">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" placeholder="Enter email" />
    <div class="form-text">Helper text</div>
</div>

<!-- With validation error -->
<input type="email" class="form-control is-invalid" />
<div class="form-error">Invalid email address</div>
```

### Tables

```html
<table class="table table-striped">
    <thead>
        <tr>
            <th>Column</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data</td>
        </tr>
    </tbody>
</table>
```

### Alerts

```html
<div class="alert alert-success">Success message</div>
<div class="alert alert-danger">Error message</div>
<div class="alert alert-warning">Warning message</div>
<div class="alert alert-info">Info message</div>
```

### Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-danger">Danger</span>
```

## Spacing Utilities

### Margins

```
mt-1, mt-2, mt-3, mt-4, mt-5      <!-- Top margin -->
mb-1, mb-2, mb-3, mb-4, mb-5      <!-- Bottom margin -->
m-0                                 <!-- No margin -->
```

### Padding

```
p-1, p-2, p-3, p-4, p-5           <!-- Padding: 4px, 8px, 16px, 24px, 32px -->
```

## Text Utilities

### Colors

```html
<p class="text-primary">Primary color</p>
<p class="text-secondary">Secondary color</p>
<p class="text-accent">Accent color</p>
<p class="text-success">Success color</p>
<p class="text-danger">Danger color</p>
<p class="text-muted">Muted color</p>
```

### Weight & Style

```html
<p class="fw-bold">Bold text</p>
<p class="fw-semibold">Semibold text</p>
<p class="fw-normal">Normal text</p>
<p class="fst-italic">Italic text</p>
```

### Alignment

```html
<p class="text-center">Centered text</p>
<p class="text-left">Left aligned</p>
<p class="text-right">Right aligned</p>
```

## Display & Flexbox

```html
<div class="d-flex justify-content-between">
    <!-- Space between -->
    <div class="d-flex justify-content-center">
        <!-- Center content -->
        <div class="d-flex align-items-center">
            <!-- Vertical center -->
            <div class="d-flex flex-column">
                <!-- Vertical stack -->
                <div class="d-flex flex-wrap gap-2"><!-- Wrap with gap --></div>
            </div>
        </div>
    </div>
</div>
```

## Borders & Shadows

```html
<div class="border">
    <!-- Light border -->
    <div class="border-top">
        <!-- Top border only -->
        <div class="rounded">
            <!-- Rounded corners (8px) -->
            <div class="rounded-lg">
                <!-- Large rounded (12px) -->
                <div class="shadow-md">
                    <!-- Medium shadow -->
                    <div class="shadow-lg"><!-- Large shadow --></div>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Responsive Design

### Mobile-First Classes (Desktop by default)

```html
<div class="main-content">
    <!-- Full width on mobile, sidebar-aware on desktop -->
    <table class="table">
        <!-- Responsive table, scrollable on mobile -->
    </table>
</div>
```

### Hiding Elements

```html
<!-- Show only on desktop, hide on tablet/mobile -->
<div class="d-none d-md-block">Desktop only</div>

<!-- Show only on mobile, hide on tablet/desktop -->
<div class="d-md-none">Mobile only</div>
```

## Real-World Examples

### Dashboard Header

```html
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold text-primary">Dashboard</h1>
    <a href="#" class="btn btn-primary"> <i class="bi bi-plus"></i> Add New </a>
</div>
```

### Data Card Grid

```html
<div class="row g-4">
    <div class="col-md-4">
        <div class="card stat-card success">
            <div class="stat-card-icon"><i class="bi bi-check"></i></div>
            <div class="stat-card-content">
                <h6>Completed</h6>
                <div class="value">124</div>
            </div>
        </div>
    </div>
</div>
```

### Form with Validation

```html
<div class="form-group">
    <label class="form-label">Product Name</label>
    <input type="text" class="form-control is-invalid" value="" />
    <div class="form-error">Product name is required</div>
</div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-primary">Save</button>
    <button class="btn btn-outline">Cancel</button>
</div>
```

### Data Table with Actions

```html
<div class="card">
    <div class="card-header">Products</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product A</td>
                    <td>$50</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-secondary">Edit</a>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

## CSS Variables (Advanced)

Use in custom CSS:

```css
.custom-element {
    color: var(--color-primary);
    background-color: var(--color-background);
    border: 1px solid var(--color-border);
    box-shadow: var(--shadow-md);
    border-radius: var(--radius-lg);
    padding: 1rem;
    transition: all var(--transition-base);
}
```

Available variables:

-   `--color-*`: All theme colors
-   `--shadow-sm`, `--shadow-md`, `--shadow-lg`, `--shadow-xl`
-   `--transition-fast`, `--transition-base`, `--transition-slow`
-   `--radius-sm`, `--radius-md`, `--radius-lg`, `--radius-xl`
-   `--sidebar-width`, `--navbar-height`

## No More Inline Styles!

❌ **Don't do this:**

```html
<div
    style="background: linear-gradient(135deg, #1e88e5, #42a5f5); padding: 20px;"
></div>
```

✅ **Do this instead:**

```html
<div class="card p-5 bg-primary"></div>
```

## File Location

-   Theme CSS: `resources/css/theme-industrial.css`
-   Documentation: `resources/css/THEME_DOCUMENTATION.md`
-   Quick Reference (this file): `resources/css/THEME_QUICK_REFERENCE.md`

## Need Help?

1. Check this quick reference
2. Review `THEME_DOCUMENTATION.md` for detailed info
3. Look at existing components in blade files
4. Search for usage examples in `dashboard.blade.php`

---

**Last Updated**: January 13, 2026
**Theme Version**: 1.0
