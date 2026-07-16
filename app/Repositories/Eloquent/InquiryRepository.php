<?php

namespace App\Repositories\Eloquent;

use App\Models\Inquiry;
use App\Repositories\Interface\InquiryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InquiryRepository implements InquiryInterface
{
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Inquiry::with('user');
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        return $query->latest()->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Inquiry::findOrFail($id);
    }

    public function create(array $data)
    {
        return Inquiry::create($data);
    }

    public function update(int $id, array $data)
    {
        $inquiry = Inquiry::find($id);
        if (! $inquiry) return null;
        $inquiry->update($data);
        return $inquiry;
    }

    public function delete(int $id)
    {
        $inquiry = Inquiry::find($id);
        if (! $inquiry) return null;
        return $inquiry->delete();
    }
}
