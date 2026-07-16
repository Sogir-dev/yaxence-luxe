<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use App\Services\Paystack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(protected Cart $cart, protected Paystack $paystack) {}

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

        if (! $this->paystack->isConfigured()) {
            return back()->withInput()->with('status', 'Payments aren\'t set up yet — the store owner needs to add Paystack API keys before checkout can be completed.');
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
                'payment_status' => 'unpaid',
                'payment_gateway' => 'paystack',
                'payment_reference' => $this->generateReference(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'unit_price_cents' => $item['product']->price_cents,
                    'quantity' => $item['quantity'],
                ]);
            }

            return $order;
        });

        $this->cart->clear();

        return $this->redirectToPaystack($order);
    }

    public function retryPayment(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.confirmation', $order);
        }

        if (! $this->paystack->isConfigured()) {
            return back()->with('status', 'Payments aren\'t set up yet — the store owner needs to add Paystack API keys.');
        }

        $order->update(['payment_reference' => $this->generateReference()]);

        return $this->redirectToPaystack($order);
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');
        $order = Order::where('payment_reference', $reference)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.confirmation', $order);
        }

        $result = $this->paystack->verify($reference);
        $paid = ($result['status'] ?? null) === 'success' && (int) ($result['amount'] ?? 0) === $order->total_cents;

        if (! $paid) {
            $order->update(['payment_status' => 'failed']);

            return redirect()->route('checkout.failed', $order);
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product && $product->stock >= $item->quantity) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            $order->update(['payment_status' => 'paid']);
        });

        try {
            Mail::to($order->customer_email)->send(new OrderConfirmed($order));
        } catch (\Throwable $e) {
            Log::error('Failed to send order confirmation email for order #'.$order->id.': '.$e->getMessage());
        }

        return redirect()->route('checkout.confirmation', $order)->with('status', 'Payment received — thank you!');
    }

    public function failed(Order $order)
    {
        return view('checkout.failed', [
            'order' => $order->load('items'),
        ]);
    }

    public function confirmation(Request $request, Order $order)
    {
        if ($order->payment_status !== 'paid') {
            return redirect()->route('checkout.failed', $order);
        }

        return view('checkout.confirmation', [
            'order' => $order->load('items'),
            'isGuest' => ! $request->user() && ! $order->user_id,
        ]);
    }

    protected function redirectToPaystack(Order $order)
    {
        $url = $this->paystack->initialize(
            reference: $order->payment_reference,
            amountKobo: $order->total_cents,
            email: $order->customer_email,
            callbackUrl: route('checkout.callback'),
            metadata: ['order_id' => $order->id],
        );

        return redirect()->away($url);
    }

    protected function generateReference(): string
    {
        return 'YL'.now()->format('ymd').strtoupper(Str::random(8));
    }
}
