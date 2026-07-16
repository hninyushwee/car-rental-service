<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Http\Requests\DriverStatusRequest;
use App\Models\Driver;
use App\Repositories\Eloquent\DriverRepository;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ApiResponseTrait;

    protected $driverRepository;

    public function __construct(DriverRepository $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $drivers = $this->driverRepository->all((int)$perPage);

        return $this->successResponse($drivers, 'Drivers list retrieved successfully.');
    }

    public function store(DriverRequest $request)
    {
        $validated = $request->validated();
        $vehicleIds = $request->input('vehicle_ids', []);
        $primaryVehicleId = $request->input('primary_vehicle_id');

        $driver = $this->driverRepository->create($validated);

        if (!empty($vehicleIds)) {
            $this->driverRepository->syncVehicles($driver, $vehicleIds, $primaryVehicleId);
        }

        return $this->successResponse(
            $driver->load('vehicles'),
            'Driver profile added successfully!',
            201
        );
    }

    public function show($id)
    {
        $driver = $this->driverRepository->findById((int)$id);
        return $this->successResponse($driver, 'Driver details profile matched.');
    }

    public function update(DriverRequest $request, Driver $driver)
    {
        $validated = $request->validated();
        $vehicleIds = $request->input('vehicle_ids', []);
        $primaryVehicleId = $request->input('primary_vehicle_id');

        $updatedDriver = $this->driverRepository->update($driver, $validated);

        if ($request->has('vehicle_ids')) {
            $this->driverRepository->syncVehicles($updatedDriver, $vehicleIds, $primaryVehicleId);
        }

        return $this->successResponse($updatedDriver->load('vehicles'), 'Driver details updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $this->driverRepository->delete($driver);
        return $this->successResponse(null, 'Driver record removed successfully from the fleet log.');
    }

    public function assignVehicle(Request $request, Driver $driver)
    {
        $request->validate(['vehicle_id' => 'required|exists:vehicles,id']);

        $this->driverRepository->assignPrimaryVehicle($driver, $request->vehicle_id);

        return $this->successResponse($driver->load('primaryVehicle'), 'Primary vehicle assigned successfully!');
    }

    public function updateStatus(DriverStatusRequest $request, Driver $driver)
    {
        $driver->update($request->validated());
        return $this->successResponse($driver, 'Driver status updated successfully.');
    }
}
