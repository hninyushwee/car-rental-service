<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'booking_number',
        'status',
        'cancelled_at',
        'cancellation_reason',

        'car_deposit_snapshot',
        'driver_deposit_snapshot',
        
        'subtotal_price',
        'discount_amount',
        'total_price',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public static function blockingStatuses(): array
    {
        return [self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_ACTIVE];
    }

    public static function activeStatuses(): array
    {
        return [self::STATUS_CONFIRMED, self::STATUS_ACTIVE];
    }

    public static function pendingOrConfirmedStatuses(): array
    {
        return [self::STATUS_PENDING, self::STATUS_CONFIRMED];
    }

    public static function closedStatuses(): array
    {
        return [self::STATUS_COMPLETED, self::STATUS_CANCELLED];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function promotionUsage()
    {
        return $this->hasOne(PromotionUsage::class);
    }
}
