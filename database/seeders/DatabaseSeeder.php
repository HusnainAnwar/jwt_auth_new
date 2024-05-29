<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(VendorsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
    }
}

