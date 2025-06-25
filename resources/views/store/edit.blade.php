<form method="POST" action="{{ route('manage-products.store') }}" enctype="multipart/form-data" class="max-w-xl mx-auto">
  @csrf

  <!-- Product Name -->
  <input name="name" placeholder="Product Name"
    class="border border-gray-300 p-2 w-full mt-4 rounded" required />

  <!-- Price -->
  <input name="price" type="number" step="0.01" placeholder="Price"
    class="border border-gray-300 p-2 w-full mt-4 rounded" required />

  <!-- Stock -->
  <input name="stock" type="number" placeholder="Stock"
    class="border border-gray-300 p-2 w-full mt-4 rounded" required />

  <!-- Description -->
  <textarea name="description" placeholder="Description"
    class="border border-gray-300 p-2 w-full mt-4 rounded resize-none" rows="4" required></textarea>

  <!-- Category Dropdown -->
  <select name="category_id" class="border border-gray-300 p-2 w-full mt-4 rounded" required>
    <option value="">Select Category</option>
    @foreach ($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
  </select>

  <!-- Product Image Upload -->
  <label class="block mt-4 mb-1 text-sm font-medium text-gray-700">Product Image</label>
  <input type="file" name="image" accept="image/*"
    class="border border-gray-300 p-2 w-full rounded" required />

  <!-- Submit Button -->
  <button type="submit" class="bg-green-600 text-white px-4 py-2 mt-6 rounded hover:bg-green-700 transition">
    Save Product
  </button>
</form>
