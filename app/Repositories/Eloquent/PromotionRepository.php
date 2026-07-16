<?php

namespace App\Repositories\Eloquent;

use App\Models\Promotion;
use App\Repositories\Interface\PromotionInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PromotionRepository implements PromotionInterface
{
    public function all(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Promotion::latest();
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        return $query->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Promotion::with('usages')->findOrFail($id);
    }

    public function getActivePromotions()
    {
        return Promotion::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get(['code', 'discount_type', 'discount_value', 'min_spend', 'max_discount']);
    }

    public function create(array $data)
    {
        $mapped = $this->mapFields($data);
        return Promotion::create($mapped);
    }

    public function update(int $id, array $data)
    {
        $promotion = Promotion::find($id);
        if (! $promotion) return null;
        $mapped = $this->mapFields($data);
        $promotion->update($mapped);
        return $promotion;
    }

    private function mapFields(array $data): array
    {
        $map = [
            'type'       => 'discount_type',
            'value'      => 'discount_value',
            'min_amount' => 'min_spend',
            'max_uses'   => 'max_discount',
            'starts_at'  => 'start_date',
            'expires_at' => 'end_date',
            'is_active'  => 'status',
        ];

        $mapped = [];
        foreach ($data as $key => $val) {
            $dbKey = $map[$key] ?? $key;
            $mapped[$dbKey] = $val;
        }

        if (array_key_exists('discount_type', $mapped) && $mapped['discount_type'] === 'fixed') {
            $mapped['discount_type'] = 'fixed_amount';
        }

        if (array_key_exists('status', $mapped) && !in_array($mapped['status'], ['active', 'expired', 'disabled'])) {
            $mapped['status'] = $mapped['status'] ? 'active' : 'disabled';
        }

        return $mapped;
    }

    public function delete(int $id)
    {
        $promotion = Promotion::find($id);
        if (! $promotion) return null;
        return $promotion->delete();
    }
}
