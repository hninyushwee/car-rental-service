<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Sedan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SUV',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Van',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luxury',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}