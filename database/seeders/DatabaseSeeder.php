<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            // Roles & Permissions
            RolesAndPermissionsSeeder::class,

            // Users
            UserSeeder::class,

            // Vehicle Master Data
            CategorySeeder::class,
            BrandSeeder::class,
            DrivingLicenseTypeSeeder::class,

            // Vehicles & Drivers
            VehicleSeeder::class,
            DriverSeeder::class,
            DriverVehicleSeeder::class,

            // Rental Data
            DepositSettingSeeder::class,
            PromotionSeeder::class,

            // Communication
            InquirySeeder::class,

        ]);
    }
}