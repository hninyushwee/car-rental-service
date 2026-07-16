<?php

namespace App\Http\Controllers\View\Admin;

class VehicleController
{
    public function index()
    {
        return view('admin.vehicles.index');
    }

    public function create()
    {
        return view('admin.vehicles.create', [
            'vehicleId' => null,
            'isEdit' => false
        ]);
    }

    public function show(string $id)
    {
        return view('admin.vehicles.show', ['vehicleId' => $id]);
    }

    public function edit(string $id)
    {
        return view('admin.vehicles.create', [
            'vehicleId' => $id,
            'isEdit' => true
        ]);
    }
}
