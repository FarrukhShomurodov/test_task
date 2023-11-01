<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * @param CartRequest $request
     * @return CartResource
     */
    public function add(CartRequest $request): CartResource
    {
        $user = Auth::user();
        $validated = $request->validated();
        $product = [
            'product_id' => $validated['product_id'],
            'quantity' =>  $validated['quantity']
        ];

        $productJSON = json_encode($product);

        $cart = Cart::query()->create([
            "user_id" => $user->id,
            "products" => $productJSON,
            "updated_at" => now(),
            "created_at" => now(),
        ]);

        return CartResource::make($cart);
    }

    /**
     * @param Cart $cart
     * @param CartRequest $request
     * @return CartResource
     */
    public function update(Cart $cart, CartRequest $request): CartResource
    {
        $validated = $request->validated();
        $product = [
            'product_id' => $validated['product_id'],
            'quantity' =>  $validated['quantity']
        ];

        $productJSON = json_encode($product);

        $cart->update([
            "products" => $productJSON,
            "updated_at" => now(),
        ]);

        return CartResource::make($cart);
    }

    /**
     * @param Cart $cart
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
     */
    public function destroy(Cart $cart): \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
    {
        $cart->delete();
        return response('cart has been deleted');
    }
}
