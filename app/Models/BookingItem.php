<?php

namespace App\Models;

use Carbon\Carbon;
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
