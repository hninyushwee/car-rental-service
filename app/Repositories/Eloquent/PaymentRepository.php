<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\Payment;
use App\Repositories\Interface\PaymentInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentRepository implements PaymentInterface
{
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Payment::with('user')->latest();

        $this->applyDateFilters($query, $filters);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('transaction_ref', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
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
        return Payment::with(['user', 'payable'])->findOrFail($id)
            ->loadMorph('payable', [
                Booking::class => ['items.vehicle.brand', 'payments'],
            ]);
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function update(int $id, array $data)
    {
        $payment = Payment::find($id);
        if (! $payment) return null;
        $payment->update($data);
        return $payment;
    }

    public function delete(int $id)
    {
        $payment = Payment::find($id);
        if (! $payment) return null;
        return $payment->delete();
    }
}
