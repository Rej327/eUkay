@php
  $product = json_decode(
      json_encode([
          'name' => 'Mock T-Shirt',
          'category' => 'Shirts',
          'price' => 499.0,
          'stock' => 25,
          'description' => 'A stylish mock T-shirt made with premium cotton. Perfect for casual and semi-formal wear.',
          'image' => '/products/1751429048_6864afb82fe32.jpg',
      ]),
  );

  $relatedProducts = collect([
      [
          'name' => 'Mock Shirt 1',
          'price' => 549.0,
          'image' => '/products/1751429048_6864afb82fe32.jpg',
      ],
      [
          'name' => 'Mock Shirt 2',
          'price' => 599.0,
          'image' => '/products/1751429048_6864afb82fe32.jpg',
      ],
      [
          'name' => 'Mock Shirt 3',
          'price' => 649.0,
          'image' => '/products/1751429048_6864afb82fe32.jpg',
      ],
  ]);
@endphp

<x-app-layout>
  <div class="max-w-6xl mx-auto px-4 py-10">

    <!-- Product Detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
      <div>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
          class="w-full h-auto rounded shadow-md object-cover">
      </div>
      <div>
        <h1 class="text-3xl font-bold text-[#4B433C] mb-2">{{ $product->name }}</h1>
        <p class="text-sm text-gray-600 mb-4">Category: {{ $product->category }}</p>
        <p class="text-xl text-[#4B433C] font-semibold mb-2">₱{{ number_format($product->price, 2) }}</p>
        <p class="text-sm text-gray-500 mb-6">Stock: {{ $product->stock }}</p>
        <p class="text-gray-700 mb-8">{{ $product->description }}</p>

        <div class="flex flex-wrap gap-4">
          <button class="px-6 py-2 bg-[#4B433C] text-white rounded inline-flex items-center gap-2">
            <x-heroicon-o-shopping-cart class="w-5 h-5" />
            Add to Cart
          </button>

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
        @foreach ($relatedProducts as $related)
          <div class="flex flex-wrap items-center justify-start gap-4 mt-5">
            <div class="group w-[20rem] shadow-sm p-4">
              <div class="relative w-full bg-gray-100 overflow-hidden rounded-lg">
                <img src="{{ asset('storage/' . $related['image']) }}" alt="{{ $related['name'] }}"
                  class="w-full h-auto rounded-lg group-hover:scale-125 duration-300" />
                <x-eva-heart
                  class="absolute top-2 right-2 w-6 primary-text-color opacity-50 hover:opacity-100 duration-300" />
              </div>
              <div class="space-y-0 mt-2 px-2 text-center">
                <x-product-details>{{ $related['name'] }}</x-product-details>
                <x-product-details>₱{{ number_format($related['price'], 2) }}</x-product-details>
              </div>
              <div class="px-2 flex items-center justify-center gap-4 mt-2">
                <x-secondary-button class="w-full flex justify-center items-center">
                  <a href="{{ route('product.show', ['product' => 1]) }}" class>Details</a>
                </x-secondary-button>
                <x-primary-button class="w-full flex justify-center items-center">
                  <a href="" clas>Add to Cart</a>
                </x-primary-button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  </div>
</x-app-layout>
