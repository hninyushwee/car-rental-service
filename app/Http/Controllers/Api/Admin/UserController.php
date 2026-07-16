<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Interface\UserInterface;

class UserController extends Controller
{
    public function __construct(protected UserInterface $userRepo) {}

    public function index()
    {
        return $this->successResponse($this->userRepo->getAllUsers());
    }

    public function show(User $user)
    {
        $user->loadCount(['bookings', 'payments', 'inquiries']);
        $user->load(['bookings' => function ($q) {
            $q->with(['items.vehicle', 'items.vehicle.brand'])->latest()->take(5);
        }]);
        return $this->successResponse($user);
    }

    public function destroy(User $user)
    {
        $deleted = $this->userRepo->deleteUser($user->id);

        if (! $deleted) {
            return $this->errorResponse('User not found', 404);
        }

        return $this->successResponse(null, 'User deleted successfully');
    }
}
