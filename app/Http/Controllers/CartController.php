<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected Cart $cart) {}

    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:'.max($product->stock, 1)],
        ]);

        $this->cart->add($product->id, $data['quantity'] ?? 1);

        return back()->with('status', $product->name.' added to your cart.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $this->cart->update($product->id, $data['quantity']);

        return back()->with('status', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product->id);

        return back()->with('status', 'Item removed from cart.');
    }
}
