<?php

namespace App\Repositories\Interface;

use App\Models\Driver;
use Illuminate\Pagination\LengthAwarePaginator;

interface DriverInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): Driver;
    public function create(array $data): Driver;
    public function update(Driver $driver, array $data): Driver;
    public function delete(Driver $driver): bool;
    public function assignPrimaryVehicle(Driver $driver, int $vehicleId): void;
}