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
        return view('admin.vehicles.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
