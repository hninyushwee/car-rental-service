<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingItem extends Model
{
    protected $fillable = [
        'booking_id',
        'vehicle_id',
        'driver_id',
        'has_driver',
        'vehicle_daily_rate',
        'driver_daily_rate',
        'start_date',
        'end_date',
        'actual_return_date',
        'pickup_location',
        'dropoff_location',
        'notes',
        'quantity',
    ];

    protected $appends = ['days', 'subtotal'];

    public function getDaysAttribute(): int
    {
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date ?? $this->start_date);
        return max(1, (int) $start->diffInDays($end) + 1);
    }

    public function getSubtotalAttribute(): float
    {
        $rate = (float)($this->vehicle_daily_rate ?? 0) + (float)($this->driver_daily_rate ?? 0);
        return $rate * $this->days * max(1, (int)($this->quantity ?? 1));
    }

    public function scopeWithBookingStatuses(Builder $query, array $statuses): Builder
    {
        return $query->whereHas('booking', fn($q) => $q->whereIn('status', $statuses));
    }

    public function scopeOverlappingDates(Builder $query, string $start, string $end, bool $inclusive = false): Builder
    {
        if ($inclusive) {
            return $query->where('start_date', '<=', $end)
                         ->where('end_date', '>=', $start);
        }

        return $query->where('start_date', '<', $end)
                     ->where('end_date', '>', $start);
    }

    public function scopeForVehicle(Builder $query, int|string $vehicleId): Builder
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    public function scopeForDriver(Builder $query, int|string $driverId): Builder
    {
        return $query->where('driver_id', $driverId);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
