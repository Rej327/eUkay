<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayMongoController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = (int) $request->input('amount') * 100;

        if ($amount < 10000) {
            return back()->with('error', 'Minimum checkout amount for PayMongo is ₱100.');
        }

        // Save the product ID in the session
        session(['product_id' => $request->input('product_id')]);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->withBasicAuth(env('PAYMONGO_SECRET_KEY'), '')
        ->post('https://api.paymongo.com/v1/links', [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'description' => 'Ukay product order (shipping fee included)',
                    'remarks' => 'Thank you for shopping!',
                    'redirect' => [
                        'success' => route('payment.success'),
                        'failed' => route('payment.failed'),
                    ],
                    'payment_method_types' => ['gcash', 'paymaya', 'card'],
                    'metadata' => [
                        'product_id' => $request->input('product_id'),
                    ],
                ],
            ],
        ]);

        if ($response->successful()) {
            return redirect()->away($response->json('data.attributes.checkout_url'));
        } else {
            logger()->error('PayMongo error: ' . $response->body());
            return back()->with('error', 'Payment failed. Please try again.');
        }
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->input('data.attributes');

        if ($payload['status'] === 'paid') {
            // Assuming you stored product_id in the remarks or metadata
            $productId = $request->input('data.attributes.metadata.product_id');

            if ($productId) {
                Product::where('id', $productId)->update(['is_sold' => true]);
            }
        }

        return response()->json(['message' => 'Webhook handled']);
    }



    public function success()
    {
        $productId = session('product_id');

        if ($productId) {
            Product::where('id', $productId)->update(['is_sold' => true]);
            session()->forget('product_id'); // Clear the session after use
        }

        return view('checkout.success')->with('message', 'Payment successful! Product marked as sold.');
    }



    public function failed()
    {
        return view('payments.failed');
    }
}
