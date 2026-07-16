<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;

class VehicleAvailabilityValidator
{
    const BLOCKING_STATUSES = ['pending', 'confirmed', 'active'];

    const OPEN_STATUSES = ['completed', 'cancelled'];

    public function isAvailable(int|string $vehicleId, string $start, string $end): bool
    {
        $vehicle = Vehicle::find($vehicleId);
        if (!$vehicle) return false;

        $bookedQty = BookingItem::where('vehicle_id', $vehicleId)
            ->whereHas('booking', fn(Builder $q) => $q->whereIn('status', self::BLOCKING_STATUSES))
            ->where('start_date', '<', $end)
            ->where('end_date', '>', $start)
            ->sum('quantity');

        return $vehicle->available_stock > $bookedQty;
    }

    public function applyToQuery(Builder $query, string $start, string $end): Builder
    {
        return $query->where(function (Builder $query) use ($start, $end) {
            $query->whereDoesntHave('bookingItems', function ($q) use ($start, $end) {
                $q->whereHas('booking', fn($b) => $b->whereIn('status', self::BLOCKING_STATUSES))
                  ->where('start_date', '<', $end)
                  ->where('end_date', '>', $start);
            })
            ->orWhereRaw(
                'available_stock > (SELECT COALESCE(SUM(bi.quantity), 0) FROM booking_items bi INNER JOIN bookings b ON b.id = bi.booking_id WHERE bi.vehicle_id = vehicles.id AND b.status IN (?,?,?) AND bi.start_date < ? AND bi.end_date > ?)',
                [self::BLOCKING_STATUSES[0], self::BLOCKING_STATUSES[1], self::BLOCKING_STATUSES[2], $end, $start]
            );
        });
    }

    public function getBlockingBookings(int|string $vehicleId, string $start, string $end): Builder
    {
        return Booking::whereHas('items', fn(Builder $q) => $q
            ->where('vehicle_id', $vehicleId)
            ->where('start_date', '<', $end)
            ->where('end_date', '>', $start)
        )->whereIn('status', self::BLOCKING_STATUSES);
    }
}
