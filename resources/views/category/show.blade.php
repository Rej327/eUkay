<x-app-layout>
  <div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Product Detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
      <div>
        @if ($product->images->count())
          <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
            class="w-full h-auto rounded shadow-md object-cover">
        @else
          <div class="w-full h-[300px] flex items-center justify-center bg-gray-100 text-gray-500 border rounded">
            No Image Available
          </div>
        @endif
      </div>

      <div>
        <h1 class="text-3xl font-bold text-[#4B433C] mb-2">{{ $product->name }}</h1>
        <p class="text-sm text-gray-600 mb-4">
          Category: {{ $product->category->name ?? 'Uncategorized' }}
        </p>
        <p class="text-xl text-[#4B433C] font-semibold mb-2">
          ₱{{ number_format($product->price, 2) }}
        </p>
        <p class="text-sm text-gray-500 mb-6">Description: {{ $product->description }}</p>

        <div class="flex flex-wrap gap-4">
          @if (in_array($product->id, $cartItemProductIds ?? []))
            <button disabled
              class="px-6 py-2 bg-gray-400 text-white rounded inline-flex items-center gap-2 cursor-not-allowed">
              <x-heroicon-o-check class="w-5 h-5" />
              Added
            </button>
          @else
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
              @csrf
              <button
                class="px-6 py-2 bg-[#4B433C] text-white rounded inline-flex items-center gap-2 hover:bg-[#3a322d] transition">
                <x-heroicon-o-shopping-cart class="w-5 h-5" />
                Add to Cart
              </button>
            </form>
          @endif

          <button class="px-6 py-2 border border-[#4B433C] text-[#4B433C] rounded inline-flex items-center gap-2">
            <x-heroicon-o-heart class="w-5 h-5" />
            Add to Wishlist
          </button>

          <button class="px-6 py-2 bg-green-600 text-white rounded inline-flex items-center gap-2">
            <x-pepicon-peso class="w-4 h-4" />
            Buy Now
          </button>
        </div>
      </div>
    </div>

    <!-- Related Products -->
    <div>
      <h2 class="text-2xl font-bold text-[#4B433C] mb-6">You May Also Like</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($relatedProducts as $related)
          <div class="group w-[20rem] shadow-sm p-4">
            <div class="relative w-full bg-gray-100 overflow-hidden rounded-lg">
              @if ($related->images->count())
                <img src="{{ asset('storage/' . $related->images->first()->image_path) }}" alt="{{ $related->name }}"
                  class="w-full h-[20rem] rounded-lg group-hover:scale-125 duration-300" />
              @else
                <div class="w-full h-[250px] flex items-center justify-center text-gray-500 bg-white border rounded-lg">
                  No Image
                </div>
              @endif
              <x-eva-heart
                class="absolute top-2 right-2 w-6 primary-text-color opacity-50 hover:opacity-100 duration-300" />
            </div>
            <div class="space-y-0 mt-2 px-2 text-center">
              <x-product-details>{{ $related->name }}</x-product-details>
              <x-product-details>₱{{ number_format($related->price, 2) }}</x-product-details>
            </div>
            <div class="px-2 flex flex-col items-center justify-center gap-2 mt-2">
              <x-secondary-button class="w-full flex justify-center items-center">
                <a href="{{ route('product.show', $related->id) }}">Details</a>
              </x-secondary-button>
              @include('components.add-to-cart-form', ['product' => $product])
            </div>
          </div>
        @empty
          <p class="text-sm text-gray-500">No related products found.</p>
        @endforelse
      </div>
    </div>

  </div>
</x-app-layout>
