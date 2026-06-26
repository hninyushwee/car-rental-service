<?php

namespace App\Repositories\Eloquent;

use App\Models\Driver;

use App\Traits\UploadFileTrait; // Import your custom trait
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interface\DriverInterface;

class DriverRepository implements DriverInterface
{
    use UploadFileTrait; // Injecting your custom file handler

    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Driver::with('primaryVehicle')->latest()->paginate($perPage);
    }

    public function findById(int $id): Driver
    {
        return Driver::with('vehicles')->findOrFail($id);
    }

    public function create(array $data): Driver
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Using your trait method signature format
            $data['image'] = $this->uploadFile($data['image'], 'drivers');
        }

        return Driver::create($data);
    }

    public function update(Driver $driver, array $data): Driver
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Your trait automatically deletes $driver->image here if it exists!
            $data['image'] = $this->uploadFile($data['image'], 'drivers', 'public', $driver->image);
        }

        $driver->update($data);
        return $driver;
    }

    public function delete(Driver $driver): bool
    {
        if ($driver->image) {
            $this->deleteFile($driver->image);
        }
        return $driver->delete();
    }

    public function assignPrimaryVehicle(Driver $driver, int $vehicleId): void
    {
        $driver->vehicles()->updateExistingPivot($driver->vehicles->pluck('id'), [
            'is_primary' => false
        ]);

        $driver->vehicles()->syncWithoutDetaching([
            $vehicleId => [
                'is_primary' => true,
                'assigned_at' => now()
            ]
        ]);
    }
}