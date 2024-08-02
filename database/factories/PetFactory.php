<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['available', 'pending', 'sold']),
            'category_id' => Category::all()->random()->id,
            'photoUrls' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
        ];
    }


}
