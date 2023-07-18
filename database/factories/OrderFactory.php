<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'invoice' => "INV//" . rand(1, 999999999) . Carbon::now(),
            'email' => $this->faker->email,
            'player_id' => 'Dummy_playerID',
            'number_phone' => rand(1, 15),
            'before_amount' => 50_000,
            'total_amount' => 50_000,
            'qty' => rand(1, 3),
            'payment_status' =>PaymentStatusEnum::Pending
        ];
    }
}
