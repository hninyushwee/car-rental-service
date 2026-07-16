<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DrivingLicenseType extends Model
{
    protected $fillable = [
        'type',
        'price',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }
}
