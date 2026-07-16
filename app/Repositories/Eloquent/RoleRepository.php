<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Interface\RoleInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return Role::with('users')->latest()->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Role::with('users')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update(int $id, array $data)
    {
        $role = Role::find($id);
        if (! $role) return null;
        $role->update($data);
        return $role;
    }

    public function delete(int $id)
    {
        $role = Role::find($id);
        if (! $role) return null;
        return $role->delete();
    }
}
