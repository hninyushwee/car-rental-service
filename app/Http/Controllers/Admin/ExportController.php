<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookingsExport;
use App\Exports\PaymentsExport;
use Illuminate\Http\Request;

class ExportController
{
    public function bookings(Request $request)
    {
        $filters = $request->only(['year', 'month', 'day', 'status', 'search']);

        return (new BookingsExport())->download($filters);
    }

    public function payments(Request $request)
    {
        $filters = $request->only(['year', 'month', 'day', 'status', 'search']);

        return (new PaymentsExport())->download($filters);
    }
}
