<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'invoice' => $this->invoice,
            'email' => $this->email,
            'player_id' => $this->player_id,
            'number_phone' => $this->number_phone,
            'before_amount' => $this->before_amount,
            'total_amount' => $this->total_amount,
            'qty' => $this->qty,
            'payment_status' => $this->payment_status
        ];
    }
}
