<?php
namespace App\Repositories\Interface;

interface VehicleInterface
{
    public function getAllVehicles();
    public function getVehicleById(string $id);
    public function createVehicle(array $data);
    public function updateVehicle(string $id,array $data);
    public function deleteVehicle(string $id);
}