<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Original Paintings', 'slug' => 'original-paintings', 'description' => 'Unique original paintings from talented artists'],
            ['name' => 'Wall Art', 'slug' => 'wall-art', 'description' => 'Beautiful wall art for your home and office'],
            ['name' => 'New Arrivals', 'slug' => 'new-arrivals', 'description' => 'Fresh new art pieces just arrived'],
            ['name' => 'Art You Wear', 'slug' => 'art-you-wear', 'description' => 'Wearable art for fashion enthusiasts'],
            ['name' => 'Bold Designs', 'slug' => 'bold-designs', 'description' => 'Bold and striking art designs'],
            ['name' => 'New Designs', 'slug' => 'new-designs', 'description' => 'Latest art designs and trends'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}