<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('promotions')->insert([

            [
                'code' => 'WELCOME10',
                'description' => 'Get 10% discount for first booking.',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'min_spend' => 50000,
                'max_discount' => 50000,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'code' => 'SUMMER50000',
                'description' => 'Get 50,000 MMK discount for first booking.',
                'discount_type' => 'fixed_amount',
                'discount_value' => 50000,
                'min_spend' => 200000,
                'max_discount' => null,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}