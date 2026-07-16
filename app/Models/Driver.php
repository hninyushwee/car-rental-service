<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'license_number',
        'license_expiry_date',
        'driving_license_type_id',
        'image',
        'address',
        'status',
    ];

    public function drivingLicenseType(): BelongsTo
    {
        return $this->belongsTo(DrivingLicenseType::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class, 'driver_vehicle')
                    ->withPivot('is_primary', 'assigned_at');
    }

    public function primaryVehicle(): BelongsToMany
    {
        return $this->vehicles()->wherePivot('is_primary', true);
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function getPrimaryVehicleAttribute()
    {
        return $this->relationLoaded('primaryVehicle')
            ? $this->getRelation('primaryVehicle')->first()
            : null;
    }

    protected $appends = ['primary_vehicle'];
}
