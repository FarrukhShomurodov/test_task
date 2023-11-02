<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * @param CartRequest $request
     * @return CartResource|\Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
     */
    public function add(CartRequest $request): Application|Response|CartResource|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if (Auth::check()) {
            $user = Auth::user();
            $validated = $request->validated();
            $product = [
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ];

            $productJSON = json_encode($product);

            $cart = Cart::query()->create([
                "user_id" => $user->id,
                "products" => $productJSON,
                "updated_at" => now(),
                "created_at" => now(),
            ]);

            return CartResource::make($cart);
        } else {
            $cart = Session::get('cart', []);

            $validated = $request->validated();
            $product = [
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ];

            $cart[] = $product;

            Session::put('cart', $cart);

            return response('Item added to the cart');
        }
    }


    /**
     * @param CartRequest $request
     * @return CartResource|\Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
     */
    public function update(CartRequest $request): Application|Response|CartResource|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if (Auth::check()) {
            $user = Auth::user();
            $validated = $request->validated();
            $product = [
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity']
            ];

            $productJSON = json_encode($product);

            $user->cart()->update([
                "products" => $productJSON,
                "updated_at" => now(),
            ]);

            return CartResource::make($user->cart()->get());
        } else {
            $cartItems = Session::get('cart', []);
            $validated = $request->validated();
            $productId = $validated['product_id'];

            foreach ($cartItems as $key => $item) {
                if ($item['product_id'] === $productId) {
                    $cartItems[$key]['quantity'] = $validated['quantity'];
                    break;
                }
            }

            Session::put('cart', $cartItems);

            return response('Cart item updated for guest user');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
     */
    public function destroy(): \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->cart()->delete();
            return response('Cart has been deleted');
        } else {
            Session::forget('cart');
            return response('Cart has been cleared for guest users');
        }
    }
}
