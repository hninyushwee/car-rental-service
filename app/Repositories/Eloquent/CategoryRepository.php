<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interface\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    public function getAllCategories()
    {
        return Category::query()->orderBy('name')->get();
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
