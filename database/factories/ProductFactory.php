<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        $name = $this->faker->company();

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'logo_image'  => 'stores/logos/' . $this->faker->image('public/storage/stores/logos', 400, 400, null, false),
            'cover_image' => 'stores/covers/' . $this->faker->image('public/storage/stores/covers', 1200, 400, null, false),
            'status'      => $this->faker->randomElement(['active', 'unactive']),
        ];
    }
}
