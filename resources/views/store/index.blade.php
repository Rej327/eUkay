<h2 class="text-3xl font-bold text-[#4B433C] mb-6">Manage Products</h2>

<a href="{{ route('manage-products.create') }}"
   class="inline-block mb-6 bg-[#4B433C] hover:bg-[#3a322d] text-white font-medium px-5 py-2 rounded-md shadow transition duration-200">
  + Add Product
</a>

<div class="overflow-x-auto bg-white rounded-lg shadow-md">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-[#f3f1ef] text-[#4B433C] text-sm uppercase font-semibold">
      <tr>
        <th class="px-6 py-4 text-left">Name</th>
        <th class="px-6 py-4 text-left">Price</th>
        <th class="px-6 py-4 text-left">Stock</th>
        <th class="px-6 py-4 text-left">Actions</th>
      </tr>
    </thead>

    <tbody class="text-gray-700 divide-y divide-gray-100">
      @forelse ($products as $product)
        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
          <td class="px-6 py-4">{{ $product->name }}</td>
          <td class="px-6 py-4">${{ number_format($product->price, 2) }}</td>
          <td class="px-6 py-4">{{ $product->stock }}</td>
          <td class="px-6 py-4">
            <div class="flex gap-4">
              <a href="{{ route('manage-products.edit', $product) }}"
                 class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">Edit</a>

              <form method="POST" action="{{ route('manage-products.destroy', $product) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Are you sure you want to delete this product?')"
                        class="text-red-600 hover:text-red-800 text-sm font-medium transition">
                  Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-6 py-6 text-center text-gray-500 text-sm">No products available.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
