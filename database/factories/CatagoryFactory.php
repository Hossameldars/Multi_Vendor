<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        // أسماء كاتيجوري مناسبة لـ E-commerce
        $categoryNames = [
            'إلكترونيات',
            'ملابس رجالي',
            'ملابس حريمي',
            'أحذية',
            'حقائب',
            'ساعات',
            'عطورات',
            'مستحضرات تجميل',
            'أجهزة منزلية',
            'أثاث',
            'كتب',
            'رياضة',
            'ألعاب أطفال',
            'مجوهرات',
            'كمبيوتر ولابتوب',
            'موبايلات',
            'كاميرات',
            'سماعات',
        ];

        $name = $this->faker->unique()->randomElement($categoryNames);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'parent_id'   => null, // رئيسية افتراضياً
            'description' => $this->faker->realText(150),
            'status'      => $this->faker->randomElement(['active', 'archieved']),
        ];
    }

    // ✅ State — Category رئيسية (مفيش parent)
    public function parent(): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => null,
        ]);
    }

    // ✅ State — Category فرعية (جوا category تانية)
    public function child(): static
    {
        return $this->state(fn(array $attributes) => [
            // بتاخد id من الكاتيجوري الموجودة عشوائياً
            'parent_id' => Category::inRandomOrder()->value('id'),
        ]);
    }

    // ✅ State — active بس
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
        ]);
    }

    // ✅ State — archieved بس
    public function archieved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'archieved',
        ]);
    }
}