<x-app-layout>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-bold text-[#4B433C] mb-6">Manage Products</h2>

      <a href="{{ route('manage-products.create') }}"
        class="inline-block mb-6 bg-[#4B433C] hover:bg-[#3a322d] text-white font-medium px-5 py-2 rounded-md shadow transition duration-200">
        + Add Product
      </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#f3f1ef] text-[#4B433C] text-sm uppercase font-semibold">
          <tr>
            <th class="px-4 py-3 text-left w-24">Image</th>
            <th class="px-4 py-3 text-left">Name</th>
            <th class="px-4 py-3 text-left">Price</th>
            <th class="px-4 py-3 text-left">Stock</th>
            <th class="px-4 py-3 text-left">Actions</th>
          </tr>
        </thead>

        <tbody class="text-gray-700 divide-y divide-gray-100">
          @forelse ($products as $product)
            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
              {{-- Image --}}
              <td class="px-4 py-3 w-20">
                @php $image = $product->images->first(); @endphp
                @if ($image)
                  <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover rounded-md border shadow-sm" />
                @else
                  <div
                    class="w-5 h-5 flex items-center justify-center text-xs text-gray-400 border rounded-md bg-gray-100">
                    No Image
                  </div>
                @endif
              </td>

              {{-- Name --}}
              <td class="px-4 py-3 font-medium">{{ $product->name }}</td>

              {{-- Price --}}
              <td class="px-4 py-3">${{ number_format($product->price, 2) }}</td>

              {{-- Stock --}}
              <td class="px-4 py-3">{{ $product->stock }}</td>

              {{-- Actions --}}
              <td class="px-4 py-3">
                <div class="flex gap-3 items-center">
                  <a href="{{ route('manage-products.edit', $product) }}"
                    class="text-blue-600 hover:underline text-sm font-medium">Edit</a>

                  <form method="POST" action="{{ route('manage-products.destroy', $product) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')"
                      class="text-red-600 hover:underline text-sm font-medium">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-gray-500 text-sm">No products available.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>
