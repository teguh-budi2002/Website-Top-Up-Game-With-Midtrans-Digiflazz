<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $productName = $this->faker->name(),
            'category_id'   => mt_rand(1, 4),
            'slug' => Str::slug($productName),
            'img_url' => 'IMG_DEV',
            'published' => 1
        ];
    }
}
