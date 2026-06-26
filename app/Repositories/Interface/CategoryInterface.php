<?php
namespace App\Repositories\Interface;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryInterface
{
    public function getAllCategories(int $perPage = 15): LengthAwarePaginator;
    public function getCategoryById(string $id);
    public function createCategory(array $data);
    public function updateCategory(string $id,array $data);
    public function deleteCategory(string $id);
}