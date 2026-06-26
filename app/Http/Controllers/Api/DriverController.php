<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\DriverRepository;
use App\Traits\ApiResponseTrait;

class DriverController extends Controller
{
    use ApiResponseTrait; // Injecting your response format engines

    protected $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    // 1. GET /drivers
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $drivers = $this->driverRepository->all((int)$perPage);
        
        return $this->successResponse($drivers, 'Drivers list retrieved successfully.');
    }

    // 2. POST /drivers
    public function store(DriverRequest $request)
    {
        $driver = $this->driverRepository->create($request->validated());

        if ($request->filled('vehicle_id')) {
            $this->driverRepository->assignPrimaryVehicle($driver, $request->vehicle_id);
        }

        return $this->successResponse(
            $driver->load('primaryVehicle'), 
            'Driver profile added successfully!', 
            201
        );
    }

    // 3. GET /drivers/{id}
    public function show($id)
    {
        $driver = $this->driverRepository->findById((int)$id);
        return $this->successResponse($driver, 'Driver details profile matched.');
    }

    // 4. PUT/PATCH /drivers/{driver}
    public function update(DriverRequest $request, Driver $driver)
    {
        $updatedDriver = $this->driverRepository->update($driver, $request->validated());
        return $this->successResponse($updatedDriver->load('primaryVehicle'), 'Driver details updated successfully.');
    }

    // 5. DELETE /drivers/{driver}
    public function destroy(Driver $driver)
    {
        $this->driverRepository->delete($driver);
        return $this->successResponse(null, 'Driver record removed successfully from the fleet log.');
    }

    // 6. POST /drivers/{driver}/assign-vehicle
    public function assignVehicle(Request $request, Driver $driver)
    {
        $request->validate(['vehicle_id' => 'required|exists:vehicles,id']);

        $this->driverRepository->assignPrimaryVehicle($driver, $request->vehicle_id);

        return $this->successResponse($driver->load('primaryVehicle'), 'Primary vehicle assigned successfully!');
    }
}
