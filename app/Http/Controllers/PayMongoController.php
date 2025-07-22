<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayMongoController extends Controller
{
    public function checkout(Request $request)
    {
        // Convert from pesos to centavos
        $amount = (int) $request->input('amount') * 100;

        // Check if amount is below minimum
        if ($amount < 10000) {
            return back()->with('error', 'Minimum checkout amount for PayMongo is ₱100.');
        }

        // Create PayMongo payment link
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

    public function success()
    {
        return view('payments.success');
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
