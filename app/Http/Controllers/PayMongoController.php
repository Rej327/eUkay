<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class PayMongoController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = (int) $request->input('amount') * 100; // Convert to centavos

        $productIds = (array) $request->input('product_ids', []);

        if (empty($productIds)) {
            return back()->with('error', 'No products selected.');
        }

        // Optional: mark as sold before payment (manual testing mode)
        Product::whereIn('id', $productIds)->update(['is_sold' => true]);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
        ->post('https://api.paymongo.com/v1/links', [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'description' => 'Ukay product order',
                    'remarks' => 'Thank you for shopping!',
                    'redirect' => [
                        'success' => route('payment.success'),
                        'failed' => route('payment.failed'),
                    ],
                    'payment_method_types' => ['gcash', 'paymaya', 'card'],
                    'metadata' => [
                        'product_ids' => $productIds,
                    ],
                ],
            ],
        ]);

        if ($response->successful()) {
            $checkoutUrl = $response->json('data.attributes.checkout_url');
            
            if ($checkoutUrl) {
                return redirect()->away($checkoutUrl); // <-- This is crucial!
            } else {
                return back()->with('error', 'Checkout URL not found.');
            }
        }

        return back()->with('error', 'Payment failed. Please try again.');
    }

    public function success()
    {
        $productIds = session('product_ids', []);

        if (empty($productIds)) {
            return redirect()->route('home')->with('error', 'No product found in session.');
        }

        // Optional: Forget after use
        session()->forget('product_ids');

        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            if (!$product->is_sold) {
                $product->update(['is_sold' => true]);
            }
        }

        return view('payments.success');
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
