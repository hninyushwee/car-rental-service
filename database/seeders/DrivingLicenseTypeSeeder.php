<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DrivingLicenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('driving_license_types')->insert([
            [
                'type' => 'Nga (င)',
                'price' => 15000,
                'image' => 'license_types/pink.png',
            ],
            [
                'type' => 'Ga (ဂ)',
                'price' => 25000,
                'image' => 'license_types/blue.png',
            ],
            [
                'type' => 'Kha (ခ)',
                'price' => 35000,
                'image' => 'license_types/yellow.png',
            ],
            [
                'type' => 'Gha (ဃ)',
                'price' => 50000,
                'image' => 'license_types/orange.png',
            ],
        ]);
    }
}
