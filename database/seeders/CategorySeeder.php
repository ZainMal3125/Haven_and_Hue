<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Table Decor',
            'Wall Art',
            'Kitchenware',
            'Furniture',
            'Lighting',
            'Planters'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Beautiful wooden ' . strtolower($category) . ' for your home.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
