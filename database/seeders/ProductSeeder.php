<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(87)->create();
        Product::create([
            'category_id' => 2,
            'product_name' => 'Valorant',
            'code_product' => 'VALORANT',
            'slug' => 'valorant',
            'img_url' => '/img/default_image_product.webp',
            'is_testing' => 1
        ]);

        Product::create([
            'category_id' => 1,
            'product_name' => 'Call Of Duty Mobile [CODM]',
            'code_product' => 'CALL_OF_DUTY',
            'slug' => 'call-of-duty',
            'img_url' => '/img/default_image_product.webp',
            'is_testing' => 1
        ]);

        Product::create([
            'category_id' => 1,
            'product_name' => 'Mobile Legends',
            'code_product' => 'MOBILE_LEGENDS',
            'slug' => 'mobile-legends',
            'img_url' => '/img/default_image_product.webp',
            'is_testing' => 1
        ]);
    }
}
