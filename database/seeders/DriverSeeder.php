<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Aung Aung',
            'Ko Min Thu',
            'Kyaw Kyaw',
            'Zaw Lin',
            'Htet Aung',
            'Min Zayar',
            'Nyein Chan',
            'Sai Sai',
            'Thura Win',
            'Ye Yint',
            'Myo Min',
            'Wai Yan',
            'Lin Htet',
            'Tun Tun',
            'Nay Lin'
        ];


        foreach($names as $index=>$name){

            DB::table('drivers')->insert([
                'driving_license_type_id'=>rand(1,4),
                'name'=>$name,
                'email'=>strtolower(str_replace(' ','',$name))
                    .$index.'@gmail.com',
                'phone'=>'09'.rand(700000000,999999999),
                'license_number'=>'YGN-'.$index.'8899',
                'license_expiry_date'=>'2028-12-31',
                'image'=>'drivers/'.($index+1).'.jpg',
                'address'=>'Yangon, Myanmar',
                'status'=>'available',
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);

        }
    }
}