<x-layouts.admin :title="'Order #'.$order->id">
    <a href="{{ route('admin.orders.index') }}" class="text-xs uppercase tracking-[0.2em] text-neutral-500 hover:text-gold-300">
        &larr; All Orders
    </a>

    <div class="mt-6 grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-sm border border-gold-900/30 bg-neutral-900">
                <div class="border-b border-gold-900/30 px-6 py-4">
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Items</h2>
                </div>
                <div class="divide-y divide-neutral-800 px-6">
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-4 text-sm">
                            <span class="text-neutral-200">{{ $item->product_name }} &times; {{ $item->quantity }}</span>
                            <span class="text-neutral-300">&#8358;{{ number_format($item->subtotal, 0) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between border-t border-gold-900/30 px-6 py-4 font-medium">
                    <span class="text-white">Total</span>
                    <span class="text-gold-300">&#8358;{{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            <div class="mt-6 rounded-sm border border-gold-900/30 bg-neutral-900 p-6">
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Customer &amp; Shipping</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <p><span class="text-neutral-500">Name:</span> <span class="text-neutral-200">{{ $order->customer_name }}</span></p>
                    <p><span class="text-neutral-500">Email:</span> <span class="text-neutral-200">{{ $order->customer_email }}</span></p>
                    <p>
                        <span class="text-neutral-500">Phone:</span>
                        <a href="tel:{{ $order->customer_phone }}" class="text-gold-300 hover:underline">{{ $order->customer_phone ?? 'Not provided' }}</a>
                        @if($order->whatsapp_url)
                            <a href="{{ $order->whatsapp_url }}" target="_blank" class="ml-2 text-xs uppercase tracking-wide text-green-400 hover:underline">WhatsApp &rarr;</a>
                        @endif
                    </p>
                    <p><span class="text-neutral-500">Address:</span> <span class="text-neutral-200">{{ $order->shipping_address }}</span></p>
                    <p><span class="text-neutral-500">Account:</span> <span class="text-neutral-200">{{ $order->user ? 'Registered customer' : 'Guest checkout' }}</span></p>
                    <p><span class="text-neutral-500">Placed:</span> <span class="text-neutral-200">{{ $order->created_at->format('M j, Y \a\t g:ia') }}</span></p>
                </div>
            </div>
        </div>

        <div>
            @php
                $paymentStyles = [
                    'unpaid' => 'border-neutral-600 text-neutral-400',
                    'paid' => 'border-green-400 text-green-300',
                    'failed' => 'border-red-400 text-red-300',
                ];
            @endphp
            <div class="rounded-sm border border-gold-900/30 bg-neutral-900 p-6">
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Payment</h2>
                <span class="mt-3 inline-block rounded-full border px-3 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $paymentStyles[$order->payment_status] ?? $paymentStyles['unpaid'] }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
                <div class="mt-3 space-y-1 text-xs text-neutral-500">
                    <p>Gateway: {{ $order->payment_gateway ? ucfirst($order->payment_gateway) : '—' }}</p>
                    <p class="break-all">Reference: {{ $order->payment_reference ?? '—' }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-sm border border-gold-900/30 bg-neutral-900 p-6">
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Order Status</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mt-4 space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-sm border-neutral-700 bg-neutral-950 text-sm text-white">
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full rounded-sm bg-gold-400 px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.15em] text-black hover:bg-gold-300">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
