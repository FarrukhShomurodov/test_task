<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    /**
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(): JsonResponse|AnonymousResourceCollection
    {
        if (Auth::check()) {
            $user = Auth::user();

            $orders = $user->orders()->get();

            return OrderResource::collection($orders);

        } else {
            $orders = Order::query()->where('user_id', '=', null)->get();
            return response()->json($orders);
        }
    }

    /**
     * @param Request $request
     * @return OrderResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart();
            $contact_info = [
                'email' => $user->email
            ];
            $products = $cart->get('products')[0]->products;
            $cart->delete();
            $order = Order::query()->create([
                'user_id' => $user->id ?? null, // Providing null as default if the user is not authenticated
                'contact_info' => $contact_info,
                'products' => $products,
            ]);
        } else {
            $contact_info = $request->input('contact_info');
            $products = Session::get('cart', []);
            Session::forget('cart');
            $order = Order::query()->create([
                'user_id' => $user->id ?? null, // Providing null as default if the user is not authenticated
                'contact_info' => json_encode($contact_info),
                'products' => json_encode($products[0]),
            ]);
//            return response($order);
        }



        return OrderResource::make($order);
    }

}
