<?php

namespace App\Http\Controllers\View\Admin;

class AnalyticsController
{
    public function bookings()
    {
        return view('admin.analytics.bookings');
    }

    public function customers()
    {
        return view('admin.analytics.customers');
    }
}
