<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'shop_id' => 1,
            'name' => 'Hair Cut',
            'description' => 'Professional hair cutting service',
            'price' => 20.00,
        ]);

        Service::create([
            'shop_id' => 1,
            'name' => 'Hair Color',
            'description' => 'Full hair coloring service',
            'price' => 50.00,
        ]);

        Service::create([
            'shop_id' => 2,
            'name' => 'Facial',
            'description' => 'Relaxing facial treatment',
            'price' => 30.00,
        ]);
    }
}
