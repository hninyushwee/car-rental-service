<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use App\Models\Category;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'model',
        'year',
        'license_plate',
        'color',
        'capacity',
        'price_per_day',
        'status',
        'description',
        'image'
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
