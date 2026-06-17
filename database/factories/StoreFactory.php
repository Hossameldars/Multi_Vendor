<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition(): array
    {
        
        $storeNames = [
            'متجر الإلكترونيات',
            'بيت الأزياء',
            'عالم الرياضة',
            'متجر الجمال',
            'عالم الأطفال',
            'متجر المنزل',
            'عالم الكتب',
            'متجر الساعات',
            'عالم الأحذية',
            'متجر الاكسسوارات',
        ];

        $name = $this->faker->unique()->randomElement($storeNames);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->realText(200),
            'logo_image'  => 'stores/logos/logo_'   . $this->faker->numberBetween(1, 10) . '.png',
            'cover_image' => 'stores/covers/cover_' . $this->faker->numberBetween(1, 10) . '.jpg',
            'status'      => $this->faker->randomElement(['active', 'unactive']),
        ];
    }
}
