<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Repositories\Interface\BookingInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingInterface
{
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Booking::with(['user', 'items.vehicle.brand', 'items.driver', 'payments'])->latest();

        $this->applyDateFilters($query, $filters);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('payments', fn($p) => $p->where('transaction_ref', 'like', "%{$search}%"));
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        return $query->paginate($perPage);
    }

    private function applyDateFilters($query, array $filters): void
    {
        if (!empty($filters['year'])) {
            $query->whereYear('created_at', $filters['year']);
        }
        if (!empty($filters['month'])) {
            $query->whereMonth('created_at', $filters['month']);
        }
        if (!empty($filters['day'])) {
            $query->whereDay('created_at', $filters['day']);
        }
    }

    public function findById(int $id)
    {
        return Booking::with(['user', 'items.vehicle.brand', 'items.driver', 'payments', 'promotionUsage.promotion'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function update(int $id, array $data)
    {
        $booking = Booking::find($id);
        if (! $booking) return null;
        $booking->update($data);
        return $booking;
    }

    public function delete(int $id)
    {
        $booking = Booking::find($id);
        if (! $booking) return null;
        return $booking->delete();
    }
}
