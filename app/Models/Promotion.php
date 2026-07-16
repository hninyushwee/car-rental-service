<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_spend',
        'max_discount',
        'start_date',
        'end_date',
        'status',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(PromotionUsage::class);
    }
}
