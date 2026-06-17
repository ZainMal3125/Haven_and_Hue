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
            $slug = Str::slug($category);
            if (!DB::table('categories')->where('slug', $slug)->exists()) {
                DB::table('categories')->insert([
                    'name' => $category,
                    'slug' => $slug,
                    'description' => 'Beautiful wooden ' . strtolower($category) . ' for your home.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
