<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartChange;
use App\Models\CartChangeType;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartChangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartChange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_uuid' => $this->faker->uuid,
            'amount' => $this->faker->randomNumber(),
            'cart_id' => Cart::factory(),
            'cart_change_type_id' => CartChangeType::factory()
        ];
    }
}
