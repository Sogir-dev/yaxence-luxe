<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
    public const PAYMENT_STATUSES = ['unpaid', 'paid', 'failed'];

    public function index(Request $request)
    {
        $status = $request->query('status');
        $paymentStatus = $request->query('payment_status');
        $search = $request->query('search');

        $orders = Order::with('items')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($paymentStatus, fn ($query) => $query->where('payment_status', $paymentStatus))
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('id', $search);
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'status' => $status,
            'paymentStatus' => $paymentStatus,
            'search' => $search,
            'statuses' => self::STATUSES,
            'paymentStatuses' => self::PAYMENT_STATUSES,
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $order->load('items'),
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
        ]);

        $order->update($data);

        return back()->with('status', 'Order #'.$order->id.' marked as '.$data['status'].'.');
    }
}
