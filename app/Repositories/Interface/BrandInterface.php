<?php
namespace App\Repositories\Interface;

interface BrandInterface
{
    public function getAllBrands();
    public function getBrandById(string $id);
    public function createBrand(array $data);
    public function updateBrand(string $id,array $data);
    public function deleteBrand(string $id);
}