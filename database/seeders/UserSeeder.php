<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Admin User

        $admin = User::create([
            'name' => 'Mg Aung Kyaw',
            'email' => 'admin@skyline.com',
            'phone' => '09123456789',
            'image' => 'users/admin.jpg',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('super-admin');


        // Staff Users

        $staffs = [
            [
                'name' => 'Su Su Mon',
                'email' => 'susu.staff@skyline.com',
                'phone' => '09987654321',
                'image' => 'users/staff1.jpg',
            ],
            [
                'name' => 'Ko Min Thu',
                'email' => 'minthu.staff@skyline.com',
                'phone' => '09777777777',
                'image' => 'users/staff2.jpg',
            ],
        ];


        foreach ($staffs as $staffData) {

            $staff = User::create([
                'name' => $staffData['name'],
                'email' => $staffData['email'],
                'phone' => $staffData['phone'],
                'image' => $staffData['image'],
                'password' => Hash::make('password'),
            ]);

            $staff->assignRole('staff');
        }



        // Customer Users

        $customers = [

            [
                'name' => 'Aung Aung',
                'email' => 'aung@gmail.com',
                'phone' => '09711111111',
                'image' => 'users/customer1.jpg',
            ],

            [
                'name' => 'Aye Aye Win',
                'email' => 'ayeaye@gmail.com',
                'phone' => '09722222222',
                'image' => 'users/customer2.jpg',
            ],

            [
                'name' => 'Thiri Hlaing',
                'email' => 'thiri@gmail.com',
                'phone' => '09733333333',
                'image' => 'users/customer3.jpg',
            ],

            [
                'name' => 'Kyaw Zin',
                'email' => 'kyawzin@gmail.com',
                'phone' => '09744444444',
                'image' => 'users/customer4.jpg',
            ],

            [
                'name' => 'May Myat Noe',
                'email' => 'maymyat@gmail.com',
                'phone' => '09755555555',
                'image' => 'users/customer5.jpg',
            ],

        ];


        foreach ($customers as $customerData) {

            $customer = User::create([

                'name' => $customerData['name'],

                'email' => $customerData['email'],

                'phone' => $customerData['phone'],

                'image' => $customerData['image'],

                'password' => Hash::make('password'),

            ]);

            $customer->assignRole('customer');
        }

    }
}