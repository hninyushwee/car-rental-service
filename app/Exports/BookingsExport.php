<?php

namespace App\Exports;

use App\Models\Booking;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;

class BookingsExport
{
    public function download(array $filters = [])
    {
        $query = Booking::with(['user', 'items.vehicle', 'items.driver']);

        $this->applyDateFilters($query, $filters);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhere('pickup_location', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->get();

        $writer = new Writer();
        $writer->openToBrowser('bookings.xlsx');

        $headerStyle = (new Style())->setFontBold();
        $writer->addRow(Row::fromValues([
            '#', 'Booking No', 'Customer', 'Pickup Date', 'Return Date',
            'Pickup Location', 'Dropoff Location', 'Status', 'Total Amount'
        ], $headerStyle));

        foreach ($bookings as $i => $b) {
            $writer->addRow(Row::fromValues([
                $i + 1,
                $b->booking_number,
                $b->user?->name ?? 'N/A',
                $b->start_date ?? 'N/A',
                $b->end_date ?? 'N/A',
                $b->pickup_location ?? 'N/A',
                $b->dropoff_location ?? 'N/A',
                $b->status,
                $b->total_price ?? 0,
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
