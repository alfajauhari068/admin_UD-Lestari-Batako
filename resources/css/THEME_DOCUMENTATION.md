# Industrial Operations Dashboard Theme

## Overview

Professional, data-focused design system for long daily admin use. Clean, minimal aesthetic with solid colors and optimized contrast for extended viewing.

## Color Palette

### Primary Colors

-   **Primary**: `#1E293B` - Main brand color (Slate 900)
-   **Secondary**: `#334155` - Secondary text/UI (Slate 700)
-   **Accent**: `#F59E0B` - Highlights, CTAs (Amber 500)

### Status Colors

-   **Success**: `#16A34A` - Positive actions (Green 600)
-   **Danger**: `#DC2626` - Destructive actions (Red 600)
-   **Warning**: `#EA580C` - Warning states (Orange 600)
-   **Info**: `#0EA5E9` - Informational content (Cyan 500)

### Neutral Colors

-   **Background**: `#F8FAFC` - Page background (Slate 50)
-   **Card**: `#FFFFFF` - Card/container background
-   **Border**: `#E2E8F0` - Dividers, borders (Slate 200)
-   **Text Primary**: `#1E293B` - Main text (Slate 900)
-   **Text Secondary**: `#64748B` - Secondary text (Slate 500)
-   **Text Muted**: `#94A3B8` - Tertiary text (Slate 400)

## CSS Variables

All colors and values are defined as CSS custom properties for consistency:

```css
--color-primary: #1E293B
--color-secondary: #334155
--color-accent: #F59E0B
--color-success: #16A34A
--color-danger: #DC2626
--color-background: #F8FAFC
--color-card: #FFFFFF
--color-border: #E2E8F0
```

## Component Guidelines

### Buttons

**Primary Button** - Main actions

-   Background: `--color-primary`
-   Hover: Darkened primary
-   Use for: Submit, save, create

**Secondary Button** - Alternative actions

-   Background: `--color-secondary`
-   Use for: Secondary operations

**Accent Button** - Important CTAs

-   Background: `--color-accent`
-   Use for: Highlight important actions

**Outline Button** - Low priority actions

-   Border: `--color-border`
-   Text: `--color-primary`
-   Use for: Cancel, dismiss, low priority

### Cards

Standard card with:

-   White background (`--color-card`)
-   Light border (`--color-border`)
-   Subtle shadow on hover
-   Rounded corners (12px)

### Tables

-   Header background: `#F1F5F9` (light gray)
-   Row hover: Light background
-   Striped rows available for better readability
-   Minimal borders for clean look

### Forms

Input fields:

-   Focused state: Dark border with subtle shadow
-   Invalid state: Red border
-   Placeholder text: Muted color
-   Height: 38px for comfortable interaction

### Alerts

Color-coded with left border:

-   Success: Green border + green background
-   Danger: Red border + red background
-   Warning: Amber border + amber background
-   Info: Blue border + blue background

### Badges

Small labels with light background:

-   Using transparent color variants
-   Uppercase text, bold weight
-   Consistent sizing

## Spacing System

Consistent spacing scale (multiples of 0.25rem):

-   `0.25rem` (4px)
-   `0.5rem` (8px)
-   `1rem` (16px)
-   `1.5rem` (24px)
-   `2rem` (32px)

## Border Radius

-   Small: `6px` (form inputs, small buttons)
-   Medium: `8px` (normal buttons, form elements)
-   Large: `12px` (cards, modals)
-   Extra Large: `16px` (stat cards, hero sections)

## Shadows

-   **Small**: `0 1px 2px rgba(0,0,0,0.05)` - Subtle depth
-   **Medium**: `0 4px 6px rgba(0,0,0,0.1)` - Normal depth
-   **Large**: `0 10px 15px rgba(0,0,0,0.1)` - Prominent
-   **Extra Large**: `0 20px 25px rgba(0,0,0,0.1)` - Maximum

## Typography

### Font Stack

```
-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu',
'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif
```

### Heading Sizes

-   H1: 2rem (32px)
-   H2: 1.5rem (24px)
-   H3: 1.25rem (20px)
-   H4: 1.1rem (17.6px)
-   H5: 1rem (16px)
-   H6: 0.875rem (14px)

### Font Weights

-   Regular: 400
-   Medium: 500
-   Semibold: 600
-   Bold: 700

## Transitions

-   **Fast**: 150ms (interactive elements)
-   **Base**: 300ms (standard transitions)
-   **Slow**: 500ms (entrance animations)

Timing function: `cubic-bezier(0.4, 0, 0.2, 1)`

## Layout Structure

### Navbar

-   Height: `64px`
-   Fixed at top
-   White background with bottom border
-   Z-index: 1020

### Sidebar

-   Width: `250px`
-   Fixed on left
-   Dark background (`--color-primary`)
-   Z-index: 1019

### Main Content

-   Margin-left: `250px` (desktop)
-   Padding: `2rem`
-   Background: `--color-background`

### Responsive Breakpoints

-   Desktop: Full layout with sidebar
-   Tablet (≤768px): Sidebar hidden, togglable
-   Mobile (≤576px): Single column, stack elements

## Dark Mode (Future)

Prepared for dark mode support via `@media (prefers-color-scheme: dark)`

## Accessibility Features

-   WCAG AA compliant contrast ratios
-   Focus states on interactive elements
-   Reduced motion support via `@media (prefers-reduced-motion: reduce)`
-   Semantic HTML usage
-   ARIA labels where needed

## Utility Classes

### Spacing

```
mt-1, mt-2, mt-3, mt-4, mt-5
mb-1, mb-2, mb-3, mb-4, mb-5
p-1, p-2, p-3, p-4, p-5
m-0
```

### Display

```
d-flex, d-inline-flex
flex-column, flex-wrap
justify-content-between, justify-content-center
align-items-center
gap-1, gap-2, gap-3
```

### Text

```
text-primary, text-secondary, text-accent, text-success, text-danger, text-muted
text-center, text-left, text-right
fw-bold, fw-semibold, fw-normal
fst-italic
```

### Borders & Shadows

```
border, border-top, border-bottom, border-left, border-right
rounded, rounded-sm, rounded-lg, rounded-xl
shadow-sm, shadow-md, shadow-lg, shadow-xl
```

### Sizing

```
w-100, h-100
```

## Usage Examples

### Basic Card

```html
<div class="card">
    <div class="card-header">Title</div>
    <div class="card-body">Content</div>
</div>
```

### Stat Card

```html
<div class="card stat-card success">
    <div class="stat-card-icon">
        <i class="bi bi-check-circle"></i>
    </div>
    <div class="stat-card-content">
        <h6>Completed Orders</h6>
        <div class="value">42</div>
    </div>
</div>
```

### Button Group

```html
<div class="d-flex gap-2">
    <button class="btn btn-primary">Save</button>
    <button class="btn btn-outline">Cancel</button>
</div>
```

### Form Group

```html
<div class="form-group">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" placeholder="Enter email" />
    <div class="form-text">Required field</div>
</div>
```

### Table

```html
<table class="table table-striped">
    <thead>
        <tr>
            <th>Header</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data</td>
        </tr>
    </tbody>
</table>
```

## File Locations

-   **Theme CSS**: `resources/css/theme-industrial.css`
-   **Legacy Styles**: `resources/views/include/style.blade.php`
-   **App Layout**: `resources/views/layouts/app.blade.php`

## Migration Notes

The existing app has inline styles and legacy Bootstrap. This theme provides:

1. **CSS Variables** - Consistent color system across all components
2. **Utility Classes** - Common styling needs without inline styles
3. **Component Styles** - Pre-styled elements (buttons, cards, forms)
4. **Responsive Utilities** - Mobile-first design approach

### Next Steps

1. Replace inline styles with utility classes
2. Integrate theme variables into existing components
3. Update color references in legacy styles
4. Test responsive behavior across devices
5. Implement dark mode if needed
