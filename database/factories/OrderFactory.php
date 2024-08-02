<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $pet_id = rand(1, 500);
        return [
            'pet_id' => $pet_id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'ship_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['placed', 'approved', 'delivered']),
            'complete' => $this->faker->boolean,
        ];
    }
}
