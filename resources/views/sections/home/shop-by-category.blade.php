<div class="mt-20 mb-10">
  <h3 class="text-center text-3xl md:text-6xl">Shop by category</h3>

  <!-- Category Grid -->
  <div class="mt-20 grid grid-cols-2 md:grid-cols-5 gap-6 max-w-6xl mx-auto px-4">
    
    <!-- Tshirts -->
    <a href="{{ route('home', ['category' => 't-shirt']) }}"
       class="flex flex-col items-center {{ request('category') === 'tshirt' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/tshirt.jpg') }}" alt="T-Shirts" class="w-full h-full object-cover" />
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">T-Shirts</p>
    </a>

    <!-- Jackets -->
    <a href="{{ route('home', ['category' => 'jackets']) }}"
       class="flex flex-col items-center {{ request('category') === 'jackets' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/jackets.jpg') }}" alt="Jackets" class="w-full h-full object-cover" />
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Jackets</p>
    </a>

    <!-- Shorts -->
    <a href="{{ route('home', ['category' => 'shorts']) }}"
       class="flex flex-col items-center {{ request('category') === 'shorts' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/shorts.jpg') }}" alt="Shorts" class="w-full h-full object-cover" />
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Shorts</p>
    </a>

    <!-- Jeans -->
    <a href="{{ route('home', ['category' => 'jeans']) }}"
       class="flex flex-col items-center {{ request('category') === 'jeans' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/jeans.jpg') }}" alt="Jeans" class="w-full h-full object-cover" />
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Jeans</p>
    </a>

    <!-- Shoes -->
    <a href="{{ route('home', ['category' => 'shoes']) }}"
       class="flex flex-col items-center {{ request('category') === 'shoes' ? 'border-2 border-[#4B433C] rounded' : '' }}">
      <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded shadow-md">
        <img src="{{ asset('images/categories/shoes.jpg') }}" alt="Shoes" class="w-full h-full object-cover" />
      </div>
      <p class="uppercase mt-3 text-lg font-semibold text-[#4B433C]">Shoes</p>
    </a>
  </div>
</div>
