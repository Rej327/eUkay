<x-app-layout>
  @if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#4B433C]">Your Cart</h2>
      <form action="{{ route('cart.clear') }}" method="POST"
        onsubmit="return confirm('Are you sure you want to clear the cart?');">
        @csrf
        @method('DELETE')
        <x-danger-button>Clear Cart</x-danger-button>
      </form>

    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#f3f1ef] text-[#4B433C]">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Product</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Price</th>
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

              <td class="px-6 py-4 font-semibold">
                ₱ {{ number_format($item['price'], 2) }}
              </td>
              <td class="px-6 py-4 text-right w-8">
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST"
                  onsubmit="return confirm('Remove this item from cart?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit">
                    <x-fas-delete-left class="w-6 h-6 text-red-600 hover:text-red-800 transition" />
                  </button>
                </form>

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
        <form action="{{ route('checkout') }}" method="POST">
          @csrf
          <input type="hidden" name="amount" value="{{ $total }}">
          <button
            class="w-full bg-[#4B433C] hover:bg-[#3a322d] text-white font-medium py-2 rounded-md shadow transition duration-200">
            Proceed to Checkout with PayMongo
          </button>
        </form>



      </div>
    </div>
  </div>
</x-app-layout>
