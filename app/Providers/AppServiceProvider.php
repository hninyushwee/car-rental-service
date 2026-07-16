<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Payment;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'Booking' => Booking::class,
            'Inquiry' => Inquiry::class,
            'Payment' => Payment::class,
            'Promotion' => Promotion::class,
        ]);
    }
}
