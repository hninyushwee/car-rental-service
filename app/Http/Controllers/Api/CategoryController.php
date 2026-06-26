<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Interface\CategoryInterface;

class CategoryController extends Controller
{
    public function __construct(protected CategoryInterface $categoryRepo)
    {
    }

    public function index()
    {
        return $this->successResponse($this->categoryRepo->getAllCategories());
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryRepo->createCategory($request->validated());

        return $this->successResponse($category, 'Category created successfully', 201);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $updated = $this->categoryRepo->updateCategory($category->id, $request->validated());

        if (! $updated) {
            return $this->errorResponse('Category not found', 404);
        }

        return $this->successResponse($category->fresh(), 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $deleted = $this->categoryRepo->deleteCategory($category->id);

        if (! $deleted) {
            return $this->errorResponse('Category not found', 404);
        }

        return $this->successResponse(null, 'Category deleted successfully');
    }
}
