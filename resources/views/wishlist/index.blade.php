<x-app-layout>
  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#4B433C]">Your Wishlist</h2>

      @if ($wishlistItems->isNotEmpty())
        <div class="flex gap-2 flex-wrap">
          <!-- Add All to Cart -->
          {{-- <form action="{{ route('wishlist.addAllToCart') }}" method="POST">
            @csrf
            <x-primary-button>Add All to Cart</x-primary-button>
          </form> --}}

          <!-- Clear Wishlist -->
          <form action="{{ route('wishlist.clear') }}" method="POST" onsubmit="return confirm('Clear entire wishlist?');">
            @csrf
            @method('DELETE')
            <x-danger-button>Clear Wishlist</x-danger-button>
          </form>
        </div>
      @endif
    </div>

    @if (session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if ($wishlistItems->isEmpty())
      <p class="text-sm font-semibold text-gray-500 mt-10 text-center mx-auto w-fit">Your wishlist is empty.</p>
    @else
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-[#f3f1ef] text-[#4B433C]">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Product</th>
              <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Price</th>
              <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach ($wishlistItems as $item)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-4">
                    @php
                      $image = $item->product->images->first()?->image_path;
                    @endphp
                    <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/80' }}"
                      alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded border" />
                    <span class="font-medium">{{ $item->product->name }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 font-medium whitespace-nowrap">
                  ₱ {{ number_format($item->product->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap max-w-xs">
                  <div class="flex flex-col md:flex-row flex-wrap gap-2">
                    <!-- View Product -->
                    <a href="{{ route('product.show', $item->product->id) }}">
                      <x-secondary-button class="w-full md:w-28 justify-center">View</x-secondary-button>
                    </a>

                    <!-- Add to Cart -->
                    @if (in_array($item->product->id, $cartProductIds ?? []))
                      <button disabled
                        class="w-full md:w-28 px-4 py-2 rounded bg-gray-300 text-white font-medium text-sm cursor-not-allowed">
                        Added
                      </button>
                    @else
                      <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                        @csrf
                        <x-primary-button class="w-full md:w-28 justify-center">Add to Cart</x-primary-button>
                      </form>
                    @endif

                    <!-- Remove from Wishlist -->
                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST"
                      onsubmit="return confirm('Remove this item from wishlist?');">
                      @csrf
                      @method('DELETE')
                      <x-danger-button class="w-full md:w-28 justify-center">Remove</x-danger-button>
                    </form>
                  </div>
                </td>

              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</x-app-layout>
