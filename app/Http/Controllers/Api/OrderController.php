<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();

        $orders = $user->orders()->get();

        return OrderResource::collection($orders);
    }

    /**
     * @param Request $request
     * @return OrderResource
     */
    public function store(Request $request): OrderResource
    {
        $user = Auth::user();
        $cart = $user->cart();

        if (Auth::check()) {
            $user = Auth::user();
            $contact_info = [
                'email' => $user->email
            ];
        } else {
            $contact_info = $request->input('contact_info');
        }

        $order = Order::query()->create([
            'user_id' => $user->id,
            'contact_info' => json_encode($contact_info),
            'products' => $cart->get('products')[0]->products,
        ]);

        $cart->delete();

        return OrderResource::make($order);
    }
}
