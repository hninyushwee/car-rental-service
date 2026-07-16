<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interface\UserInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserInterface
{
    public function getAllUsers(int $perPage = 15): LengthAwarePaginator
    {
        return User::latest()->paginate($perPage);
    }

    public function getUserById(string $id)
    {
        return User::findOrFail($id);
    }

    public function deleteUser(string $id)
    {
        $user = User::find($id);

        if (! $user) {
            return null;
        }

        return $user->delete();
    }
}
