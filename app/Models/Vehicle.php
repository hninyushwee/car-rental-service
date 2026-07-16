<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'model',
        'year',
        'color',
        'capacity',
        'price_per_day',
        'total_stock',
        'available_stock',
        'description',
        'images',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'driver_vehicle')
                    ->withPivot('is_primary', 'assigned_at');
    }

    public function primaryDriver(): BelongsToMany
    {
        return $this->drivers()->wherePivot('is_primary', true);
    }

    public function bookingItems(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
}
