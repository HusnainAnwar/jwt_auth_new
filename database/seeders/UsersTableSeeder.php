<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'phone' => '64736746',
            'email' => 'john1@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'phone' => '3874873',
            'email' => 'jane1@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
