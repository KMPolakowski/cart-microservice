<?php

namespace Database\Factories;

use App\Models\CartChangeType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;

class CartChangeTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartChangeType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => CartChangeType::TYPES[array_rand(CartChangeType::TYPES, 1)],
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime()
        ]; 
    }
}
