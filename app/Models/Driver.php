<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'license_expiry_date',
        'image',
        'address',
        'price_per_day',
        'status',
    ];

    public function vehicles() : BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'driver_vehicle')
                    ->withPivot('is_primary', 'assigned_at');
    }
    public function primaryVehicle() : BelongsToMany
    {
        return $this->vehicles()->wherePivot('is_primary', true);
    }
    // public function bookingItems() : HasMany
    // {
    //     return $this->hasMany(BookingItem::class);
    // }
}
