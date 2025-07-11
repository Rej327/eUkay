<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        // Optionally: Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to add to cart.');
        }

        // Find or create the user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Add product to cart (avoid duplicates)
        CartItem::firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $productId
        ]);

        return back()->with('success', 'Product added to cart!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $cart = Cart::with('items.product.images')->where('user_id', $user->id)->first();

        $cartItems = collect();

        if ($cart && $cart->items->isNotEmpty()) {
            $cartItems = $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'image' => $item->product->images->first()?->image_path 
                        ? asset('storage/' . $item->product->images->first()->image_path)
                        : null,
                    'price' => $item->product->price,
                ];
            });
        }

        $subtotal = $cartItems->sum(fn($item) => $item['price']);
        $shippingFee = $subtotal > 1000 ? 0.0 : 10.0;
        $total = $subtotal + $shippingFee;

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
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
    public function show(string $id)
    {
        //
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
        $user = Auth::user();

        $cartItem = CartItem::findOrFail($id);

        // Ensure the item belongs to the user's cart
        if ($cartItem->cart->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();

        if ($cart) {
            $cart->items()->delete(); // delete all cart items
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully.');
    }
}
