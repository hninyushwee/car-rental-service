<?php
namespace App\Repositories\Interface;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function getAllUsers(int $perPage = 15): LengthAwarePaginator;
    public function getUserById(string $id);
    public function deleteUser(string $id);
}
