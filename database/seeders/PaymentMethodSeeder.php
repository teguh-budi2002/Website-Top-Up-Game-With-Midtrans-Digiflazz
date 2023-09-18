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
        // ++++++++++++++++++++++++++++++++ MIDTRANS +++++++++++++++++++++++++++++++++++
        // Payment Method E-Wallet
        PaymentMethod::create([
            'payment_name' => 'qris',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/qris.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'gopay',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/gopay.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'shopeepay',
            'type_of_payment' => 'E-Wallet',
            'img_static' => 'PaymentLogo/shopeepay.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'alfamart',
            'type_of_payment' => 'Over-The-Counter',
            'img_static' => 'PaymentLogo/alfamart.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'indomaret',
            'type_of_payment' => 'Over-The-Counter',
            'img_static' => 'PaymentLogo/indomaret.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'bri',
            'type_of_payment' => 'Bank Transfer',
            'img_static' => 'PaymentLogo/BRI.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'bca',
            'type_of_payment' => 'Bank Transfer',
            'img_static' => 'PaymentLogo/BCA.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'bni',
            'type_of_payment' => 'Bank Transfer',
            'img_static' => 'PaymentLogo/BNI.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'permata',
            'type_of_payment' => 'Bank Transfer',
            'img_static' => 'PaymentLogo/PERMATA.webp',
            'provider'  => 'midtrans'
        ]);
        PaymentMethod::create([
            'payment_name' => 'cimb',
            'type_of_payment' => 'Bank Transfer',
            'img_static' => 'PaymentLogo/CIMB.webp',
            'provider'  => 'midtrans'
        ]);


        // ++++++++++++++++++++++++++++++++ Xendit +++++++++++++++++++++++++++++++++++
        PaymentMethod::create([
            'payment_name' => 'alfamidi',
            'type_of_payment' => 'Over-The-Counter',
            'img_static' => 'PaymentLogo/alfamidi.webp',
            'provider'  => 'xendit'
        ]);
        PaymentMethod::create([
            'payment_name' => 'indomaret',
            'type_of_payment' => 'Over-The-Counter',
            'img_static' => 'PaymentLogo/indomaret.webp',
            'provider'  => 'xendit'
        ]);
    }
}
