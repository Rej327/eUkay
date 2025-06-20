<footer class="bg-[#4B433C] text-[#DDD2CB] mt-10 pb-8 px-6 md:px-20">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:flex-wrap pt-16 justify-between space-y-10 md:space-y-0">

    <!-- Brand -->
    <div>
      <img src="{{ asset('images/eUkayLogo.png') }}" alt="eUkay Logo" class="w-36">
      <p class="mt-4 text-sm leading-relaxed text-[#DDD2CB] max-w-[20rem]">Timeless fashion, handpicked for you. Discover, shop, and
        elevate your style daily.</p>
    </div>

    <!-- Shop Links -->
    <div class="w-fit">
      <h3 class="uppercase font-semibold mb-4 text-[#DDD2CB]">Shop</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('home', ['category' => 't-shirt']) }}" class="hover:underline underline-offset-4">T-Shirts</a></li>
        <li><a href="{{ route('home', ['category' => 'jackets']) }}" class="hover:underline underline-offset-4">Jackets</a></li>
        <li><a href="{{ route('home', ['category' => 'shorts']) }}" class="hover:underline underline-offset-4">Shorts</a></li>
        <li><a href="{{ route('home', ['category' => 'pants']) }}" class="hover:underline underline-offset-4">Pants</a></li>
        <li><a href="{{ route('home', ['category' => 'shoes']) }}" class="hover:underline underline-offset-4">Shoes</a></li>
      </ul>
    </div>

    <!-- Help -->
    <div class="w-fit">
      <h3 class="uppercase font-semibold mb-4 text-[#DDD2CB]">Help</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="#" class="hover:underline underline-offset-4">Shipping Info</a></li>
        <li><a href="#" class="hover:underline underline-offset-4">Returns & Refunds</a></li>
        <li><a href="#" class="hover:underline underline-offset-4">Track Order</a></li>
        <li><a href="#" class="hover:underline underline-offset-4">FAQs</a></li>
      </ul>
    </div>

    <!-- Follow / Newsletter -->
    <div>
      <h3 class="uppercase font-semibold mb-4 text-[#DDD2CB]">Payment Methods</h3>
      <div class="space-y-2">
        <img src="{{ asset('images/payments/gcash.png') }}" alt="G-Cash" class="w-36">
        <img src="{{ asset('images/payments/cod.png') }}" alt="Cash On Delivery" class="w-36">
      </div>
    </div>
  </div>

  <div class="mt-12 border-t border-[#DDD2CB]/30 pt-6 text-sm text-center">
    &copy; {{ date('Y') }} eUkay. All rights reserved.
  </div>
</footer>
