<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_name' => $this->faker->company,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'logo' => 'default.jpg',
            'banner' => 'default.jpg',
            'bank_id' => Bank::inRandomOrder()->first()->id,
            'account_number' => $this->faker->creditCardNumber,
            'account_name' => $this->faker->name,
        ];
    }
}
