<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(protected Cart $cart) {}

    public function show(Request $request)
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        return view('checkout.show', [
            'items' => $items,
            'total' => $this->cart->total(),
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request)
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        foreach ($items as $item) {
            if ($item['quantity'] > $item['product']->stock) {
                return back()->withInput()->with('status', $item['product']->name.' no longer has enough stock.');
            }
        }

        $order = DB::transaction(function () use ($data, $items, $request) {
            $order = Order::create([
                ...$data,
                'user_id' => $request->user()?->id,
                'total_cents' => $this->cart->totalCents(),
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'unit_price_cents' => $item['product']->price_cents,
                    'quantity' => $item['quantity'],
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('checkout.confirmation', $order)->with('status', 'Order placed successfully.');
    }

    public function confirmation(Request $request, Order $order)
    {
        return view('checkout.confirmation', [
            'order' => $order->load('items'),
            'isGuest' => ! $request->user() && ! $order->user_id,
        ]);
    }
}
