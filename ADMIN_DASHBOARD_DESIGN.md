# SkyLine Admin Dashboard - Design System & Documentation

## Overview
A modern, professional, and responsive admin dashboard UI for the SkyLine Car Rental System. The design maintains consistency with the existing SkyLine branding while introducing a premium, modern SaaS aesthetic suitable for enterprise-level car rental management.

---

## 1. Design Principles

### Color Palette
- **Primary Color**: Cyan/Sky Blue (`#06B6D4`, `cyan-500`)
- **Secondary Color**: Blue (`#3B82F6`, `blue-500`)
- **Accent Color**: Amber (`#F59E0B`, `amber-500`)
- **Background**: Light Gray (`#F8FAFC`, `slate-50`)
- **Text**: Dark Slate (`#1E293B`, `slate-900`)
- **Success**: Green (`#22C55E`, `green-600`)
- **Warning**: Amber (`#F59E0B`, `amber-600`)
- **Danger**: Red (`#EF4444`, `red-600`)
- **Neutral**: Slate (`#64748B`, `slate-500`)

### Typography
- **Font Family**: Instrument Sans (custom Bunny font)
- **Headings**: Bold, various sizes (text-lg to text-3xl)
- **Body Text**: Regular/Medium weight, readable on both light and dark backgrounds
- **Small Text**: text-xs for secondary information

### Spacing
- **Base Unit**: 4px (Tailwind's default)
- **Card Padding**: 24px (p-6)
- **Section Gap**: 24px (gap-6)
- **Button Padding**: 12px (py-3)
- **Border Radius**: 12px (rounded-lg), 16px (rounded-xl)

### Shadow & Depth
- **Subtle**: `shadow-sm` - for cards and interactive elements
- **Elevated**: `shadow-md` - on hover or focus
- **Deep**: `shadow-lg` - for modals and important overlays
- **Soft blur**: Consistent 0.4s transitions

---

## 2. Layout Architecture

### Master Layout (`admin/layout.blade.php`)
The main wrapper component that provides:
- Fixed sticky navbar at top
- Collapsible sidebar (260px → 80px)
- Responsive main content area
- JavaScript for state management
- Dark mode support

**Structure**:
```
<body>
  <navbar /> (sticky, z-40)
  <flex>
    <sidebar /> (fixed/collapsible)
    <main /> (responsive padding)
  </flex>
</body>
```

### Key Features
- ✓ Smooth 300ms transitions for sidebar collapse
- ✓ Automatic sidebar collapse on mobile (<768px)
- ✓ Dark mode with localStorage persistence
- ✓ Responsive: Mobile → Tablet → Desktop
- ✓ Icon library: Lucide (2000+ icons)

---

## 3. Component Documentation

### Navbar (`admin/navbar.blade.php`)
**Height**: 70px, sticky top

**Sections**:
1. **Left**: Logo + "SkyLine Admin" text
2. **Center**: Search bar (hidden on mobile)
3. **Right**: Actions
   - Notification bell (with badge indicator)
   - Dark mode toggle
   - Language selector
   - Profile dropdown

**Notification Dropdown**:
- 96 width (w-96)
- Max height 384px (max-h-96) with scroll
- Color-coded by status (cyan, green, amber)
- Timestamp display

**Profile Dropdown**:
- Shows admin name, email
- Links: Profile, Settings, Change Password, Logout
- Red delete button styling

---

### Sidebar (`admin/sidebar.blade.php`)
**Width**: 260px (w-64) / 80px (w-20) when collapsed

**Sections** (Collapsible Submenus):
1. **Dashboard** - Main dashboard link
2. **Vehicle Management** - Cars, categories, brands
3. **Driver Management** - Drivers, documents
4. **Booking Management** - All bookings, by status
5. **Customer Management** - Customers, reviews
6. **Payment Management** - Transactions, invoices, refunds
7. **Promotion Management** - Coupons, promotions
8. **License Services** - Applications, test schedule, packages
9. **Content Management** - Banners, testimonials, FAQ, blog
10. **Reports & Analytics** - Revenue, bookings, customers
11. **System Settings** - General, email, roles
12. **Help & Support** - Support button (footer)

**Submenu Features**:
- Smooth expand/collapse with chevron rotation
- Nested links hidden when collapsed
- Hover states on all items
- Dark mode support

---

## 4. Dashboard Pages

### Dashboard Home (`admin/dashboard.blade.php`)

#### Quick Stats Cards (4-column grid)
Each card includes:
- Icon (colored background)
- Title
- Large metric value
- Growth indicator (green ↑ or yellow ↓)
- Hover elevation effect

**Cards**:
1. **Total Vehicles** - Icon: car, Color: cyan
2. **Total Drivers** - Icon: users, Color: blue
3. **Active Bookings** - Icon: calendar, Color: amber
4. **Monthly Revenue** - Icon: dollar-sign, Color: green

#### Charts Section (Responsive Grid)
1. **Revenue Trend** (2/3 width)
   - Line chart showing monthly revenue
   - X-axis: Months (Jan-Jun)
   - Y-axis: Currency ($)
   - Interactive points with hover

2. **Booking Status** (1/3 width)
   - Doughnut chart
   - Categories: Active, Confirmed, Pending, Completed, Cancelled
   - Color-coded legend at bottom

3. **Vehicle Utilization** (1/2 width)
   - Horizontal bar chart
   - Shows percentage utilization per vehicle
   - Color-gradient bars

4. **Top Booked Vehicles** (1/2 width)
   - Ranked list with progress bars
   - Vehicle name, booking count
   - Visual utilization indicator

#### Recent Bookings Table
- Columns: Booking ID, Customer, Vehicle, Pickup Date, Status, Amount, Actions
- Status badges: Active (green), Confirmed (cyan), Pending (yellow), Completed (gray), Cancelled (red)
- Action buttons: View eye icon, Edit pencil icon
- Hover row highlighting
- Responsive: horizontal scroll on mobile

---

### Vehicles List (`admin/vehicles/index.blade.php`)

#### Page Header
- Title, description
- "Add Vehicle" CTA button

#### Filter Bar
- Search input
- Category dropdown
- Brand dropdown
- Status dropdown

#### Vehicle Cards (3-column responsive grid)
Each card includes:
- Image area (gradient background)
- Vehicle name + category
- Status badge
- Grid of specs: Year, Plate, Rate/Day, Bookings
- Edit & Details buttons

---

### Add Vehicle Form (`admin/vehicles/create.blade.php`)

#### Layout
- **Left** (2/3): Form sections
- **Right** (1/3): Sticky preview panel

#### Form Sections

1. **Basic Information**
   - Brand select
   - Model input
   - Year number
   - License plate input
   - Category select
   - VIN input

2. **Pricing & Availability**
   - Daily rate ($)
   - Weekly rate ($)
   - Monthly rate ($)
   - Security deposit ($)
   - Checkbox: Available for booking

3. **Features & Specifications**
   - Transmission select
   - Fuel type select
   - Number of seats
   - Amenities checklist (6 items)

#### Preview Panel
- Gradient vehicle image
- Live preview of entered data
- Readiness indicator

---

## 5. Responsive Design

### Breakpoints
- **Mobile**: < 640px (sm)
- **Tablet**: 640px - 1024px (md, lg)
- **Desktop**: > 1024px (xl)

### Key Responsive Changes

| Screen | Sidebar | Grid | Navbar |
|--------|---------|------|--------|
| Mobile | Hidden, toggle button | 1 col | Compact, icons only |
| Tablet | Visible, 260px | 2 cols | Normal |
| Desktop | Visible, collapsible | 3-4 cols | Full |

### Mobile-Specific
- Sidebar accessible via toggle button
- Search hidden, use filter buttons instead
- Table horizontal scrollable
- Single-column layouts
- Reduced padding/spacing

---

## 6. Interactive States

### Button States
- **Default**: Slate border, dark text
- **Hover**: Slightly lighter background
- **Focus**: Cyan ring (ring-2, ring-cyan-500/20)
- **Active/Primary**: Cyan gradient background, white text

### Form Input States
- **Default**: Slate border, white background
- **Hover**: Darker border
- **Focus**: Cyan border + ring
- **Error**: Red border
- **Disabled**: Gray background, cursor-not-allowed

### Status Badges
- **Active**: Green circle + text
- **Confirmed**: Cyan circle + text
- **Pending**: Yellow circle + text
- **Completed**: Gray circle + text
- **Cancelled**: Red circle + text

---

## 7. Dark Mode Support

All components include dark mode variants using Tailwind's `dark:` prefix:
- Background colors adjust (white → slate-800)
- Text colors adjust (dark-slate → white)
- Borders adjust (lighter gray → darker slate)
- Hover states maintain contrast

**Activation**: JavaScript reads `localStorage['darkMode']` and applies `dark` class to HTML element.

---

## 8. Accessibility Features

- ✓ Semantic HTML (header, nav, main, aside)
- ✓ ARIA labels on interactive elements
- ✓ Keyboard navigation support
- ✓ Color contrast meets WCAG AA standards
- ✓ Focus rings on all interactive elements
- ✓ Icon + text combinations for better comprehension
- ✓ Proper heading hierarchy (h1-h6)

---

## 9. Performance Optimizations

- CSS-first Tailwind v4 configuration
- No JavaScript for basic styling
- Hardware-accelerated transitions (transform, opacity)
- Lazy-loaded images
- Chart.js for lightweight data visualization
- LocalStorage for state persistence (no server calls)

---

## 10. File Structure

```
resources/views/
├── components/
│   └── admin/
│       ├── layout.blade.php
│       ├── navbar.blade.php
│       └── sidebar.blade.php
└── admin/
    ├── dashboard.blade.php
    └── vehicles/
        ├── index.blade.php
        └── create.blade.php
```

---

## 11. Creating New Admin Pages

### Template

```blade
<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Page Title</h1>
            <p class="mt-1 text-slate-600 dark:text-slate-400">Description</p>
        </div>

        <!-- Main Content -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <!-- Content here -->
        </div>
    </div>
</x-admin.layout>
```

### Key Classes to Use

```tailwind
/* Cards */
rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800

/* Buttons - Primary */
bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg hover:shadow-xl

/* Buttons - Secondary */
border border-slate-300 text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700

/* Badge - Success */
inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300

/* Input Fields */
w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white
```

---

## 12. Usage Examples

### Creating a New Data Table

```blade
<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                    Column Name
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

### Creating a Modal

Use the same card styling but with fixed positioning:
```blade
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 dark:bg-black/70">
    <div class="rounded-xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-800">
        <!-- Modal content -->
    </div>
</div>
```

---

## 13. Chart.js Integration

All charts use Chart.js 3.9.1 with custom styling:
- Responsive containers (height: 300px)
- Cyan primary color scheme
- Smooth animations
- Legend positioning customizable
- Tooltip styling matches brand

---

## 14. Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Android)

---

## 15. Future Enhancements

- [ ] Additional chart types (radar, mixed)
- [ ] Advanced filtering & export
- [ ] Bulk actions for tables
- [ ] Custom date range picker
- [ ] Real-time data updates via WebSocket
- [ ] User role-based permission UI
- [ ] Advanced reporting dashboard
- [ ] Mobile app responsive refinements

---

## 16. Support & Customization

To customize:
1. Modify color variables in `resources/css/app.css` using `@theme`
2. Adjust spacing by modifying Tailwind classes
3. Update chart options in `dashboard.blade.php`
4. Extend components by creating new Blade components

For questions or modifications, refer to:
- Tailwind CSS v4 docs
- Chart.js documentation
- Laravel Blade component docs
