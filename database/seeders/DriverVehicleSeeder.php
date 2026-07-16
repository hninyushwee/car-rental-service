<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverVehicleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('driver_vehicle')->insert([

            [
                'driver_id' => 1,
                'vehicle_id' => 8,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 2,
                'vehicle_id' => 4,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 3,
                'vehicle_id' => 12,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 4,
                'vehicle_id' => 2,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 5,
                'vehicle_id' => 10,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 6,
                'vehicle_id' => 6,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 7,
                'vehicle_id' => 15,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 8,
                'vehicle_id' => 3,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 9,
                'vehicle_id' => 7,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 10,
                'vehicle_id' => 14,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 11,
                'vehicle_id' => 1,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 12,
                'vehicle_id' => 5,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 13,
                'vehicle_id' => 9,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 14,
                'vehicle_id' => 11,
                'is_primary' => true,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 15,
                'vehicle_id' => 13,
                'is_primary' => true,
                'assigned_at' => now(),
            ],


            // Additional drivers can drive multiple vehicles

            [
                'driver_id' => 1,
                'vehicle_id' => 5,
                'is_primary' => false,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 3,
                'vehicle_id' => 8,
                'is_primary' => false,
                'assigned_at' => now(),
            ],

            [
                'driver_id' => 6,
                'vehicle_id' => 12,
                'is_primary' => false,
                'assigned_at' => now(),
            ],

        ]);
    }
}