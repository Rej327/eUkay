<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
        ]);

        // Create product
        $product = Product::create($validated);

        // Handle single image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $imageName, 'public');

            // Save image record
            $product->images()->create([
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        return redirect()->route('manage-products.index')->with('success', 'Product added successfully.');
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('store.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $product->update($validated);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                $oldImage = $product->images()->where('is_primary', true)->first();
                if ($oldImage && Storage::disk('public')->exists($oldImage->image_path)) {
                    Storage::disk('public')->delete($oldImage->image_path);
                    $oldImage->delete();
                }

                $path = $request->file('image')->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => true,
                ]);
            }

            return redirect()->route('manage-products.index')->with('success', 'Product updated successfully.');
        }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('manage-products.index')->with('success', 'Product deleted.');
    }
}
