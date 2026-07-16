<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inquiries')->insert([

            [
                'user_id' => 3,
                'phone' => '09711111111',
                'email' => 'aung@gmail.com',
                'subject' => 'Car Rental Availability',
                'message' => 'I would like to know the availability of Toyota Alphard for 3 days.',
                'admin_response' => 'Toyota Alphard is available. You can make a booking from our website.',
                'status' => 'resolved',
                'resolved_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 4,
                'phone' => '09722222222',
                'email' => 'ayeaye@gmail.com',
                'subject' => 'Driver Service Inquiry',
                'message' => 'I want to rent a car with a professional driver for a business trip.',
                'admin_response' => null,
                'status' => 'open',
                'resolved_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 5,
                'phone' => '09733333333',
                'email' => 'thiri@gmail.com',
                'subject' => 'Payment Method Question',
                'message' => 'Can I pay using KBZPay or WavePay?',
                'admin_response' => 'Yes, we accept KBZPay and WavePay payment methods.',
                'status' => 'resolved',
                'resolved_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 6,
                'phone' => '09744444444',
                'email' => 'kyawzin@gmail.com',
                'subject' => 'Promotion Information',
                'message' => 'Are there any current discount promotions for rental services?',
                'admin_response' => null,
                'status' => 'open',
                'resolved_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => null,
                'phone' => '09955555555',
                'email' => 'maymyat@gmail.com',
                'subject' => 'General Service Inquiry',
                'message' => 'I would like to know about your car rental service.',
                'admin_response' => 'Thank you for contacting us. Our team will provide more details.',
                'status' => 'resolved',
                'resolved_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}