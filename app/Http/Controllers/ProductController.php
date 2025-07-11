<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        $products = Product::with('images')->get();
        $categories = Category::all();

        // Pass products & categories to the index view
        return view('store.index', compact('products', 'categories'));
    }

    // public function create()
    // {
    //     if (!auth()->user()->isAdmin()) {
    //         return redirect()->route('home')->with('error', 'Unauthorized access.');
    //     }

    //     $categories = Category::all();
    //     return view('store.edit', compact('categories'));
    // }

        public function show(Product $product)
    {
        // $product->load('images');
        // return view('store.show', compact('product'));
        // return view('category.show');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            ]);

            $product = Product::create($validated);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $imageName, 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => true,
                ]);
            }

            return redirect()->route('manage-products.index')->with('success', 'Product added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->route('manage-products.index')->with('error', 'Failed to add product.');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('store.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $product->update($validated);

            if ($request->hasFile('image')) {
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
        } catch (\Exception $e) {
            return redirect()->route('manage-products.index')->with('error', 'Failed to update product.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Delete image files from storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                // Optionally delete the image record in the DB
                $image->delete();
            }

            // Delete the product record
            $product->delete();

            return redirect()->route('manage-products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('manage-products.index')->with('error', 'Failed to delete product.');
        }
    }


}
