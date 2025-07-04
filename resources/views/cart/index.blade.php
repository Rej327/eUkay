@php
  $cartItems = [
      [
          'id' => 1,
          'name' => 'Mock T-Shirt',
          'image' => '/storage/products/1751429048_6864afb82fe32.jpg',
          'price' => 499.0,
          'quantity' => 1,
      ],
      [
          'id' => 2,
          'name' => 'Mock Hoodie',
          'image' => '/storage/products/1751429048_6864afb82fe32.jpg',
          'price' => 399.0,
          'quantity' => 1,
      ],
  ];

  $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
  $shippingFee = $subtotal > 1000 ? 0.0 : 10.0;
  $total = $subtotal + $shippingFee;
@endphp

<x-app-layout>
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#4B433C]">Your Cart</h2>
      <x-danger-button>Clear Cart</x-danger-button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#f3f1ef] text-[#4B433C]">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Product</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Price</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Quantity</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Total</th>
            <th class="py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
          @foreach ($cartItems as $item)
            <tr>
              <td class="px-6 py-4">
                <div class="flex items-center gap-4">
                  <img src="{{ $item['image'] }}" alt="Product Image" class="w-16 h-16 object-cover rounded">
                  <span class="font-medium">{{ $item['name'] }}</span>
                </div>
              </td>
              <td class="px-6 py-4">₱ {{ number_format($item['price'], 2) }}</td>
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <button class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">-</button>
                  <span>{{ $item['quantity'] }}</span>
                  <button class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300">+</button>
                </div>
              </td>
              <td class="px-6 py-4 font-semibold">
                ₱ {{ number_format($item['price'] * $item['quantity'], 2) }}
              </td>
              <td class="px-6 py-4 text-right w-8">
                <x-fas-delete-left class="w-6 h-6 primary-text-color" />
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Subtotal -->
    <div class="flex justify-end mt-6">
      <div class="w-full max-w-sm bg-white shadow-md rounded-lg p-4 space-y-3">

        <!-- Subtotal -->
        <div class="flex justify-between">
          <span class="text-sm text-gray-600">Subtotal</span>
          <span class="text-sm font-medium text-gray-800">₱ {{ number_format($subtotal, 2) }}</span>
        </div>

        <!-- Shipping Fee -->
        <div class="flex justify-between">
          <span class="text-sm text-gray-600">Shipping Fee</span>
          <span class="text-sm font-medium text-gray-800">
            @if ($shippingFee == 0)
              <span class="text-green-600 font-semibold">FREE</span>
            @else
              ₱ {{ number_format($shippingFee, 2) }}
            @endif
          </span>
        </div>

        <hr>

        <!-- Total -->
        <div class="flex justify-between text-lg font-semibold text-[#4B433C]">
          <span>Total</span>
          <span>₱ {{ number_format($total, 2) }}</span>
        </div>

        <!-- Shipping Note -->
        <div class="text-sm text-gray-500 mb-2">
          <span class="italic">Free shipping for orders above ₱1000!</span>
        </div>

        <!-- Checkout Button -->
        <button
          class="w-full bg-[#4B433C] hover:bg-[#3a322d] text-white font-medium py-2 rounded-md shadow transition duration-200">
          Proceed to Checkout
        </button>


      </div>
    </div>
  </div>
</x-app-layout>
