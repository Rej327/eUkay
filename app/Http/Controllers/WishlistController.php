<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the user's wishlist items.
        */
    public function index()
    {
        $user = Auth::user();

        $wishlistItems = Wishlist::with('product.images')->where('user_id', $user->id)->get();

        $cartProductIds = $user->cart
            ? $user->cart->items->pluck('product_id')->toArray()
            : [];

        return view('wishlist.index', compact('wishlistItems', 'cartProductIds'));
    }

    /**
     * Store a new product in the user's wishlist.
     */
    public function store($productId)
    {
        $user = Auth::user();

        // Prevent duplicate wishlist entries
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }

        return back()->with('success', 'Product added to your wishlist.');
    }

    /**
     * Remove a product from the user's wishlist.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $wishlistItem = Wishlist::findOrFail($id);

        if ($wishlistItem->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $wishlistItem->delete();

        return back()->with('success', 'Product removed from your wishlist.');
    }

    // public function addAllToCart()
    // {
    //     $user = Auth::user();
    //     $cart = $user->cart;

    //     if (!$cart) {
    //         $cart = Cart::create(['user_id' => $user->id]);
    //     }

    //     $existingProductIds = $cart->items->pluck('product_id')->toArray();

    //     $wishlistItems = Wishlist::where('user_id', $user->id)->get();

    //     foreach ($wishlistItems as $item) {
    //         if (!in_array($item->product_id, $existingProductIds)) {
    //             CartItem::create([
    //                 'cart_id' => $cart->id,
    //                 'product_id' => $item->product_id,
    //             ]);
    //         }
    //     }

    //     return back()->with('success', 'All wishlist items added to cart.');
    // }

    public function clear()
    {
        $user = Auth::user();
        Wishlist::where('user_id', $user->id)->delete();

        return back()->with('success', 'Wishlist cleared successfully.');
    }

}
