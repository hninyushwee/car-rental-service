# Admin Dashboard - Quick Reference Guide

## 🚀 Getting Started

### Access the Dashboard
- **URL**: `http://localhost/admin`
- **Dashboard**: `/admin` → Main analytics view
- **Vehicles**: `/admin/vehicles` → Vehicle list
- **Add Vehicle**: `/admin/vehicles/add` → Create vehicle

### Navigation
The sidebar contains all main sections with collapsible submenus. On mobile, use the hamburger toggle button.

---

## 📱 Responsive Breakpoints

```
Mobile    < 640px   → Single column, collapsed sidebar
Tablet    640-1024px → Two columns, visible sidebar
Desktop   > 1024px   → Multi-column grid, collapsible sidebar
```

---

## 🎨 Quick Style Classes

### Colors
```tailwind
text-cyan-600        /* Primary text */
bg-cyan-100          /* Light background */
border-slate-200     /* Subtle border */
text-green-600       /* Success status */
text-red-600         /* Error/danger */
```

### Common Cards
```tailwind
rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800
```

### Gradient Buttons
```tailwind
bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg hover:shadow-xl
```

### Status Badges
```tailwind
/* Green */
inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300

/* Yellow */
bg-yellow-100 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300

/* Red */
bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300
```

---

## 🔧 Common Tasks

### Add a New Admin Page

1. Create Blade file: `resources/views/admin/section/page.blade.php`
2. Wrap with layout: `<x-admin.layout>`
3. Add route in `routes/web.php`:
```php
Route::get('/admin/section/page', function () {
    return view('admin.section.page');
});
```

### Create a Data Table
```blade
<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b bg-slate-50 dark:bg-slate-900">
                <th class="px-6 py-4 text-left text-xs font-bold">Column</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                <td class="px-6 py-4 text-sm">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

### Add a Status Badge
```blade
<span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300">
    <span class="h-2 w-2 rounded-full bg-green-600"></span>
    Active
</span>
```

### Create a Form Group
```blade
<div>
    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
        Label Text
    </label>
    <input type="text" placeholder="Placeholder" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
</div>
```

---

## 🌙 Dark Mode

The dashboard automatically supports dark mode:
- Toggle button in navbar (moon/sun icon)
- Preference saved to localStorage
- Uses Tailwind `dark:` prefix classes
- All components pre-styled for both modes

---

## 📊 Charts

All charts use Chart.js. To add a new chart:

1. Add canvas element:
```blade
<div class="chart-container">
    <canvas id="myChart"></canvas>
</div>
```

2. Initialize in script:
```javascript
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: { /* chart data */ },
    options: { /* options */ }
});
```

---

## 🎯 Key Files

| File | Purpose |
|------|---------|
| `resources/views/components/admin/layout.blade.php` | Main dashboard wrapper |
| `resources/views/components/admin/navbar.blade.php` | Top navigation bar |
| `resources/views/components/admin/sidebar.blade.php` | Left navigation sidebar |
| `resources/views/admin/dashboard.blade.php` | Main dashboard/home |
| `resources/css/app.css` | Tailwind CSS configuration |
| `ADMIN_DASHBOARD_DESIGN.md` | Full design documentation |

---

## 🔗 Routes

```php
GET /admin                    → Main dashboard
GET /admin/vehicles           → Vehicle list
GET /admin/vehicles/add       → Add vehicle form
GET /admin/drivers            → Driver list
GET /admin/bookings           → Booking list
GET /admin/customers          → Customer list
GET /admin/payments/*         → Payment sections
GET /admin/reports/*          → Analytics reports
GET /admin/settings/*         → System settings
```

---

## 💡 Tips

- **Sidebar Collapse**: Automatically collapses on screens < 768px
- **Search**: Center navbar search works for quick filtering
- **Notifications**: Notification bell shows recent activity
- **Icons**: All icons from Lucide (2000+ available)
- **Spacing**: Use gap utilities for consistent spacing
- **Transitions**: 300ms smooth transitions on all interactions
- **Accessibility**: Keyboard navigable, ARIA labels included

---

## 🎨 Color Reference

| Usage | Tailwind Class | Hex |
|-------|---|---|
| Primary | cyan-500 | #06B6D4 |
| Secondary | blue-500 | #3B82F6 |
| Success | green-600 | #16A34A |
| Warning | amber-600 | #D97706 |
| Danger | red-600 | #DC2626 |
| Background | slate-50 | #F8FAFC |
| Text | slate-900 | #0F172A |
| Border | slate-200 | #E2E8F0 |

---

## 📝 Example: Adding a New Section

### 1. Create the route
```php
Route::get('/admin/example', function () {
    return view('admin.example.index');
});
```

### 2. Create the Blade file
```blade
<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                Page Title
            </h1>
            <p class="mt-1 text-slate-600 dark:text-slate-400">
                Description
            </p>
        </div>

        <!-- Your content here -->
    </div>
</x-admin.layout>
```

### 3. Add to sidebar
Edit `resources/views/components/admin/sidebar.blade.php` and add a menu item.

---

## 🐛 Troubleshooting

| Issue | Solution |
|-------|----------|
| Icons not showing | Make sure Lucide script is loaded: `<script src="https://unpkg.com/lucide@latest"></script>` |
| Dark mode not working | Check localStorage and ensure JavaScript is enabled |
| Sidebar not collapsing | Verify viewport width and browser console for errors |
| Chart not rendering | Ensure Chart.js is loaded and canvas ID is correct |
| Styling looks off | Clear browser cache and rebuild Tailwind with `npm run build` |

---

## 📚 Resources

- [Tailwind CSS v4 Documentation](https://tailwindcss.com)
- [Chart.js Documentation](https://www.chartjs.org)
- [Lucide Icons](https://lucide.dev)
- [Laravel Blade Components](https://laravel.com/docs/blade#components)

---

## ✨ Customization

### Change Primary Color

Edit `resources/css/app.css`:
```css
@theme {
    --color-primary: oklch(0.65 0.25 210);
}
```

Then update Tailwind classes from `cyan-*` to your new color.

### Adjust Spacing

Change the base unit or use different padding/margin on components:
```tailwind
p-8 /* Instead of p-6 */
gap-8 /* Instead of gap-6 */
```

### Modify Sidebar Width

In `components/admin/sidebar.blade.php`:
```tailwind
w-64 /* Desktop width */
w-20 /* Collapsed width */
```

---

Happy building! 🎉
