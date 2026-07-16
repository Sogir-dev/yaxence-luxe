<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        $name = ucwords($this->faker->words(2, true));

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name).'-'.$this->faker->unique()->numberBetween(1, 100000),
            'category' => $this->faker->randomElement(['men', 'women', 'unisex']),
            'description' => $this->faker->paragraph(),
            'concentration' => $this->faker->randomElement(['Eau de Parfum', 'Eau de Toilette', 'Parfum']),
            'size_ml' => $this->faker->randomElement([30, 50, 75, 100]),
            'price_cents' => $this->faker->numberBetween(4000, 30000),
            'image' => null,
            'stock' => $this->faker->numberBetween(0, 50),
        ];
    }
}
