<?php
namespace App\Repositories\Interface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandInterface
{
    public function getAllBrands(int $perPage = 15): LengthAwarePaginator;
    public function getBrandById(string $id);
    public function createBrand(array $data);
    public function updateBrand(string $id,array $data);
    public function deleteBrand(string $id);
}