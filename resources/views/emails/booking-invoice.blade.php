<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->booking_number }}</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #06b6d4, #0891b2); padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; }
        .header p { color: rgba(255,255,255,0.85); margin: 6px 0 0; font-size: 14px; }
        .body { padding: 32px; }
        .section { margin-bottom: 24px; }
        .section-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 8px; }
        .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; color: #334155; border-bottom: 1px solid #f1f5f9; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; }
        .info-value { font-weight: 600; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { background: #f8fafc; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 10px 12px; text-align: left; border-bottom: 2px solid #e2e8f0; }
        td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .total-row td { font-weight: 700; border-bottom: none; padding-top: 12px; }
        .total-row .label { text-align: right; }
        .total-row .value { font-size: 16px; }
        .grand-total td { font-size: 18px; color: #06b6d4; padding-top: 8px; border-top: 2px solid #e2e8f0; }
        .footer { text-align: center; padding: 24px 32px; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .badge-confirmed { background: #cffafe; color: #0891b2; }
        .deposit-note { background: #fefce8; border: 1px solid #fde68a; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #92400e; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Booking Confirmed</h1>
            <p>Invoice #{{ $booking->booking_number }}</p>
        </div>
        <div class="body">
            <div class="section">
                <div class="section-title">Booking Details</div>
                <div class="info-row">
                    <span class="info-label">Booking Number</span>
                    <span class="info-value">#{{ $booking->booking_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value"><span class="badge badge-confirmed">{{ ucfirst($booking->status) }}</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date</span>
                    <span class="info-value">{{ $booking->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Customer</div>
                <div class="info-row">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $booking->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $booking->user->email }}</span>
                </div>
                @if ($booking->user->phone)
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $booking->user->phone }}</span>
                </div>
                @endif
            </div>

            <div class="section">
                <div class="section-title">Booking Items</div>
                <table>
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Dates</th>
                            <th>Driver</th>
                            <th>Qty</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->items as $item)
                        @php
                            $vehicleName = $item->vehicle ? trim(($item->vehicle->brand->name ?? '') . ' ' . $item->vehicle->model) : 'N/A';
                            $days = $item->start_date && $item->end_date ? max(1, \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1) : 1;
                            $itemTotal = $days * $item->vehicle_daily_rate * ($item->quantity ?? 1);
                            if ($item->has_driver && $item->driver_daily_rate) {
                                $itemTotal += $days * $item->driver_daily_rate * ($item->quantity ?? 1);
                            }
                        @endphp
                        <tr>
                            <td>{{ $vehicleName }}</td>
                            <td>{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d') : '-' }} - {{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('M d') : '-' }}</td>
                            <td>{{ $item->has_driver ? ($item->driver->name ?? 'Auto-assigned') : 'No' }}</td>
                            <td>{{ $item->quantity ?? 1 }}</td>
                            <td>MMK {{ number_format($itemTotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="section">
                <table>
                    <tr class="total-row">
                        <td colspan="4" class="label">Subtotal</td>
                        <td class="value">MMK {{ number_format($booking->subtotal_price, 2) }}</td>
                    </tr>
                    @if ((float) $booking->discount_amount > 0)
                    <tr class="total-row">
                        <td colspan="4" class="label">Discount{{ $booking->promotionUsage?->promotion ? ' (' . $booking->promotionUsage->promotion->code . ')' : '' }}</td>
                        <td class="value" style="color:#dc2626;">-MMK {{ number_format($booking->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="total-row grand-total">
                        <td colspan="4" class="label">Total</td>
                        <td class="value">MMK {{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                    @php $totalPaid = $booking->payments->sum('amount'); $remaining = max(0, $booking->total_price - $totalPaid); @endphp
                    <tr class="total-row">
                        <td colspan="4" class="label">Total Paid</td>
                        <td class="value" style="color:#059669;">MMK {{ number_format($totalPaid, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="4" class="label" style="color:#dc2626;">Remaining Balance</td>
                        <td class="value" style="color:#dc2626;">MMK {{ number_format($remaining, 2) }}</td>
                    </tr>
                </table>

                @if ($booking->car_deposit_snapshot || $booking->driver_deposit_snapshot)
                <div class="deposit-note">
                    <strong>Deposit Info:</strong>
                    @if ($booking->car_deposit_snapshot)
                    <br>Car Rental Deposit: MMK {{ number_format($booking->car_deposit_snapshot, 2) }}
                    @endif
                    @if ($booking->driver_deposit_snapshot)
                    <br>Driver Service Deposit: MMK {{ number_format($booking->driver_deposit_snapshot, 2) }}
                    @endif
                </div>
                @endif
            </div>

            <p style="font-size:14px;color:#475569;margin-top:24px;">
                Thank you for choosing our service. Your booking has been confirmed and is now being processed.
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} SkyLine Car Rental. All rights reserved.<br>
            <a href="{{ config('app.url') }}/contact" style="color:#94a3b8;text-decoration:underline;">Unsubscribe</a>
        </div>
    </div>
</body>
</html>
