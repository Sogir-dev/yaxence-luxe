<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::where('featured', true)->orderBy('name')->get();
        $bestsellers = Product::orderBy('name')->limit(6)->get();

        $showcase = collect(['men', 'women', 'unisex'])->map(
            fn ($category) => Product::where('category', $category)->inRandomOrder()->first()
        )->filter();

        return view('home', compact('featured', 'bestsellers', 'showcase'));
    }
}
