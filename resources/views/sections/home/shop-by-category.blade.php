<div class="mt-20 mb-10">
  <h3 class="text-center uppercase text-4xl md:text-6xl">Shop by category</h3>
  <!-- Category Grid -->
  <div class="mt-20 flex flex-wrap items-center justify-center gap-6 w-full mx-auto px-4">

    <!-- Tshirts -->
    <a href="{{ route('home', ['category' => 't-shirt']) }}"
      class="group flex flex-col items-center {{ request('category') === 'tshirt' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="relative w-full md:w-[20rem] aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/tshirt.jpg') }}" alt="T-Shirts"
          class="w-full h-full object-cover group-hover:scale-125 duration-300 transition-transform" />
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">T-Shirts</p>
    </a>

    <!-- Jackets -->
    <a href="{{ route('home', ['category' => 'jackets']) }}"
      class="group flex flex-col items-center {{ request('category') === 'jackets' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="relative w-full md:w-[20rem] aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/jacket.webp') }}" alt="Jackets"
          class="w-full h-full object-cover group-hover:scale-125 duration-300 transition-transform" />
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Jackets</p>
    </a>

    <!-- Shorts -->
    <a href="{{ route('home', ['category' => 'shorts']) }}"
      class="group flex flex-col items-center {{ request('category') === 'shorts' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="relative w-full md:w-[20rem] aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/shorts.avif') }}" alt="Shorts"
          class="w-full h-full object-cover group-hover:scale-125 duration-300 transition-transform" />
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Shorts</p>
    </a>

    <!-- Jeans -->
    <a href="{{ route('home', ['category' => 'pants']) }}"
      class="group flex flex-col items-center {{ request('category') === 'pants' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="relative w-full md:w-[20rem] aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/pants.avif') }}" alt="Pants"
          class="w-full h-full object-cover group-hover:scale-125 duration-300 transition-transform" />
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Pants</p>
    </a>

    <!-- Shoes -->
    <a href="{{ route('home', ['category' => 'shoes']) }}"
      class="group flex flex-col items-center {{ request('category') === 'shoes' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="relative w-full md:w-[20rem] aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/shoes.jpg') }}" alt="Shoes"
          class="w-full h-full object-cover group-hover:scale-125 duration-300 transition-transform" />
        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Shoes</p>
    </a>

  </div>
</div>
