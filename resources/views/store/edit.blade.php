<x-app-layout>
  <h2 class="text-3xl text-center font-bold text-[#4B433C] my-6">
    {{ isset($product) ? 'Edit Product' : 'Add Product' }}
  </h2>

  <form method="POST"
        action="{{ isset($product) ? route('manage-products.update', $product) : route('manage-products.store') }}"
        enctype="multipart/form-data"
        class="max-w-xl mx-auto">
    @csrf
    @if(isset($product))
      @method('PUT')
    @endif

    <!-- Product Name -->
    <input name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="Product Name"
           class="border border-gray-300 p-2 w-full mt-4 rounded" required />

    <!-- Price -->
    <input name="price" type="number" step="0.01" placeholder="Price"
           value="{{ old('price', $product->price ?? '') }}"
           class="border border-gray-300 p-2 w-full mt-4 rounded" required />

    <!-- Stock -->
    <input name="stock" type="number" placeholder="Stock"
           value="{{ old('stock', $product->stock ?? '') }}"
           class="border border-gray-300 p-2 w-full mt-4 rounded" required />

    <!-- Description -->
    <textarea name="description" placeholder="Description"
              class="border border-gray-300 p-2 w-full mt-4 rounded resize-none" rows="4" required>{{ old('description', $product->description ?? '') }}</textarea>

    <!-- Category Dropdown -->
    <select name="category_id" class="border border-gray-300 p-2 w-full mt-4 rounded" required>
      <option value="">Select Category</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}"
                {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>

    <!-- Product Image Upload -->
    <label class="block mt-4 mb-1 text-sm font-medium text-gray-700">Product Image</label>
    <input type="file" name="image" accept="image/*"
           class="border border-gray-300 p-2 w-full rounded"
           {{ isset($product) ? '' : 'required' }} />

    @if(isset($product) && $product->images->first())
      <div class="mt-4">
        <p class="text-sm mb-2">Current Image:</p>
        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
             class="w-32 h-32 object-cover rounded border" alt="Current Product Image">
      </div>
    @endif

    <!-- Submit Button -->
    <div class="mt-6 flex justify-end space-x-4">
      <x-secondary-button onclick="window.history.back()">
        Cancel
      </x-secondary-button>

      <x-primary-button type="submit">
        {{ isset($product) ? 'Update Product' : 'Save Product' }}
      </x-primary-button>
    </div>
  </form>
</x-app-layout>
