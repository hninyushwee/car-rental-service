<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use App\Repositories\Interface\VehicleInterface;

class VehicleController extends Controller
{
    public function __construct(protected VehicleInterface $vehicleRepo)
    {
    }

    public function index()
    {
        return $this->successResponse($this->vehicleRepo->getAllVehicles());
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['category', 'brand', 'drivers']);

        return $this->successResponse($vehicle);
    }

    public function store(VehicleRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $this->uploadFile($image, 'vehicles');
            }
            $validated['images'] = $paths;
        }

        $vehicle = $this->vehicleRepo->createVehicle($validated);

        return $this->successResponse($vehicle->load(['category', 'brand']), 'Vehicle created successfully', 201);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $validated = $request->validated();

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $this->uploadFile($image, 'vehicles', 'public');
            }
            $validated['images'] = $paths;
        }

        $updated = $this->vehicleRepo->updateVehicle($vehicle->id, $validated);

        if (! $updated) {
            return $this->errorResponse('Vehicle not found', 404);
        }

        return $this->successResponse($vehicle->fresh()->load(['category', 'brand']), 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        foreach ((array) ($vehicle->images ?? []) as $image) {
            if ($image) {
                $this->deleteFile($image);
            }
        }

        $deleted = $this->vehicleRepo->deleteVehicle($vehicle->id);

        if (! $deleted) {
            return $this->errorResponse('Vehicle not found', 404);
        }

        return $this->successResponse(null, 'Vehicle deleted successfully');
    }
}
