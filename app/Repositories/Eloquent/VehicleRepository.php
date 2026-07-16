<?php

namespace App\Repositories\Eloquent;

use App\Models\Vehicle;
use App\Repositories\Interface\VehicleInterface;
use App\Services\VehicleAvailabilityValidator;
use Illuminate\Pagination\LengthAwarePaginator;

class VehicleRepository implements VehicleInterface
{
    public function __construct(
        protected VehicleAvailabilityValidator $availabilityValidator
    ) {}

    public function getAllVehicles(int $perPage = 15) : LengthAwarePaginator
    {
        return Vehicle::query()->with(['category', 'brand'])->latest()->paginate($perPage);
    }

    public function getVehicleById(string $id)
    {
        return Vehicle::with(['category', 'brand'])->findOrFail($id);
    }

    public function getFilteredVehicles(array $filters = [], string $sort = 'popular', int $perPage = 6): LengthAwarePaginator
    {
        $query = Vehicle::with(['category', 'brand'])->where('available_stock', '>', 0);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('model', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query = $this->availabilityValidator->applyToQuery($query, $filters['from_date'], $filters['to_date']);
        }

        match ($sort) {
            'price_asc' => $query->orderBy('price_per_day', 'asc'),
            'price_desc' => $query->orderBy('price_per_day', 'desc'),
            'newest' => $query->latest(),
            default => $query->orderBy('price_per_day', 'asc'),
        };

        return $query->paginate($perPage)->withQueryString();
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

    public function isVehicleAvailableForDates(string $id, string $fromDate, string $toDate): bool
    {
        return $this->availabilityValidator->isAvailable($id, $fromDate, $toDate);
    }
}
