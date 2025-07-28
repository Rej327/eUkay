<x-app-layout>
  <div x-data="wishlistApp()" x-init="init" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#4B433C]">Your Wishlist</h2>

      @if ($wishlistItems->isNotEmpty())
        <div class="flex gap-2 flex-wrap">
          <form action="{{ route('wishlist.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <x-danger-button>Clear Wishlist</x-danger-button>
          </form>
        </div>
      @endif
    </div>

    @if (session('success'))
      <div x-show="toast.show" x-transition class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow"
        x-text="toast.message"></div>
    @endif


    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[#f3f1ef] text-[#4B433C]">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Product</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Price</th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Actions</th>
          </tr>
        </thead>
        @if ($wishlistItems->isEmpty())
          <tbody>
            <tr>
              <td colspan="3" class="px-6 py-4 text-sm font-semibold text-gray-500 text-center">
                Your wishlist is empty.
              </td>
            </tr>
          </tbody>
        @else
          <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach ($wishlistItems as $item)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-4">
                    @php
                      $image = $item->product->images->first()?->image_path;
                    @endphp
                    <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/80' }}"
                      alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded border" />
                    <span class="font-medium">{{ $item->product->name }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 font-medium whitespace-nowrap">
                  ₱ {{ number_format($item->product->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap max-w-xs">
                  <div class="flex flex-col md:flex-row flex-wrap gap-2">
                    <a href="{{ route('product.show', $item->product->id) }}">
                      <x-secondary-button class="w-full md:w-28 justify-center">View</x-secondary-button>
                    </a>
                    <div class="">
                      @include('components.add-to-cart-form', [
                          'product' => $item->product,
                          'cartItemProductIds' => $cartItemProductIds ?? [],
                      ])
                    </div>

                    <x-danger-button @click="confirmDelete({{ $item->id }})"
                      class="w-full md:w-28 justify-center">Remove</x-danger-button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        @endif

      </table>
    </div>


    <!-- Delete Confirmation Modal -->
    <div x-show="deleteConfirm.show" x-cloak class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold text-[#4B433C] mb-4">Confirm Removing</h2>
        <p class="mb-4 text-sm text-gray-600">Remove this item from wishlist? This action cannot be undone.</p>
        <form :action="'/wishlist/' + deleteConfirm.productId" method="POST">
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

    <!-- Server Error Modal -->
    <div x-show="serverError.show" x-cloak class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold text-[#4B433C] mb-4">Form Errors</h2>
        <ul class="text-sm text-red-600 space-y-2">
          <template x-for="(fieldErrors, fieldName) in serverError.errors" :key="fieldName">
            <li>
              <template x-for="error in fieldErrors" :key="error">
                <div x-text="error"></div>
              </template>
            </li>
          </template>
        </ul>
        <div class="flex justify-end mt-4">
          <button @click="serverError.show = false" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
            Close
          </button>
        </div>
      </div>
    </div>

  </div>
</x-app-layout>

<script>
  function wishlistApp() {
    return {
      deleteConfirm: {
        show: false,
        productId: null
      },
      serverError: {
        show: false,
        errors: {}
      },
      toast: {
        show: false,
        message: ''
      },
      confirmDelete(id) {
        this.deleteConfirm.productId = id;
        this.deleteConfirm.show = true;
      },
      showToast(message) {
        this.toast.message = message;
        this.toast.show = true;
        setTimeout(() => this.toast.show = false, 3000);
      },
      openServerErrorModal(oldValues, validationErrors) {
        this.serverError.errors = validationErrors;
        this.serverError.show = true;
      },
      init() {
        if (window.successMessage) {
          this.showToast(window.successMessage);
        }
        if (window.validationErrors && window.oldValues) {
          this.openServerErrorModal(window.oldValues, window.validationErrors);
        }
      }
    }
  }
</script>

@if ($errors->any())
  <script>
    window.validationErrors = @json($errors->messages());
    window.oldValues = @json(old());
  </script>
@endif

@if (session('success'))
  <script>
    window.successMessage = @json(session('success'));
  </script>
@endif
