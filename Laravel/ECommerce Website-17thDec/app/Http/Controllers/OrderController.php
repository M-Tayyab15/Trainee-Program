<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 5);
        $idQuery = $request->input('id', '');
        $emailQuery = $request->input('email', '');
        $minPrice = $request->input('min_price', null);
        $maxPrice = $request->input('max_price', null);

        $orders = Cart::with(['user', 'cartProducts.product'])
            ->where('cart_id', 'like', "%$idQuery%")
            ->whereHas('user', function ($query) use ($emailQuery) {
                $query->where('email', 'like', "%$emailQuery%");
            })
            ->when($minPrice, function ($query) use ($minPrice) {
                $query->where('total_amount', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query) use ($maxPrice) {
                $query->where('total_amount', '<=', $maxPrice);
            })
            ->orderBy('cart_id')
            ->paginate($limit);

        return view('admin.orders', compact('orders', 'idQuery', 'emailQuery', 'minPrice', 'maxPrice', 'limit'));
    }

    public function orderDetails(Request $request)
    {
        $cartId = $request->input('cart_id');
        $order = Cart::with('user', 'cartproducts.product')->where('cart_id', $cartId)->first();

        if ($order) {
            return view('orders.details', compact('order'));
        }

        return response('<p>Order not found.</p>', 404);
    }
}
