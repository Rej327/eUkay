<x-app-layout>
  <div class="bg-[#a18c7d] text-sm w-full flex items-center justify-center">
    <p class="py-1 text-[#251808]">Free sheeping on orders above ₱1000.00</p>
  </div>



  @if ($category)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      {{ __('This is :category page', ['category' => ucfirst($category)]) }}
    </div>
  @else
    @include('.sections.home.main')
  @endif


</x-app-layout>
