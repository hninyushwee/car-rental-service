<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepositSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('deposit_settings')->insert([

            [
                'service_key'=>'car_rental',
                'deposit_type'=>'percentage',
                'amount'=>20,
                'is_active'=>true,
            ],

            [
                'service_key'=>'driver_service',
                'deposit_type'=>'fixed',
                'amount'=>50000,
                'is_active'=>true,
            ],

        ]);
    }
}