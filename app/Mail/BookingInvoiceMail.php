<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class BookingInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->afterCommit();
        $this->booking->load([
            'user',
            'items.vehicle.brand',
            'items.driver',
            'payments',
            'promotionUsage.promotion',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Booking Confirmed - Invoice #{$this->booking->booking_number}",
            replyTo: [config('mail.from.address')],
        );
    }

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'Precedence' => 'bulk',
                'List-Unsubscribe' => '<mailto:' . config('mail.from.address') . '?subject=unsubscribe>',
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-invoice',
            text: 'emails.booking-invoice-plain',
        );
    }
}
