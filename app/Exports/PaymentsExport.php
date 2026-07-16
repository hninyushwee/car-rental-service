<?php

namespace App\Exports;

use App\Models\Payment;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;

class PaymentsExport
{
    public function download(array $filters = [])
    {
        $query = Payment::with([
            'user',
            'payable',
        ]);

        $this->applyDateFilters($query, $filters);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('transaction_ref', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $payments = $query->latest()->get();

        $writer = new Writer();
        $writer->openToBrowser('payments.xlsx');

        $headerStyle = (new Style())->setFontBold();
        $writer->addRow(Row::fromValues([
            '#',
            'Payment ID',
            'Transaction Ref',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Amount',
            'Payment Method',
            'Status',
            'Payment Date',
            'Booking Number',
            'Booking Status',
            'Pickup Date',
            'Dropoff Date',
            'Vehicle',
        ], $headerStyle));

        foreach ($payments as $i => $p) {
            $booking = null;
            $vehicle = null;
            $firstItem = null;

            if ($p->payable_type === 'App\Models\Booking' && $p->payable) {
                $booking = $p->payable;
                $booking->loadMissing('items.vehicle.brand', 'items.vehicle.category');
                $firstItem = $booking->items->first();
                $vehicle = $firstItem?->vehicle;
            }

            $writer->addRow(Row::fromValues([
                $i + 1,
                $p->id,
                $p->transaction_ref ?? 'N/A',
                $p->user?->name ?? 'N/A',
                $p->user?->email ?? 'N/A',
                $p->user?->phone ?? 'N/A',
                $p->amount ?? 0,
                $p->payment_method ?? 'N/A',
                $p->status,
                $p->created_at?->format('Y-m-d H:i') ?? 'N/A',
                $booking ? ($booking->booking_number ?? '#' . $booking->id) : 'N/A',
                $booking ? $booking->status : 'N/A',
                $firstItem?->start_date ? \Carbon\Carbon::parse($firstItem->start_date)->format('Y-m-d') : 'N/A',
                $firstItem?->end_date ? \Carbon\Carbon::parse($firstItem->end_date)->format('Y-m-d') : 'N/A',
                $vehicle ? trim(($vehicle->brand?->name ?? '') . ' ' . ($vehicle->model ?? '')) : 'N/A',
            ]));
        }

        $writer->close();
    }

    private function applyDateFilters($query, array $filters): void
    {
        if (! empty($filters['year'])) {
            $query->whereYear('created_at', $filters['year']);
        }

        if (! empty($filters['month'])) {
            $query->whereMonth('created_at', $filters['month']);
        }

        if (! empty($filters['day'])) {
            $query->whereDay('created_at', $filters['day']);
        }
    }
}
