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
            "in_stock" => $this->faker->boolean(2),
            "image" => "shoes.image",
            "title" => $this->faker->sentence(),
            "price" => $this->faker->numberBetween(10,500),
            "description" => $this->faker->paragraph(),
        ];
    }
}
