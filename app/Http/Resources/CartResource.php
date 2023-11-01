<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product_id = json_decode($this->products)->product_id;
        $quantity = json_decode($this->products)->quantity;
        $user = Auth::user();
        return [
            'id' => $this->id,
            'user' => $user,
            'products' => [
                'product' => $product_id,
                'quantity' => $quantity
            ],
        ];
    }
}
