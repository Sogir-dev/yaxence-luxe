<x-layouts.admin title="Products">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search products..."
                class="w-full rounded-sm border-neutral-700 bg-neutral-900 text-sm text-white sm:w-64">
            <button type="submit" class="rounded-sm border border-neutral-700 px-4 py-2 text-xs uppercase tracking-wide text-neutral-300 hover:border-gold-400 hover:text-gold-300">
                Search
            </button>
        </form>

        <div class="flex gap-3">
            <a href="{{ route('admin.products.import') }}" class="rounded-sm border border-neutral-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.15em] text-neutral-300 hover:border-gold-400 hover:text-gold-300">
                Bulk Import
            </a>
            <a href="{{ route('admin.products.create') }}" class="rounded-sm bg-gold-400 px-4 py-2.5 text-xs font-semibold uppercase tracking-[0.15em] text-black hover:bg-gold-300">
                + Add Product
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-sm border border-gold-900/30">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gold-900/30 bg-neutral-900 text-xs uppercase tracking-wide text-neutral-400">
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-10 shrink-0 overflow-hidden rounded-sm border border-gold-900/30">
                                    <x-product-visual :product="$product" />
                                </div>
                                <span class="text-white">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-neutral-400">{{ $product->category_label }}</td>
                        <td class="px-4 py-3 text-neutral-300">&#8358;{{ number_format($product->price, 0) }}</td>
                        <td class="px-4 py-3 {{ $product->stock <= 0 ? 'text-red-400' : 'text-neutral-300' }}">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs uppercase tracking-wide text-gold-300 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete {{ addslashes($product->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs uppercase tracking-wide text-red-400 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-neutral-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.admin>
