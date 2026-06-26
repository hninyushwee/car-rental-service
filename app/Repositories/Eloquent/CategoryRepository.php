<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interface\CategoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryInterface
{
    public function getAllCategories(int $perPage = 15) : LengthAwarePaginator
    {
        return Category::query()->orderBy('id')->paginate($perPage);
    }

    public function getCategoryById(string $id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(string $id, array $data)
    {
        $category = Category::find($id);

        if (! $category) {
            return null;
        }

        return $category->update($data);
    }

    public function deleteCategory(string $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return null;
        }

        return $category->delete();
    }
}
