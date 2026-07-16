<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Request $request, \App\Models\Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return view('customer.orders.show', [
            'order' => $order->load('items'),
        ]);
    }
}
