<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Payment Method E-Wallet
        PaymentMethod::create([
            'payment_name' => 'qris',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/qris.webp'
        ]);
        PaymentMethod::create([
            'payment_name' => 'gopay',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/gopay.webp'
        ]);
        PaymentMethod::create([
            'payment_name' => 'shopeepay',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/shopeepay.webp'
        ]);
    }
}
