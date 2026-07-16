<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $products = Product::when($category, fn ($query) => $query->category($category))
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(24)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'category' => $category,
            'search' => $search,
        ]);
    }

    public function show(Product $product)
    {
        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
