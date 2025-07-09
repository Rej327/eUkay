<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categoryName = $request->query('category');
        $sort = $request->query('sort');

        $category = null;
        $productsQuery = Product::with('images');

        if ($categoryName) {
            $category = Category::whereRaw('LOWER(name) = ?', [strtolower($categoryName)])->first();

            if ($category) {
                $productsQuery = $category->products()->with('images');
            }
        }

        match ($sort) {
            'price_asc' => $productsQuery->orderBy('price', 'asc'),
            'price_desc' => $productsQuery->orderBy('price', 'desc'),
            'newest' => $productsQuery->orderBy('created_at', 'desc'),
            default => $productsQuery->latest(),
        };

        $products = $productsQuery->paginate(12);

        // 🆕 Get 8 newest arrivals
        $newArrivals = Product::with('images')->latest()->take(8)->get();

        return view('home', [
            'category' => $category?->name,
            'products' => $products,
            'newArrivals' => $newArrivals,
        ]);
    }
}
