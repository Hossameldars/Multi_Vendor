<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
      DB::table('categories')->delete();
        $categories = [
            [
                'name'        => 'إلكترونيات',
                'description' => 'أحدث الأجهزة والمنتجات الإلكترونية',
                'status'      => 'active',
                'children'    => [
                    ['name' => 'موبايلات',         'status' => 'active'],
                    ['name' => 'لابتوب وكمبيوتر',  'status' => 'active'],
                    ['name' => 'تابلت',             'status' => 'active'],
                    ['name' => 'سماعات',            'status' => 'active'],
                    ['name' => 'كاميرات',           'status' => 'archieved'],
                ],
            ],
            [
                'name'        => 'ملابس',
                'description' => 'أحدث صيحات الموضة للجميع',
                'status'      => 'active',
                'children'    => [
                    ['name' => 'ملابس رجالي', 'status' => 'active'],
                    ['name' => 'ملابس حريمي', 'status' => 'active'],
                    ['name' => 'ملابس أطفال', 'status' => 'active'],
                ],
            ],
            [
                'name'        => 'أجهزة منزلية',
                'description' => 'كل ما يحتاجه منزلك',
                'status'      => 'active',
                'children'    => [
                    ['name' => 'ثلاجات',  'status' => 'active'],
                    ['name' => 'غسالات',  'status' => 'active'],
                    ['name' => 'مكيفات',  'status' => 'active'],
                    ['name' => 'مطابخ',   'status' => 'archieved'],
                ],
            ],
            [
                'name'        => 'رياضة',
                'description' => 'أدوات ومستلزمات رياضية',
                'status'      => 'active',
                'children'    => [
                    ['name' => 'ملابس رياضية', 'status' => 'active'],
                    ['name' => 'أحذية رياضية', 'status' => 'active'],
                    ['name' => 'أجهزة رياضية', 'status' => 'active'],
                ],
            ],
            [
                'name'        => 'جمال وعناية',
                'description' => 'مستحضرات التجميل والعناية الشخصية',
                'status'      => 'active',
                'children'    => [
                    ['name' => 'عطورات',         'status' => 'active'],
                    ['name' => 'مستحضرات بشرة',  'status' => 'active'],
                    ['name' => 'مكياج',          'status' => 'active'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
      
            $parent = Category::create([
                'name'        => $categoryData['name'],
                'slug'        => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'status'      => $categoryData['status'],
                'parent_id'   => null,
            ]);
 
            foreach ($categoryData['children'] as $child) {
                Category::create([
                    'name'        => $child['name'],
                    'slug'        => Str::slug($child['name']),
                    'description' => null,
                    'status'      => $child['status'],
                    'parent_id'   => $parent->id,
                ]);
            }
        }
    }
}