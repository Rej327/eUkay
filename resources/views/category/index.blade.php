<div class="bg-[#E4DBD5] text-center py-10">
  <h1 class="text-2xl md:text-4xl font-semibold uppercase tracking-wide text-[#4B433C]">
    {{ ucfirst($category) }} Collection
  </h1>
  <p class="text-sm text-[#4B433C] mt-2 tracking-wide">Discover the latest styles and trends in {{ $category }}</p>
</div>

<div class="px-4 my-10">
  @php
    $selectedSort = request('sort');
    $selectedCategory = request('category');

    $sortLabel = match ($selectedSort) {
        'price_asc' => 'Price Low to High',
        'price_desc' => 'Price High to Low',
        'newest' => 'Newest',
        default => null,
    };
  @endphp

  <!-- Sort Form -->
  <div class="flex justify-between items-center">
    <!-- Left: Filter Dropdown + Label + Reset -->
    <div class="flex items-center w-fit pb-1 gap-3">
      <!-- Filter Dropdown -->
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" type="button"
          class="flex items-center gap-2 text-sm font-semibold text-[#4B433C] cursor-pointer focus:outline-none">
          <x-letsicon-filter class="w-4 h-4 text-[#4b3c3c]" />
          FILTER
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.away="open = false" x-transition
          class="absolute left-0 mt-2 bg-white border border-gray-300 shadow-lg rounded-md w-48 z-50">
          <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc', 'category' => $selectedCategory]) }}"
            class="block px-4 py-2 text-sm text-[#4B433C] hover:bg-gray-100">Price High</a>
          <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc', 'category' => $selectedCategory]) }}"
            class="block px-4 py-2 text-sm text-[#4B433C] hover:bg-gray-100">Price Low</a>
          <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest', 'category' => $selectedCategory]) }}"
            class="block px-4 py-2 text-sm text-[#4B433C] hover:bg-gray-100">Newest</a>
        </div>
      </div>

      <!-- Sort Label -->
      @if ($sortLabel)
        <span class="text-[#4B433C] text-sm font-medium tracking-wide">&gt; {{ $sortLabel }}</span>
      @endif

      <!-- Reset Button -->
      @if ($selectedSort)
        <a href="{{ request()->fullUrlWithQuery(['sort' => null, 'category' => $selectedCategory]) }}"
          class="text-sm text-[#4B433C] border border-[#4B433C] px-2 py-1 rounded hover:bg-[#4b433c15] transition">
          Reset
        </a>
      @endif
    </div>

    <!-- Right: Product Count -->
    {{-- <p class="text-sm text-[#4B433C]">{{ $products->count() }} products</p> --}}
    <p class="text-sm text-[#4B433C]">300 products</p>
  </div>



  <div class="flex flex-wrap items-center justify-start gap-4 mt-5">
    <div class="group w-[20rem] shadow-sm p-4">
      <div class="relative w-full bg-gray-100 overflow-hidden rounded-lg">
        <img src="{{ asset('images/top/dummy.jpg') }}" alt="Top Picks"
          class="w-full h-auto rounded-lg group-hover:scale-125 duration-300" />
        <x-eva-heart class="absolute top-2 right-2 w-6 primary-text-color opacity-50 hover:opacity-100 duration-300" />
      </div>
      <div class="space-y-0 mt-2 px-2 text-center">
        <x-product-details>Formal Attire Coat</x-product-details>
        <x-product-details>Size: Medium</x-product-details>
        <x-product-details>Price: $49.99</x-product-details>
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

  <!-- JS to Submit and Reset -->
  <!-- JS -->
  <script>
    function submitAndReset(select) {
      if (select.value) {
        document.getElementById('sortForm').submit();
        setTimeout(() => {
          select.value = '';
        }, 100);
      }
    }
  </script>
