<?php

namespace App\Http\Controllers\View\Admin;

class BookingController
{
    public function index()
    {
        return view('admin.bookings.index');
    }

    public function create()
    {
        return view('admin.bookings.create', [
            'bookingId' => null,
            'isEdit' => false,
        ]);
    }

    public function show(string $id)
    {
        return view('admin.bookings.show', ['bookingId' => $id]);
    }

    public function edit(string $id)
    {
        return view('admin.bookings.create', [
            'bookingId' => $id,
            'isEdit' => true,
        ]);
    }
}
