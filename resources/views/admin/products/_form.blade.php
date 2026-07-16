@php
    $p = $product ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-5 lg:col-span-2">
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $p?->name) }}" required
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Category</label>
                <select id="category" name="category" required class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
                    @foreach(['men' => "Men's", 'women' => "Women's", 'unisex' => 'Unisex'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $p?->category) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="concentration" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Concentration</label>
                <input type="text" id="concentration" name="concentration" value="{{ old('concentration', $p?->concentration) }}" placeholder="Eau de Parfum"
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="price" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Price (&#8358;)</label>
                <input type="number" step="1" min="0" id="price" name="price" value="{{ old('price', $p?->price) }}" required
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
            <div>
                <label for="stock" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Stock</label>
                <input type="number" step="1" min="0" id="stock" name="stock" value="{{ old('stock', $p?->stock ?? 0) }}" required
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
            <div>
                <label for="size_ml" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Size (ml)</label>
                <input type="number" step="1" min="0" id="size_ml" name="size_ml" value="{{ old('size_ml', $p?->size_ml) }}"
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
        </div>

        <div>
            <label for="description" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Description</label>
            <textarea id="description" name="description" rows="4"
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">{{ old('description', $p?->description) }}</textarea>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="top_notes" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Top Notes</label>
                <input type="text" id="top_notes" name="top_notes" value="{{ old('top_notes', $p?->top_notes) }}"
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
            <div>
                <label for="heart_notes" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Heart Notes</label>
                <input type="text" id="heart_notes" name="heart_notes" value="{{ old('heart_notes', $p?->heart_notes) }}"
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
            <div>
                <label for="base_notes" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Base Notes</label>
                <input type="text" id="base_notes" name="base_notes" value="{{ old('base_notes', $p?->base_notes) }}"
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-neutral-300">
            <input type="checkbox" name="featured" value="1" @checked(old('featured', $p?->featured)) class="rounded-sm border-neutral-700 bg-neutral-900">
            Feature on homepage
        </label>
    </div>

    <div>
        <label class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Photo</label>
        <div class="mt-2 aspect-square w-full overflow-hidden rounded-sm border border-gold-900/30">
            <x-product-visual :product="$p ?? new \App\Models\Product(['category' => 'unisex', 'name' => 'New Fragrance', 'id' => 0])" />
        </div>
        <input type="file" name="photo" accept="image/*" class="mt-3 w-full text-sm text-neutral-400">
        <p class="mt-2 text-xs text-neutral-500">
            Optional. JPG, PNG, or WEBP. Leave empty to keep the current image or placeholder art.
        </p>
    </div>
</div>

<div class="mt-8 flex items-center gap-4">
    <button type="submit" class="rounded-sm bg-gold-400 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
        {{ $p ? 'Save Changes' : 'Add Product' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="text-xs uppercase tracking-[0.2em] text-neutral-400 hover:text-gold-300">
        Cancel
    </a>
</div>
