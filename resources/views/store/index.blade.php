<x-app-layout>
  <div x-data="productModal()" x-init="@if (session('success')) showToast(@js(session('success')));
  @elseif(session('error'))
    showToast(@js(session('error')), 'error'); @endif
  
  @if ($errors->any()) openServerErrorModal(window.oldValues, window.validationErrors); @endif" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 relative">

    <!-- Toast -->
    <template x-if="toast.show">
      <div x-transition class="fixed top-6 right-6 text-white px-4 py-2 rounded shadow"
        :class="toast.type === 'error' ? 'bg-red-500' : 'bg-green-500'" x-text="toast.message">
      </div>
    </template>


    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-3xl font-bold text-[#4B433C]">Manage Products</h2>
      <div class="flex items-center gap-3 w-full md:w-auto">
        <x-text-input type="text" placeholder="Search product name..." x-model.debounce.1000ms="search"
          class="border border-gray-300 rounded px-3 py-2 w-full md:w-64" />
        <button @click="openAddModal"
          class="bg-[#4B433C] hover:bg-[#3a322d] text-white font-medium px-5 py-2 rounded-md shadow transition duration-200">
          + Add Product
        </button>
      </div>

    </div>

    <!-- Product Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
      <table class="min-w-full divide-y divide-gray-200">

        <thead class="bg-[#f3f1ef] text-[#4B433C] text-sm uppercase font-semibold">
          <tr>
            <th class="px-4 py-3 text-left w-24">Image</th>
            <th class="px-4 py-3 text-left cursor-pointer" @click="sort('name')">
              Name
              <span x-show="sortBy === 'name'" x-text="sortDir === 'asc' ? '▲' : '▼'"></span>
            </th>
            <th class="px-4 py-3 text-left cursor-pointer" @click="sort('price')">
              Price
              <span x-show="sortBy === 'price'" x-text="sortDir === 'asc' ? '▲' : '▼'"></span>
            </th>
            <th class="px-4 py-3 text-left cursor-pointer" @click="sort('updated_at')">
              Last Modified
              <span x-show="sortBy === 'updated_at'" x-text="sortDir === 'asc' ? '▲' : '▼'"></span>
            </th>
            <th class="px-4 py-3 text-left">Actions</th>
          </tr>
        </thead>

        <tbody class="text-gray-700 divide-y divide-gray-100">
          <!-- Loop through products -->
          <template x-if="sortedProducts.length">
            <template x-for="product in sortedProducts" :key="product.id">
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3">
                  <template x-if="product.images && product.images.length">
                    <img :src="`/storage/${product.images[0].image_path}`" class="w-16 h-16 object-cover rounded" />
                  </template>
                  <template x-if="!product.images || !product.images.length">
                    <div
                      class="w-16 h-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 border rounded">
                      No Image
                    </div>
                  </template>
                </td>
                <td class="px-4 py-3 font-medium" x-text="product.name"></td>
                <td class="px-4 py-3" x-text="`₱ ${parseFloat(product.price).toFixed(2)}`"></td>
             
                <td class="px-4 py-3"
                  x-text="new Date(product.updated_at).toLocaleString('en-US', { 
                            month: 'short', 
                            day: 'numeric', 
                            year: 'numeric', 
                            hour: 'numeric', 
                            minute: '2-digit', 
                            hour12: true 
                        })">
                </td>

                <td class="px-4 py-3">
                  <div class="flex gap-3 items-center">
                    <button @click="openEditModal(product)"
                      class="text-blue-600 hover:underline text-sm font-medium">Edit</button>

                    <button @click="confirmDelete(product.id)"
                      class="text-red-600 hover:underline text-sm font-medium">Delete</button>
                  </div>
                </td>
              </tr>
            </template>
          </template>

          <!-- Show this when no products -->
          <template x-if="!sortedProducts.length">
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-gray-500 text-sm">
                No products available.
              </td>
            </tr>
          </template>
        </tbody>

      </table>
    </div>

    <!-- Add/Edit Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
      <div @click.outside="closeModal" class="bg-white w-full max-w-xl rounded-lg shadow-lg p-6 m-6 md:m-0 relative">
        <h2 class="text-xl font-bold text-[#4B433C] mb-4" x-text="isEdit ? 'Edit Product' : 'Add Product'"></h2>

        <form :action="isEdit ? routeUpdate : routeStore" method="POST" enctype="multipart/form-data">
          <template x-if="isEdit">
            <input type="hidden" name="_method" value="PUT">
          </template>
          @csrf

          <!-- Product Name -->
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="name" :value="__('Product Name')" />
              <template x-if="errors.name && errors.name.length">
                <p class="text-sm text-red-600 font-semibold" x-text="errors.name[0]"></p>
              </template>
            </div>
            <x-text-input id="name" name="name" type="text" x-model="form.name" class="block mt-1 w-full" />

          </div>

          <!-- Price -->
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="price" :value="__('Price')" />
              <template x-if="errors.price && errors.price.length">
                <p class="text-sm text-red-600 font-semibold" x-text="errors.price[0]"></p>
              </template>
            </div>
            <x-text-input id="price" name="price" type="number" step="0.01" x-model="form.price"
              class="block mt-1 w-full" />
          </div>

          <!-- Description -->
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="description" :value="__('Description')" />
              <template x-if="errors.description && errors.description.length">
                <p class="text-sm text-red-600 font-semibold" x-text="errors.description[0]"></p>
              </template>
            </div>
            <textarea id="description" name="description" x-model="form.description"
              class="block mt-1 w-full border-gray-300 focus:border-[#4b433c] focus:ring-[#4b433c] rounded-md shadow-sm resize-none"
              rows="3"></textarea>
          </div>

          <!-- Category -->
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="category_id" :value="__('Category')" />
              <template x-if="errors.category_id && errors.category_id.length">
                <p class="text-sm text-red-600 font-semibold" x-text="errors.category_id[0]"></p>
              </template>
            </div>
            <select id="category_id" name="category_id" x-model="form.category_id"
              class="block mt-1 w-full border-gray-300 focus:border-[#4b433c] focus:ring-[#4b433c] rounded-md shadow-sm">
              <option value="">Select Category</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Image Upload -->
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="image" :value="__('Product Image')" />
              <template x-if="errors.image && errors.image.length">
                <p class="text-sm text-red-600 font-semibold" x-text="errors.image[0]"></p>
              </template>
            </div>
            <input id="image" name="image" type="file" accept="image/*"
              class="block mt-1 w-full border-gray-300 focus:border-[#4b433c] focus:ring-[#4b433c] shadow-sm" />
          </div>


          <!-- Show current image if editing -->
          <template x-if="isEdit && form.image_url">
            <div class="mt-4">
              <p class="text-sm mb-2">Current Image:</p>
              <img :src="form.image_url" class="w-32 h-32 object-cover rounded border" alt="Current Product Image">
            </div>
          </template>

          <!-- Actions -->
          <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="closeModal"
              class="px-4 py-2 rounded border text-[#4B433C] border-[#4B433C] hover:bg-gray-100 transition">
              Cancel
            </button>
            <button type="submit" class="px-4 py-2 rounded bg-[#4B433C] text-white hover:bg-[#3a322d] transition">
              <span x-text="isEdit ? 'Update' : 'Save Product'"></span>
            </button>
          </div>
        </form>
      </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div x-show="deleteConfirm.show" x-cloak class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 shadow-lg max-w-sm w-full ">
        <h2 class="text-lg font-semibold text-[#4B433C] mb-4">Confirm Deletion</h2>
        <p class="mb-4 text-sm text-gray-600">Are you sure you want to delete this product? This action cannot be
          undone.</p>
        <form :action="`/manage-products/${deleteConfirm.id}`" method="POST">
          @csrf
          @method('DELETE')
          <div class="flex justify-end gap-3">
            <button type="button" @click="deleteConfirm.show = false"
              class="px-4 py-2 border border-gray-400 rounded text-gray-700 hover:bg-gray-100">
              Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
              Delete
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    window.initialProducts = @json($products);
    window.routeStore = @json(route('manage-products.store'));
  </script>

  @if ($errors->any())
    <script>
      window.validationErrors = @json($errors->messages());
      window.oldValues = @json(old());
    </script>
  @endif


</x-app-layout>
