<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Repositories\Interface\BrandInterface;

class BrandController extends Controller
{
    public function __construct(protected BrandInterface $brandRepo)
    {
    }

    public function index()
    {
        return $this->successResponse($this->brandRepo->getAllBrands());
    }

    public function store(BrandRequest $request)
    {
        $brand = $this->brandRepo->createBrand($request->validated());

        return $this->successResponse($brand, 'Brand created successfully', 201);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $updated = $this->brandRepo->updateBrand($brand->id, $request->validated());

        if (! $updated) {
            return $this->errorResponse('Brand not found', 404);
        }

        return $this->successResponse($brand->fresh(), 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        $deleted = $this->brandRepo->deleteBrand($brand->id);

        if (! $deleted) {
            return $this->errorResponse('Brand not found', 404);
        }

        return $this->successResponse(null, 'Brand deleted successfully');
    }
}
