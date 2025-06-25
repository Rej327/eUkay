<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $products = Product::all();
        return view('store.index', compact('products'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        $categories = Category::all();
        return view('store.edit', compact('categories'));
    }

public function store(Request $request)
{
    if (!auth()->user()->isAdmin()) {
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB limit
    ]);

    $product = Product::create($validated);

    // Handle image upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');

        // Save to product_images table if using image relation
        $product->images()->create([
            'path' => $path
        ]);
    }

    return redirect()->route('manage-products.index')->with('success', 'Product added.');
}

    public function edit(Product $product)
    {
        return view('store.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]));

        return redirect()->route('manage-products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('manage-products.index')->with('success', 'Product deleted.');
    }
}
