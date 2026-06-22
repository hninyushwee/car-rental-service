<?php

namespace App\Repositories\Eloquent;

use App\Models\Vehicle;
use App\Repositories\Interface\VehicleInterface;

class VehicleRepository implements VehicleInterface
{
    public function getAllVehicles()
    {
        return Vehicle::query()->with(['category', 'brand'])->latest()->get();
    }

    public function getVehicleById(string $id)
    {
        return Vehicle::with(['category', 'brand'])->findOrFail($id);
    }

    public function createVehicle(array $data)
    {
        return Vehicle::create($data);
    }

    public function updateVehicle(string $id, array $data)
    {
        $vehicle = Vehicle::find($id);

        if (! $vehicle) {
            return null;
        }

        return $vehicle->update($data);
    }

    public function deleteVehicle(string $id)
    {
        $vehicle = Vehicle::find($id);

        if (! $vehicle) {
            return null;
        }

        return $vehicle->delete();
    }
}
