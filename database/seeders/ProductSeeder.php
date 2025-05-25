<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sepatuCategory = Category::where('name', 'sepatu')->first();
        $hoodieCategory = Category::where('name', 'hoodie')->first();

        if ($sepatuCategory) {
            Product::create([
                'name' => 'Sneakers Klasik',
                'category_id' => $sepatuCategory->id,
                'stock' => 50,
                'price' => 450000,
                'status' => 'tersedia',
            ]);

            Product::create([
                'name' => 'Sepatu Lari Ringan',
                'category_id' => $sepatuCategory->id,
                'stock' => 30,
                'price' => 600000,
                'status' => 'tersedia',
            ]);
        }

        if ($hoodieCategory) {
            Product::create([
                'name' => 'Hoodie Polos Hitam',
                'category_id' => $hoodieCategory->id,
                'stock' => 40,
                'price' => 300000,
                'status' => 'tersedia',
            ]);

            Product::create([
                'name' => 'Hoodie Grafis Keren',
                'category_id' => $hoodieCategory->id,
                'stock' => 25,
                'price' => 350000,
                'status' => 'tersedia',
            ]);
        }
    }
}
