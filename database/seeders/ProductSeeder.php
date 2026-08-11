<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title' => 'Premium Skin Friendly Mini Shaver',
            'regular_price' => '1950',
            'discounted_price' => '1299',
        ]);
    }
}
