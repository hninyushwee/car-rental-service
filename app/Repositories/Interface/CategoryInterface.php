<?php
namespace App\Repositories\Interface;

interface CategoryInterface
{
    public function getAllCategories();
    public function getCategoryById(string $id);
    public function createCategory(array $data);
    public function updateCategory(string $id,array $data);
    public function deleteCategory(string $id);
}