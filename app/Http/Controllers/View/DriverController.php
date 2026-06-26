<?php

namespace App\Http\Controllers\View;

class DriverController
{
    public function index()
    {
        return view('admin.drivers.index');
    }

    public function create()
    {
        return view('admin.drivers.create', [
            'driverId' => null,
            'isEdit' => false,
        ]);
    }

    public function show(string $id)
    {
        return view('admin.drivers.show', ['driverId' => $id]);
    }

    public function edit(string $id)
    {
        return view('admin.drivers.create', [
            'driverId' => $id,
            'isEdit' => true,
        ]);
    }
}
