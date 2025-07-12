<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreItems extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(Product $product)
    {
        $user = Auth::user();

        $product->load('images', 'category');

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(3)
            ->get();

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

        return view('category.show', compact('product', 'relatedProducts', 'cartItemProductIds', 'wishlistProductIds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
