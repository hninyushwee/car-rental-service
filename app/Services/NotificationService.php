<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Notification;

class NotificationService
{
    public function newBooking(Booking $booking): void
    {
        Notification::create([
            'user_id' => null,
            'type' => 'booking',
            'title' => 'New Booking',
            'message' => "{$booking->user->name} has placed a new booking #{$booking->booking_number}.",
            'is_read' => false,
            'notifiable_type' => 'App\Models\Booking',
            'notifiable_id' => $booking->id,
        ]);
    }

    public function newPayment(Booking $booking, float $amount): void
    {
        Notification::create([
            'user_id' => null,
            'type' => 'payment',
            'title' => 'New Payment Received',
            'message' => "{$booking->user->name} has made a payment of MMK " . number_format($amount) . " for booking #{$booking->booking_number}.",
            'is_read' => false,
            'notifiable_type' => 'App\Models\Payment',
            'notifiable_id' => $booking->id,
        ]);
    }
}
