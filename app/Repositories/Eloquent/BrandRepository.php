<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Interface\BrandInterface;

class BrandRepository implements BrandInterface
{
    public function getAllBrands()
    {
        return Brand::query()->orderBy('name')->get();
    }

    public function getBrandById(string $id)
    {
        return Brand::findOrFail($id);
    }

    public function createBrand(array $data)
    {
        return Brand::create($data);
    }

    public function updateBrand(string $id, array $data)
    {
        $brand = Brand::find($id);

        if (! $brand) {
            return null;
        }

        return $brand->update($data);
    }

    public function deleteBrand(string $id)
    {
        $brand = Brand::find($id);

        if (! $brand) {
            return null;
        }

        return $brand->delete();
    }
}
