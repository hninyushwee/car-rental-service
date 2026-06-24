<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

class VehicleController
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.vehicles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicles.create', [
            'vehicleId' => null,
            'isEdit' => false
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.vehicles.show', ['vehicleId' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.vehicles.create', [
            'vehicleId' => $id,
            'isEdit' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
