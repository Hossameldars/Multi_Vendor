<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
    
        $categories = DB::table('categories')->pluck('id')->toArray();
        $stores = DB::table('stores')->pluck('id')->toArray();

        $products = [
            ['name' => 'Wireless Headphones',     'price' => 99.99,  'compare_price' => 129.99, 'featured' => true,  'status' => 'active'],
            ['name' => 'Mechanical Keyboard',      'price' => 149.99, 'compare_price' => null,   'featured' => false, 'status' => 'active'],
            ['name' => 'Gaming Mouse',             'price' => 59.99,  'compare_price' => 79.99,  'featured' => true,  'status' => 'active'],
            ['name' => 'USB-C Hub',                'price' => 39.99,  'compare_price' => null,   'featured' => false, 'status' => 'draft'],
            ['name' => 'Monitor Stand',            'price' => 29.99,  'compare_price' => 49.99,  'featured' => false, 'status' => 'active'],
            ['name' => 'Webcam HD 1080p',          'price' => 79.99,  'compare_price' => 99.99,  'featured' => true,  'status' => 'active'],
            ['name' => 'Desk Lamp LED',            'price' => 24.99,  'compare_price' => null,   'featured' => false, 'status' => 'archived'],
            ['name' => 'Laptop Backpack',          'price' => 49.99,  'compare_price' => 69.99,  'featured' => false, 'status' => 'active'],
            ['name' => 'Phone Stand Adjustable',   'price' => 14.99,  'compare_price' => null,   'featured' => false, 'status' => 'active'],
            ['name' => 'Portable SSD 1TB',         'price' => 109.99, 'compare_price' => 139.99, 'featured' => true,  'status' => 'active'],
        ];

        foreach ($products as $product) {
            $name = $product['name'];
            $slug = Str::slug($name) . '-' . Str::random(5);

            DB::table('products')->insert([
                'name'          => $name,
                'store_id'      => !empty($stores)     ? $stores[array_rand($stores)]         : null,
                'catagory_id'   => !empty($categories) ? $categories[array_rand($categories)] : null,
                'slug'          => $slug,
                'description'   => "This is a detailed description for {$name}. High quality product with excellent features.",
            
                'price'         => $product['price'],
                'compare_price' => $product['compare_price'],
                'options'       => json_encode([
                    'colors' => ['Black', 'White', 'Gray'],
                    'sizes'  => ['S', 'M', 'L'],
                ]),
                'rating'        => round(rand(30, 50) / 10, 1), // 3.0 - 5.0
                'featured'      => $product['featured'],
                'status'        => $product['status'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}