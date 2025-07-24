<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Furniture, decor, and home essentials',
                'is_active' => true
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, shoes, and accessories',
                'is_active' => true
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Gadgets, computers, and electronic devices',
                'is_active' => true
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Cosmetics, skincare, and beauty products',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
