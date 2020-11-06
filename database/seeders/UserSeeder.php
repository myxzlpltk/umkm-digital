<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Day;
use App\Models\OpenHour;
use App\Models\Product;
use App\Models\Seller;
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

        User::factory(['role' => 'seller'])->count(3)->create()->each(function ($user){
            $user->seller()->save(Seller::factory()->make());

            for($i=0; $i<3; $i++){
                $category = $user->seller->categories()->save(Category::factory()->make());

                $max = mt_rand(1,5);
                for($j=0; $j<$max; $j++){
                    $user->seller->products()->save(
                        Product::factory(['category_id' => $category->id])->make()
                    );
                }
            }

            for($i=1; $i<7; $i++){
                $user->seller->days()->attach($i, [
                    'start' => '08:00',
                    'end' => '20:00',
                ]);
            }
        });
    }
}
