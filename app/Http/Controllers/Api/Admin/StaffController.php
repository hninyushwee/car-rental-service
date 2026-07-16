<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search');

        $query = User::role('staff')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $this->successResponse($query->paginate($perPage));
    }

    public function store(StaffRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($request->filled('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        $user->load('roles', 'permissions');

        return $this->successResponse($user, 'Staff created successfully', 201);
    }

    public function show(User $user)
    {
        if (!$user->hasRole('staff')) {
            return $this->errorResponse('User is not a staff member', 404);
        }

        $user->load('roles', 'permissions');

        return $this->successResponse($user);
    }

    public function update(StaffRequest $request, User $user)
    {
        if (!$user->hasRole('staff')) {
            return $this->errorResponse('User is not a staff member', 404);
        }

        $data = $request->only(['name', 'email', 'phone']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->syncRoles([$request->role]);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions ?? []);
        }

        $user->load('roles', 'permissions');

        return $this->successResponse($user->fresh()->load('roles', 'permissions'), 'Staff updated successfully');
    }

    public function destroy(User $user)
    {
        if (!$user->hasRole('staff')) {
            return $this->errorResponse('User is not a staff member', 404);
        }

        $user->delete();

        return $this->successResponse(null, 'Staff deleted successfully');
    }
}
