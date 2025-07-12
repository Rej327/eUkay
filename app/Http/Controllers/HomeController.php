<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

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

        $cartItemProductIds = [];
        
         if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
            $cartItemProductIds = $cart
            ? $cart->items->pluck('product_id')->toArray()
            : [];
        }

        $wishlistProductIds = Auth::check()
        ? Auth::user()->wishlist->pluck('product_id')->toArray()
        : [];


        return view('home', [
            'category' => $category?->name,
            'products' => $products,
            'newArrivals' => $newArrivals,
            'cartItemProductIds' => $cartItemProductIds,
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }
}
