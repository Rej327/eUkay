<x-app-layout>
  <div class="bg-[#d4c4b2] text-sm w-full flex items-center justify-center">
    <p class="py-1 text-[#251808]">Free sheeping on orders above ₱1000.00</p>
  </div>


  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if ($category)
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        {{ __('This is :category page', ['category' => ucfirst($category)]) }}
      </div>
    @else
      @include('.sections.home.hero')
    @endif

  </div>
</x-app-layout>
