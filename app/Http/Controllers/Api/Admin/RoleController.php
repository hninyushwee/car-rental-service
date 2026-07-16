<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Repositories\Interface\RoleInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(protected RoleInterface $roleRepo) {}

    public function permissions()
    {
        return $this->successResponse(Permission::all(['id', 'name']));
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);

        return $this->successResponse($this->roleRepo->all($perPage));
    }

    public function show(Role $role)
    {
        return $this->successResponse($this->roleRepo->findById($role->id));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);

        $role = $this->roleRepo->create($request->all());

        return $this->successResponse($role, 'Role created successfully', 201);
    }

    public function update(Request $request, Role $role)
    {
        $updated = $this->roleRepo->update($role->id, $request->all());

        if (! $updated) {
            return $this->errorResponse('Role not found', 404);
        }

        return $this->successResponse($role->fresh(), 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $deleted = $this->roleRepo->delete($role->id);

        if (! $deleted) {
            return $this->errorResponse('Role not found', 404);
        }

        return $this->successResponse(null, 'Role deleted successfully');
    }
}
