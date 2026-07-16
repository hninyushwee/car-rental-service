Booking Confirmed - Invoice #{{ $booking->booking_number }}

Booking Details:
  Number: #{{ $booking->booking_number }}
  Status: {{ ucfirst($booking->status) }}
  Date: {{ $booking->created_at->format('M d, Y') }}

Customer:
  Name: {{ $booking->user->name }}
  Email: {{ $booking->user->email }}
@if ($booking->user->phone)
  Phone: {{ $booking->user->phone }}
@endif

Booking Items:
@foreach ($booking->items as $item)
@php
$vehicleName = $item->vehicle ? trim(($item->vehicle->brand->name ?? '') . ' ' . $item->vehicle->model) : 'N/A';
$days = $item->start_date && $item->end_date ? max(1, \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1) : 1;
$itemTotal = $days * $item->vehicle_daily_rate * ($item->quantity ?? 1);
if ($item->has_driver && $item->driver_daily_rate) {
$itemTotal += $days * $item->driver_daily_rate * ($item->quantity ?? 1);
}
@endphp
  {{ $vehicleName }} | {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d') : '-' }} - {{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('M d') : '-' }} | Driver: {{ $item->has_driver ? ($item->driver->name ?? 'Auto-assigned') : 'No' }} | Qty: {{ $item->quantity ?? 1 }} | MMK {{ number_format($itemTotal, 2) }}
@endforeach

  Subtotal: MMK {{ number_format($booking->subtotal_price, 2) }}
@if ((float) $booking->discount_amount > 0)
  Discount: -MMK {{ number_format($booking->discount_amount, 2) }}
@endif
  Total: MMK {{ number_format($booking->total_price, 2) }}
@php $totalPaid = $booking->payments->sum('amount'); $remaining = max(0, $booking->total_price - $totalPaid); @endphp
  Total Paid: MMK {{ number_format($totalPaid, 2) }}
  Remaining Balance: MMK {{ number_format($remaining, 2) }}

@if ($booking->car_deposit_snapshot || $booking->driver_deposit_snapshot)
Deposit Info:
@if ($booking->car_deposit_snapshot)
  Car Rental Deposit: MMK {{ number_format($booking->car_deposit_snapshot, 2) }}
@endif
@if ($booking->driver_deposit_snapshot)
  Driver Service Deposit: MMK {{ number_format($booking->driver_deposit_snapshot, 2) }}
@endif
@endif

Thank you for choosing our service. Your booking has been confirmed and is now being processed.

&copy; {{ date('Y') }} SkyLine Car Rental. All rights reserved.
To unsubscribe, visit {{ config('app.url') }}/contact