<div class="px-4 my-10">
  <h3 class="text-4xl md:text-6xl uppercase text-[#4B433C] tracking-wide text-center mb-10">New Arrival</h3>
  <div x-data="{
      scrollAmount: 300,
      scrollLeft() { $refs.carousel.scrollBy({ left: -this.scrollAmount, behavior: 'smooth' }); },
      scrollRight() { $refs.carousel.scrollBy({ left: this.scrollAmount, behavior: 'smooth' }); }
  }" class="relative">
    <!-- Scrollable Products -->
    <div x-ref="carousel" class="flex gap-4 overflow-x-auto no-scrollbar scroll-smooth pb-4">
      @forelse ($newArrivals as $product)
        <div class="group w-[20rem] shadow-md p-4 shrink-0">
          <div class="relative w-full bg-gray-100 overflow-hidden rounded-lg">
            @if ($product->images->count())
              <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                class="w-full h-[20rem] rounded-lg group-hover:scale-125 duration-300" />
            @else
              <div class="w-full h-[250px] flex items-center justify-center text-gray-500 bg-white border rounded-lg">
                No Image
              </div>
            @endif

            @if (in_array($product->id, $wishlistProductIds ?? []))
              <!-- Already in wishlist -->
              <div class="absolute top-2 right-2" title="Already in Wishlist">
                <x-eva-heart class="w-8 text-red-500 opacity-100" />
              </div>
            @else
              <!-- Not in wishlist, allow add -->
              <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="absolute top-2 right-2">
                @csrf
                <button type="submit" title="Add to Wishlist">
                  <x-eva-heart class="w-8 primary-text-color opacity-50 hover:opacity-100 duration-300" />
                </button>
              </form>
            @endif
          </div>

          <div class="space-y-0 mt-2 px-2 text-center">
            <x-product-details>{{ $product->name }}</x-product-details>
            <x-product-details>{{$product->description}}</x-product-details>
            <x-product-details>₱{{ number_format($product->price, 2) }}</x-product-details>
          </div>

          <div class="px-2 flex flex-col items-center justify-center gap-2 mt-2">
            <x-secondary-button class="w-full flex justify-center items-center">
              <a href="{{ route('product.show', $product->id) }}">Details</a>
            </x-secondary-button>
            <div class="w-full">
              @include('components.add-to-cart-form', [
                  'product' => $product,
                  'cartItemProductIds' => $cartItemProductIds ?? [],
              ])
            </div>
          </div>
        </div>
      @empty
        <p class="text-sm font-semibold text-gray-500 mt-10 text-center mx-auto w-fit">No new arrivals at the moment.
        </p>
      @endforelse
    </div>

    <!-- Bottom Navigation Buttons -->
    @if ($newArrivals->isNotEmpty())
      <div class="flex justify-center gap-4 mt-6">
        <button @click="scrollLeft()"
          class="bg-[#4B433C] text-white px-4 py-2 rounded-full hover:bg-[#3a322c] transition">
          &larr; Prev
        </button>
        <button @click="scrollRight()"
          class="bg-[#4B433C] text-white px-4 py-2 rounded-full hover:bg-[#3a322c] transition">
          Next &rarr;
        </button>
      </div>
    @endif
  </div>
</div>
