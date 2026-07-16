<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositSetting extends Model
{
    protected $fillable = [
        'service_key',
        'deposit_type',
        'amount',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];
}
