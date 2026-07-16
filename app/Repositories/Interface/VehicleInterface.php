<?php
namespace App\Repositories\Interface;
use Illuminate\Pagination\LengthAwarePaginator;

interface VehicleInterface
{
    public function getAllVehicles(int $perPage = 15): LengthAwarePaginator;
    public function getVehicleById(string $id);
    public function getFilteredVehicles(array $filters = [], string $sort = 'popular', int $perPage = 6): LengthAwarePaginator;
    public function createVehicle(array $data);
    public function updateVehicle(string $id, array $data);
    public function deleteVehicle(string $id);
    public function isVehicleAvailableForDates(string $id, string $fromDate, string $toDate): bool;
}