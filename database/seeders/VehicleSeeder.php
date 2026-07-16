<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            ['Toyota','Probox','White',5,45000],
            ['Toyota','Vitz','Black',5,50000],
            ['Honda','Fit','Blue',5,55000],
            ['Toyota','Crown','Black',5,120000],
            ['Honda','Civic','White',5,90000],
            ['Nissan','Note','Red',5,60000],
            ['Toyota','Wish','Silver',7,80000],
            ['Toyota','Alphard','Black',7,180000],
            ['Hyundai','Staria','White',9,150000],
            ['Ford','Ranger','Gray',5,130000],
            ['Mitsubishi','Pajero','Black',7,140000],
            ['BMW','320i','Blue',5,250000],
            ['Mercedes','C-Class','Black',5,300000],
            ['Toyota','Hiace','White',12,170000],
            ['Suzuki','Swift','Red',5,50000],
        ];

        foreach ($vehicles as $index => $vehicle) {

            DB::table('vehicles')->insert([
                'category_id' => rand(1,3),
                'brand_id' => rand(1,5),
                'model' => $vehicle[1],
                'year' => rand(2018,2025),
                'color' => $vehicle[2],
                'capacity' => $vehicle[3],
                'price_per_day' => $vehicle[4],
                'location' => 'Yangon',
                'description' => $vehicle[0].' '.$vehicle[1].' rental car',
                'images' => json_encode([
                    'vehicles/'.($index+1).'.jpg'
                ]),
                'total_stock' => 5,
                'available_stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}