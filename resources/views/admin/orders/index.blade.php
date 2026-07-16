@php
    $statusStyles = [
        'pending' => 'border-neutral-600 text-neutral-300',
        'processing' => 'border-gold-400 text-gold-300',
        'shipped' => 'border-blue-400 text-blue-300',
        'delivered' => 'border-green-400 text-green-300',
        'cancelled' => 'border-red-400 text-red-300',
    ];
@endphp

<x-layouts.admin title="Orders">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search order #, name, email..."
                class="w-full rounded-sm border-neutral-700 bg-neutral-900 text-sm text-white sm:w-64">
            <select name="status" class="rounded-sm border-neutral-700 bg-neutral-900 text-sm text-white">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-sm border border-neutral-700 px-4 py-2 text-xs uppercase tracking-wide text-neutral-300 hover:border-gold-400 hover:text-gold-300">
                Filter
            </button>
            @if($status || $search)
                <a href="{{ route('admin.orders.index') }}" class="flex items-center text-xs uppercase tracking-wide text-neutral-500 hover:text-gold-300">Clear</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto rounded-sm border border-gold-900/30">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gold-900/30 bg-neutral-900 text-xs uppercase tracking-wide text-neutral-400">
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Items</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3 text-white">#{{ $order->id }}</td>
                        <td class="px-4 py-3">
                            <p class="text-neutral-200">{{ $order->customer_name }}</p>
                            <p class="text-xs text-neutral-500">{{ $order->customer_email }}</p>
                        </td>
                        <td class="px-4 py-3 text-neutral-400">{{ $order->items->sum('quantity') }}</td>
                        <td class="px-4 py-3 text-neutral-300">&#8358;{{ number_format($order->total, 0) }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full border px-3 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $statusStyles[$order->status] ?? $statusStyles['pending'] }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-neutral-500">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-xs uppercase tracking-wide text-gold-300 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-neutral-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</x-layouts.admin>
