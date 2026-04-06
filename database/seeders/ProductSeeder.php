<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Kopi Hitam', 'description' => 'Kopi hitam original', 'price' => 15000, 'stock' => 50],
            ['name' => 'Cappuccino', 'description' => 'Cappuccino with foam', 'price' => 25000, 'stock' => 40],
            ['name' => 'Latte', 'description' => 'Cafe Latte', 'price' => 25000, 'stock' => 45],
            ['name' => 'Matcha Latte', 'description' => 'Green tea latte', 'price' => 30000, 'stock' => 30],
            ['name' => 'Croissant', 'description' => 'Butter croissant', 'price' => 15000, 'stock' => 25],
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}