<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory([
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ])->create();

        User::factory([
            'role' => 'buyer'
        ])->count(3)->hasBuyer()->create();

        User::factory([
            'role' => 'seller'
        ])->count(3)->hasSeller()->create();
    }
}
