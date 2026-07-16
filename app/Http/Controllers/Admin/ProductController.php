<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $products = Product::when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $product = Product::create($this->prepareData($data));

        $this->handlePhotoUpload($request, $product);

        return redirect()->route('admin.products.index')->with('status', "\"{$product->name}\" was added.");
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);

        $product->update($this->prepareData($data, $product));

        $this->handlePhotoUpload($request, $product);

        return redirect()->route('admin.products.index')->with('status', "\"{$product->name}\" was updated.");
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return back()->with('status', "\"{$name}\" was deleted.");
    }

    public function showImport()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = array_map(fn ($col) => strtolower(trim($col)), fgetcsv($handle));

        $required = ['name', 'category', 'price'];
        foreach ($required as $column) {
            if (! in_array($column, $header)) {
                fclose($handle);

                return back()->withErrors(['file' => "CSV is missing the required \"{$column}\" column."]);
            }
        }

        $imported = 0;
        $skipped = 0;

        DB::transaction(function () use ($handle, $header, &$imported, &$skipped) {
            while (($row = fgetcsv($handle)) !== false) {
                $row = array_map(fn ($value) => $value === null ? null : trim($value), $row);
                $record = array_combine($header, array_pad($row, count($header), null));

                if (empty($record['name']) || empty($record['category']) || $record['price'] === null || $record['price'] === '') {
                    $skipped++;

                    continue;
                }

                $category = strtolower($record['category']);
                if (! in_array($category, ['men', 'women', 'unisex'])) {
                    $skipped++;

                    continue;
                }

                Product::create([
                    'name' => $record['name'],
                    'slug' => $this->uniqueSlug($record['name']),
                    'category' => $category,
                    'description' => $record['description'] ?? null,
                    'concentration' => $record['concentration'] ?? null,
                    'size_ml' => $record['size_ml'] !== null && $record['size_ml'] !== '' ? (int) $record['size_ml'] : null,
                    'top_notes' => $record['top_notes'] ?? null,
                    'heart_notes' => $record['heart_notes'] ?? null,
                    'base_notes' => $record['base_notes'] ?? null,
                    'featured' => filter_var($record['featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'price_cents' => (int) round(((float) $record['price']) * 100),
                    'stock' => $record['stock'] !== null && $record['stock'] !== '' ? (int) $record['stock'] : 0,
                    'image' => null,
                ]);

                $imported++;
            }
        });

        fclose($handle);

        return redirect()->route('admin.products.index')
            ->with('status', "Imported {$imported} product(s)".($skipped > 0 ? ", skipped {$skipped} invalid row(s)." : '.'));
    }

    public function downloadTemplate()
    {
        $columns = ['name', 'category', 'price', 'stock', 'description', 'concentration', 'size_ml', 'top_notes', 'heart_notes', 'base_notes', 'featured'];
        $example = ['Midnight Rose', 'women', '75000', '20', 'A deep rose fragrance.', 'Eau de Parfum', '100', 'Bergamot, Pink Pepper', 'Rose, Jasmine', 'Musk, Amber', 'false'];

        $callback = function () use ($columns, $example) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            fputcsv($handle, $example);
            fclose($handle);
        };

        return response()->streamDownload($callback, 'product-import-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['men', 'women', 'unisex'])],
            'description' => ['nullable', 'string'],
            'concentration' => ['nullable', 'string', 'max:255'],
            'size_ml' => ['nullable', 'integer', 'min:0'],
            'top_notes' => ['nullable', 'string', 'max:255'],
            'heart_notes' => ['nullable', 'string', 'max:255'],
            'base_notes' => ['nullable', 'string', 'max:255'],
            'featured' => ['sometimes', 'boolean'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    protected function prepareData(array $data, ?Product $product = null): array
    {
        $data['featured'] = $data['featured'] ?? false;
        $data['price_cents'] = (int) round(((float) $data['price']) * 100);
        unset($data['price'], $data['photo']);

        if (! $product || $product->name !== $data['name']) {
            $data['slug'] = $this->uniqueSlug($data['name'], $product?->id);
        }

        return $data;
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $suffix = 2;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    protected function handlePhotoUpload(Request $request, Product $product): void
    {
        if (! $request->hasFile('photo')) {
            return;
        }

        $directory = public_path('images/products');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $existing = "{$directory}/{$product->slug}.{$extension}";
            if (file_exists($existing)) {
                unlink($existing);
            }
        }

        $extension = $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move($directory, "{$product->slug}.{$extension}");
    }
}
