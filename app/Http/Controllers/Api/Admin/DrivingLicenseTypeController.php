<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DrivingLicenseTypeRequest;
use App\Models\DrivingLicenseType;

class DrivingLicenseTypeController extends Controller
{
    public function index()
    {
        $types = DrivingLicenseType::latest()->get();
        return $this->successResponse($types);
    }

    public function store(DrivingLicenseTypeRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'license_types');
        }

        $type = DrivingLicenseType::create($data);

        return $this->successResponse($type, 'License type created successfully', 201);
    }

    public function update(DrivingLicenseTypeRequest $request, DrivingLicenseType $drivingLicenseType)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'license_types', 'public', $drivingLicenseType->image);
        }

        $drivingLicenseType->update($data);

        return $this->successResponse($drivingLicenseType->fresh(), 'License type updated successfully');
    }

    public function destroy(DrivingLicenseType $drivingLicenseType)
    {
        if ($drivingLicenseType->image) {
            $this->deleteFile($drivingLicenseType->image);
        }

        $drivingLicenseType->delete();

        return $this->successResponse(null, 'License type deleted successfully');
    }
}
