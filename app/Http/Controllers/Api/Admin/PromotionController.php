<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Notification;
use App\Models\Promotion;
use App\Models\User;
use App\Repositories\Interface\PromotionInterface;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function __construct(protected PromotionInterface $promotionRepo) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $filters = $request->only(['code', 'status']);

        return $this->successResponse($this->promotionRepo->all($perPage, $filters));
    }

    public function store(PromotionRequest $request)
    {
        $promotion = $this->promotionRepo->create($request->validated());

        $customers = User::whereDoesntHave('roles', fn($q) => $q->whereIn('name', ['super-admin', 'staff']))->get();
        foreach ($customers as $customer) {
            Notification::create([
                'user_id' => $customer->id,
                'type' => 'promotion',
                'title' => 'New Promotion: ' . $promotion->code,
                'message' => "New promotion available: {$promotion->code} - " . ($promotion->description ?? 'Check it out!'),
                'is_read' => false,
                'notifiable_type' => 'App\Models\Promotion',
                'notifiable_id' => $promotion->id,
            ]);
        }

        return $this->successResponse($promotion, 'Promotion created successfully', 201);
    }

    public function show(Promotion $promotion)
    {
        return $this->successResponse($this->promotionRepo->findById($promotion->id));
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $updated = $this->promotionRepo->update($promotion->id, $request->validated());

        if (! $updated) {
            return $this->errorResponse('Promotion not found', 404);
        }

        return $this->successResponse($promotion->fresh(), 'Promotion updated successfully');
    }

    public function destroy(Promotion $promotion)
    {
        $deleted = $this->promotionRepo->delete($promotion->id);

        if (! $deleted) {
            return $this->errorResponse('Promotion not found', 404);
        }

        return $this->successResponse(null, 'Promotion deleted successfully');
    }
}
