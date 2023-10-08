<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryProduct::create([
            'name_category' =>  'Mobile Games',
        ]);

        CategoryProduct::create([
            'name_category' =>  'PC Games',
        ]);

        CategoryProduct::create([
            'name_category' =>  'Voucher',
        ]);

        CategoryProduct::create([
            'name_category' =>  'Pulsa',
        ]);
    }
}
