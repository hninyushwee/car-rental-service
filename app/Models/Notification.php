<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'notifiable_type',
        'notifiable_id',
    ];

    protected $appends = ['from'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifiable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function getFromAttribute(): string
    {
        if (!$this->relationLoaded('notifiable') || !$this->notifiable) {
            return 'System';
        }
        if ($this->notifiable instanceof \App\Models\Booking) {
            return $this->notifiable->user?->name ?? 'System';
        }
        if ($this->notifiable instanceof \App\Models\Inquiry) {
            return $this->notifiable->user?->name ?? 'System';
        }
        if ($this->notifiable instanceof \App\Models\Payment) {
            return $this->notifiable->user?->name ?? 'System';
        }
        return 'System';
    }
}
