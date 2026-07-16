<x-layouts.admin title="Bulk Import">
    <div class="max-w-2xl">
        <p class="text-sm text-neutral-400">
            Upload a CSV file to add many products at once — perfect for adding your full catalog in one go.
        </p>

        <div class="mt-6 rounded-sm border border-gold-900/30 bg-neutral-900 p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-gold-300">Step 1</p>
            <p class="mt-2 text-sm text-neutral-300">
                Download the template, open it in Excel or Google Sheets, and fill in one row per product.
            </p>
            <a href="{{ route('admin.products.import.template') }}" class="mt-4 inline-block rounded-sm border border-neutral-700 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.15em] text-neutral-200 hover:border-gold-400 hover:text-gold-300">
                Download CSV Template
            </a>

            <div class="mt-4 text-xs text-neutral-500">
                <p class="font-semibold uppercase tracking-wide text-neutral-400">Columns</p>
                <p class="mt-1">
                    <span class="text-gold-300">name</span>, <span class="text-gold-300">category</span> (men / women / unisex), <span class="text-gold-300">price</span> (in Naira, e.g. 75000) — required.
                    <br>
                    stock, description, concentration, size_ml, top_notes, heart_notes, base_notes, featured (true/false) — optional.
                </p>
            </div>
        </div>

        <div class="mt-6 rounded-sm border border-gold-900/30 bg-neutral-900 p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-gold-300">Step 2</p>
            <p class="mt-2 text-sm text-neutral-300">Upload your completed CSV file.</p>

            <form method="POST" action="{{ route('admin.products.import.store') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                <input type="file" name="file" accept=".csv,text/csv" required class="w-full text-sm text-neutral-400">
                <button type="submit" class="mt-4 rounded-sm bg-gold-400 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                    Import Products
                </button>
            </form>
        </div>

        <p class="mt-4 text-xs text-neutral-500">
            Product photos aren't part of the CSV — after importing, drop image files into
            <code class="text-neutral-400">public/images/products/</code> named after each product (e.g. <code class="text-neutral-400">midnight-rose.jpg</code>).
        </p>
    </div>
</x-layouts.admin>
