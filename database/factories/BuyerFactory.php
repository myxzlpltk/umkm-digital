<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuyerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Buyer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'bank_id' => Bank::inRandomOrder()->first()->id,
            'account_number' => $this->faker->creditCardNumber,
            'account_name' => $this->faker->name,
        ];
    }
}
