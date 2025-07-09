<x-app-layout>
  <div class="bg-[#a18c7d] text-sm w-full flex items-center justify-center">
    <p class="py-1 text-[#251808]">Free shipping on orders above ₱1000.00</p>
  </div>

  @if (request()->has('category'))
    @include('category.index', ['category' => $category])
  @else
    @include('sections.home.main')
  @endif
</x-app-layout>
