<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'EPC' => fake()->unique()->iban(),
            'title' => fake()->unique()->sentence(2),
            'price' => fake()->randomFloat(2, 0, 1000),
            'stock' => fake()->numberBetween(0, 40),
            "description" => fake()->sentence(15),
        ];
    }
}
