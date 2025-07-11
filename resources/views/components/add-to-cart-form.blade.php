@if (in_array($product->id, $cartItemProductIds ?? []))
  <button disabled
    class="w-full text-center justify-center px-4 py-2 bg-gray-400 text-white  border border-transparent rounded-md font-semibold text-xs inline-flex items-center gap-2 uppercase tracking-widest  cursor-not-allowed">
    Added
  </button>
@else
  <form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <x-primary-button class="w-full flex justify-center items-center">
      Add to Cart
    </x-primary-button>
  </form>
@endif
