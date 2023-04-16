<?php

namespace Database\Factories;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => rand(1, 5),
            'invoice' => "INV//" . rand(1, 999999999),
            'qty' => rand(1, 3),
            'payment_status' =>PaymentStatusEnum::Pending
        ];
    }
}
