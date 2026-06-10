# Admin Dashboard - Visual Layout Guide

## 📐 Master Layout Structure

```
┌──────────────────────────────────────────────────────────────────┐
│                     NAVBAR (h-70px, sticky, z-40)               │
│  Logo │ Search  │                    │ 🔔 │ 🌙 │ 🌐 │ 👤 │ ☰   │
└──────────────────────────────────────────────────────────────────┘

┌─────────────┬───────────────────────────────────────────────────┐
│             │                                                   │
│  SIDEBAR    │         MAIN CONTENT AREA                        │
│  260px      │                                                   │
│  (w-64)     │         Responsive padding                       │
│             │         p-4 sm:p-6 md:p-8                        │
│ • Dashboard │                                                   │
│ • Vehicles  │     ┌─────────────────────────────────────────┐  │
│ • Drivers   │     │   Page Title                           │  │
│ • Bookings  │     │   Description                          │  │
│ • ...       │     └─────────────────────────────────────────┘  │
│             │                                                   │
│             │     ┌─────────────────────────────────────────┐  │
│             │     │                                         │  │
│ Help &      │     │   Main Content (Cards, Tables, Charts) │  │
│ Support     │     │                                         │  │
│             │     └─────────────────────────────────────────┘  │
└─────────────┴───────────────────────────────────────────────────┘
```

---

## 🏠 Dashboard Home Layout

```
┌─────────────────────────────────────────────────────────────────┐
│                         NAVBAR                                 │
└─────────────────────────────────────────────────────────────────┘

┌──────────┬─────────────────────────────────────────────────────┐
│ SIDEBAR  │ Dashboard Header                                  │
│          │ Title & Description                               │
│          │                                                    │
│          ├─────────────────────────────────────────────────────┤
│          │ QUICK STATS (4 cards in responsive grid)          │
│          │ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌────────┐ │
│          │ │Vehicles  │ │Drivers   │ │Bookings  │ │Revenue │ │
│          │ │142       │ │58        │ │34        │ │$45,250 │ │
│          │ │📈 2.5%   │ │📈 1.2%   │ │📉 0.5%   │ │📈12.8% │ │
│          │ └──────────┘ └──────────┘ └──────────┘ └────────┘ │
│          │                                                    │
│          ├─────────────────────────────────────────────────────┤
│          │ CHARTS (2 row layout)                             │
│          │ ┌─────────────────────────────┐ ┌──────────────┐ │
│          │ │   Revenue Trend (2/3)      │ │ Booking     │ │
│          │ │   Line Chart               │ │ Status      │ │
│          │ │   [━━━━━━━━━━━━━━━━]      │ │ (1/3)       │ │
│          │ └─────────────────────────────┘ └──────────────┘ │
│          │                                                    │
│          │ ┌──────────────────────┐ ┌──────────────────────┐ │
│          │ │Vehicle Utilization   │ │Top Booked Vehicles   │ │
│          │ │Bar Chart             │ │Ranked List           │ │
│          │ │[━━━━━━]              │ │1. BMW 7 Series (85%)│ │
│          │ │[━━━━━]               │ │2. Lexus RX (75%)    │ │
│          │ │[━━━]                 │ │3. Mercedes (68%)    │ │
│          │ └──────────────────────┘ └──────────────────────┘ │
│          │                                                    │
│          ├─────────────────────────────────────────────────────┤
│          │ RECENT BOOKINGS TABLE                             │
│          │ ┌─────────────────────────────────────────────┐   │
│          │ │ ID  │ Customer│ Vehicle│ Pickup  │ Status  │   │
│          │ ├─────────────────────────────────────────────┤   │
│          │ │2048 │ Ava     │ BMW 7  │ Jun 15  │ Active  │   │
│          │ │2047 │ James   │ Lexus  │ Jun 14  │ Confirm │   │
│          │ │2046 │ Maria   │ Merc   │ Jun 13  │ Pending │   │
│          │ └─────────────────────────────────────────────┘   │
│          │                                                    │
└──────────┴─────────────────────────────────────────────────────┘
```

---

## 📊 Quick Stats Card Layout

```
┌────────────────────────────────┐
│                                │
│  [Icon]      Title            │
│  [○○○]     Total Vehicles     │
│              142              │
│                               │
│              📈 2.5%          │
│              from last month  │
└────────────────────────────────┘
```

### Four Cards Grid
```
Mobile (1 col):     Tablet (2 col):      Desktop (4 col):
┌────────┐          ┌────────┬────────┐   ┌───┬───┬───┬───┐
│        │          │        │        │   │   │   │   │   │
├────────┤          ├────────┼────────┤   ├───┼───┼───┼───┤
│        │          │        │        │   │   │   │   │   │
├────────┤          └────────┴────────┘   └───┴───┴───┴───┘
│        │
├────────┤
│        │
└────────┘
```

---

## 📋 Data Table Layout

```
┌────────────────────────────────────────────────────────────────┐
│  Booking ID │ Customer  │ Vehicle     │ Pickup   │ Status     │
├────────────────────────────────────────────────────────────────┤
│  SL-2048    │ Ava       │ BMW 7 Series│ Jun 15   │ ● Active   │
│  SL-2047    │ James     │ Lexus RX    │ Jun 14   │ ● Confirm  │
│  SL-2046    │ Maria     │ Mercedes    │ Jun 13   │ ● Pending  │
│  SL-2045    │ David     │ Audi A8     │ Jun 12   │ ● Complete │
│  SL-2044    │ Emily     │ Porsche 911 │ Jun 11   │ ● Cancelled│
└────────────────────────────────────────────────────────────────┘
```

---

## 🚗 Vehicle Grid Layout

### Desktop (3 columns)
```
┌──────────────────────────────────────────────────────────────┐
│                                                              │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐          │
│  │ ┌─────────┐ │  │ ┌─────────┐ │  │ ┌─────────┐ │          │
│  │ │ [Image] │ │  │ │ [Image] │ │  │ │ [Image] │ │          │
│  │ │ BMW 7   │ │  │ │ Lexus   │ │  │ │ Mercedes│ │          │
│  │ │ Luxury  │ │  │ │ Premium │ │  │ │ Exec    │ │          │
│  │ │ Status: │ │  │ │ Status: │ │  │ │ Status: │ │          │
│  │ │ Active  │ │  │ │ In Use  │ │  │ │ Mainten │ │          │
│  │ │ 2024    │ │  │ │ 2023    │ │  │ │ 2024    │ │          │
│  │ │$150/day │ │  │ │$120/day │ │  │ │$180/day │ │          │
│  │ │Edit Det │ │  │ │Edit Det │ │  │ │Edit Det │ │          │
│  │ └─────────┘ │  │ └─────────┘ │  │ └─────────┘ │          │
│  └─────────────┘  └─────────────┘  └─────────────┘          │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

### Tablet (2 columns)
```
┌──────────────────────────────┐
│ ┌─────────┐  ┌─────────┐    │
│ │ BMW 7   │  │ Lexus   │    │
│ │ Active  │  │ In Use  │    │
│ └─────────┘  └─────────┘    │
│ ┌─────────┐  ┌─────────┐    │
│ │ Mercedes│  │ Audi A8 │    │
│ │ Mainten │  │ Available    │
│ └─────────┘  └─────────┘    │
└──────────────────────────────┘
```

### Mobile (1 column)
```
┌────────────────┐
│ ┌────────────┐ │
│ │ BMW 7      │ │
│ │ Active     │ │
│ └────────────┘ │
│ ┌────────────┐ │
│ │ Lexus RX   │ │
│ │ In Use     │ │
│ └────────────┘ │
│ ┌────────────┐ │
│ │ Mercedes   │ │
│ │ Mainten.   │ │
│ └────────────┘ │
└────────────────┘
```

---

## 📝 Form Layout (Add Vehicle)

```
┌───────────────────────────────────────────────────────────────┐
│                                                               │
│  LEFT SIDE (2/3)          │   RIGHT SIDE (1/3)              │
│                           │                                  │
│  ┌─────────────────────┐  │  ┌──────────────────────┐       │
│  │ BASIC INFO          │  │  │ PREVIEW              │       │
│  │ Brand:   [▼BMW    ] │  │  │ [Image Placeholder]  │       │
│  │ Model:   [________] │  │  │                      │       │
│  │ Year:    [2024    ] │  │  │ BMW 7 Series         │       │
│  │ Plate:   [BM-2048 ] │  │  │ Luxury Sedan         │       │
│  │ Category:[▼Luxury ] │  │  │ $150.00 / day        │       │
│  │ VIN:     [________] │  │  │                      │       │
│  └─────────────────────┘  │  │ ✓ Ready to publish   │       │
│                           │  └──────────────────────┘       │
│  ┌─────────────────────┐  │                                  │
│  │ PRICING             │  │                                  │
│  │ Daily Rate:  [$150 ] │  │                                  │
│  │ Weekly Rate: [$900 ] │  │                                  │
│  │ Monthly Rate:[$3500] │  │                                  │
│  │ Deposit:     [$500 ] │  │                                  │
│  │ ☑ Available         │  │                                  │
│  └─────────────────────┘  │                                  │
│                           │                                  │
│  ┌─────────────────────┐  │                                  │
│  │ FEATURES            │  │                                  │
│  │ Transmission: [Auto] │  │                                  │
│  │ Fuel: [Petrol     ] │  │                                  │
│  │ Seats: [5        ] │  │                                  │
│  │ Amenities:          │  │                                  │
│  │  ☑ AC              │  │                                  │
│  │  ☑ GPS             │  │                                  │
│  │  ☐ Sunroof         │  │                                  │
│  │  ☑ Backup Camera   │  │                                  │
│  │  ☐ WiFi            │  │                                  │
│  │  ☑ Bluetooth       │  │                                  │
│  └─────────────────────┘  │                                  │
│                           │                                  │
│  [Add Vehicle] [Cancel]   │                                  │
│                           │                                  │
└───────────────────────────────────────────────────────────────┘
```

---

## 📱 Responsive Sidebar

### Desktop (Expanded)
```
┌──────────────┐
│ SkyLine Logo │
│ SkyLine Admin│
├──────────────┤
│ 🏠 Dashboard │
├──────────────┤
│ 🚗 Vehicles  │
│  ├─ All     │
│  ├─ Add     │
│  ├─ Cat.    │
│  └─ Brand   │
├──────────────┤
│ 👥 Drivers   │
│  ├─ All     │
│  ├─ Add     │
│  └─ Docs    │
├──────────────┤
│ 📅 Booking   │
│  ├─ All     │
│  ├─ Pending │
│  ├─ Active  │
│  ├─ Done    │
│  └─ Cancelled
├──────────────┤
│ ...          │
├──────────────┤
│ ? Help       │
└──────────────┘
```

### Desktop (Collapsed)
```
┌─────┐
│ [L]│
├─────┤
│ 🏠 │
│ 🚗 │
│ 👥 │
│ 📅 │
│ 💳 │
│ 🏷️  │
│ 📄 │
│ 📊 │
│ ⚙️  │
│ ? │
└─────┘
```

### Mobile (Hidden with Toggle)
- Sidebar hidden by default
- Toggle button in navbar (☰)
- Full-width overlay when visible
- Slides in from left

---

## 🎨 Status Badge Colors

```
Active      Confirmed   Pending     Completed   Cancelled
┌─────┐    ┌─────┐    ┌─────┐    ┌─────┐    ┌─────┐
│ ● ✓ │    │ ● ◆ │    │ ● ! │    │ ● ✓ │    │ ● ✕ │
│ Green    │ Cyan     │ Yellow    │ Gray     │ Red    │
└─────┘    └─────┘    └─────┘    └─────┘    └─────┘
```

---

## 📊 Chart Layouts

### 1. Revenue Trend (2/3 width)
```
┌──────────────────────────────────────┐
│ Revenue Trend                        │
├──────────────────────────────────────┤
│                                      │
│         ↗ Revenue                   │
│        /                             │
│       /                              │
│      /                               │
│     / ↘                              │
│    / ↗ ↘                             │
│   / ↗   ↘ ↗                          │
│  / ↗     ↘ ↗                         │
│ Jan Feb Mar Apr May Jun              │
│                                      │
└──────────────────────────────────────┘
```

### 2. Booking Status (1/3 width)
```
┌──────────────────┐
│ Booking Status   │
├──────────────────┤
│     ◉◉◉◉         │
│    ◉   Active ◉  │
│   ◉  Confirmed ◉ │
│   ◉  Pending ◉   │
│    ◉  Done ◉◉   │
│     ◉◉Cancel◉    │
│                  │
└──────────────────┘
```

### 3. Vehicle Utilization (1/2 width)
```
┌────────────────────────────┐
│ Vehicle Utilization        │
├────────────────────────────┤
│ BMW 7 Series   [████████░ ]│
│ Lexus RX       [███████░░ ]│
│ Mercedes S     [██████░░░ ]│
│ Audi A8        [███████░░ ]│
│ Porsche        [█████░░░░ ]│
└────────────────────────────┘
```

---

## 🔔 Notification Dropdown

```
┌──────────────────────────────┐
│ Notifications                │
│ Latest admin alerts          │
├──────────────────────────────┤
│ ║ New Booking Request        │
│ ║ Lexus RX awaiting approval │
│ ║ 2 minutes ago              │
├──────────────────────────────┤
│ ║ Payment Received           │
│ ║ Invoice #SL-2048 paid      │
│ ║ 15 minutes ago             │
├──────────────────────────────┤
│ ║ Vehicle Maintenance Due    │
│ ║ BMW 7 Series - Service req │
│ ║ 1 hour ago                 │
├──────────────────────────────┤
│ View All Notifications       │
└──────────────────────────────┘
```

---

## 👤 Profile Dropdown

```
┌──────────────────────────────┐
│ [Avatar] Sarah Johnson       │
│         admin@skyline.com    │
├──────────────────────────────┤
│ 👤 My Profile               │
│ ⚙️  Settings                 │
│ 🔒 Change Password          │
├──────────────────────────────┤
│ 🚪 Logout                    │
└──────────────────────────────┘
```

---

## ⚡ Responsive Transitions

### Desktop → Tablet (< 1024px)
- Sidebar stays visible (260px)
- Charts remain in 2-column layout
- Cards in 2-column grid

### Tablet → Mobile (< 768px)
- Sidebar auto-collapses (80px)
- Single column layout everywhere
- Table horizontal scroll
- Cards stack vertically
- Search moved to filters

### Mobile Navigation
- Hamburger menu toggle (☰)
- Overlay navigation drawer
- Full-width when open
- Close on link click

---

## 🎯 Key Layout Values

```
Navbar:
  Height: 70px
  Position: sticky, z-40
  Background: white/dark-slate-800

Sidebar:
  Width: 260px (expanded) / 80px (collapsed)
  Position: fixed
  Height: Full screen
  Transition: 300ms

Main Content:
  Padding: p-4 sm:p-6 md:p-8
  Position: relative
  Width: 100%
  Min-height: calc(100vh - 70px)

Cards:
  Border-radius: 12px (lg) / 16px (xl)
  Border: 1px solid slate-200
  Shadow: sm (default) / md (hover)
  Padding: 24px (p-6)
  Transition: 0.3s smooth
```

---

This visual guide helps developers understand the exact layout structure and responsive behavior of the admin dashboard.
