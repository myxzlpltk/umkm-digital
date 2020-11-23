<?php

namespace Database\Factories;

use App\Models\Product;
use FakerRestaurant\Provider\id_ID\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Restaurant($this->faker));

        return [
            'name' => $this->faker->foodName(),
            'description' => $this->faker->sentence(4),
            'price' => $this->faker->numberBetween(50, 300)*100,
            'discount' => $this->faker->optional(0.25,0)->randomDigitNotNull,
            'stock' => $this->faker->numberBetween(20, 50),
            'image' => 'default.jpg',
            'rating' => $this->faker->optional(0.5, NULL)->randomFloat(1,0,5),
        ];
    }
}
