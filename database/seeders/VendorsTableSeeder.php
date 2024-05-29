<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    public function run()
    {
        Vendor::create([
            'name' => 'Awesome Salon',
            'email' => 'contact@awesomesalon.com',
            'phone' => '1234567890',
            'address' => '123 Main Street',
        ]);

        Vendor::create([
            'name' => 'Beauty Hub',
            'email' => 'info@beautyhub.com',
            'phone' => '0987654321',
            'address' => '456 Market Street',
        ]);
    }
}

