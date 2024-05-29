<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        Appointment::create([
            'user_id' => 1,
            'shop_id' => 1,
            'service_id' => 1,
            'appointment_date' => '2024-06-01 10:00:00',
            'status' => 'confirmed',
        ]);

        Appointment::create([
            'user_id' => 2,
            'shop_id' => 2,
            'service_id' => 3,
            'appointment_date' => '2024-06-01 12:00:00',
            'status' => 'pending',
        ]);
    }
}
