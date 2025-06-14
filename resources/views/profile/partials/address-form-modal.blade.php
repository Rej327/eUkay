<section>
  <div x-data="addressComponent()" x-init="selectedAddress = { user_id: '{{ $user->id }}', first_name: '', last_name: '', contact_number: '', street_address: '', barangay: '', city: '', province: '', zip_code: '' }">
    
    <!-- Trigger Button -->
    <x-primary-button @click.prevent="showModal = true" class="mt-6">
      {{ __('Add Address') }}
    </x-primary-button>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" x-cloak>
      <div @click.away="showModal = false" class="bg-white w-full max-w-4xl mx-4 p-6 rounded-lg shadow-lg overflow-y-auto max-h-[90vh]">
        
        <!-- Modal Header -->
        <header class="mb-4">
          <h2 class="text-lg font-medium text-gray-900">
            {{ __('Address Information') }}
          </h2>
          <p class="mt-1 text-sm text-gray-600">
            {{ __('Add or update your address information') }}
          </p>
        </header>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="space-y-6">
          
          <input type="hidden" name="user_id" x-model="selectedAddress.user_id">

          <!-- Row 1 -->
          <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
            <div class="w-full">
              <x-input-label for="first_name">First Name</x-input-label>
              <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" x-model="selectedAddress.first_name" />
              <template x-if="errors.first_name">
                <div class="text-red-600 text-sm mt-2" x-text="errors.first_name[0]"></div>
              </template>
            </div>
            <div class="w-full">
              <x-input-label for="last_name">Last Name</x-input-label>
              <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" x-model="selectedAddress.last_name" />
              <template x-if="errors.last_name">
                <div class="text-red-600 text-sm mt-2" x-text="errors.last_name[0]"></div>
              </template>
            </div>
          </div>

          <!-- Row 2 -->
          <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
            <div class="w-full">
              <x-input-label for="contact_number">Contact Number</x-input-label>
              <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" x-model="selectedAddress.contact_number" />
              <template x-if="errors.contact_number">
                <div class="text-red-600 text-sm mt-2" x-text="errors.contact_number[0]"></div>
              </template>
            </div>
            <div class="w-full">
              <x-input-label for="street_address">Street Address</x-input-label>
              <x-text-input id="street_address" name="street_address" type="text" class="mt-1 block w-full" x-model="selectedAddress.street_address" />
              <template x-if="errors.street_address">
                <div class="text-red-600 text-sm mt-2" x-text="errors.street_address[0]"></div>
              </template>
            </div>
          </div>

          <!-- Row 3 -->
          <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
            <div class="w-full">
              <x-input-label for="barangay">Barangay</x-input-label>
              <x-text-input id="barangay" name="barangay" type="text" class="mt-1 block w-full" x-model="selectedAddress.barangay" />
              <template x-if="errors.barangay">
                <div class="text-red-600 text-sm mt-2" x-text="errors.barangay[0]"></div>
              </template>
            </div>
            <div class="w-full">
              <x-input-label for="city">City</x-input-label>
              <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" x-model="selectedAddress.city" />
              <template x-if="errors.city">
                <div class="text-red-600 text-sm mt-2" x-text="errors.city[0]"></div>
              </template>
            </div>
          </div>

          <!-- Row 4 -->
          <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
            <div class="w-full">
              <x-input-label for="province">Province</x-input-label>
              <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" x-model="selectedAddress.province" />
              <template x-if="errors.province">
                <div class="text-red-600 text-sm mt-2" x-text="errors.province[0]"></div>
              </template>
            </div>
            <div class="w-full">
              <x-input-label for="zip_code">ZIP Code</x-input-label>
              <x-text-input id="zip_code" name="zip_code" type="text" class="mt-1 block w-full" x-model="selectedAddress.zip_code" />
              <template x-if="errors.zip_code">
                <div class="text-red-600 text-sm mt-2" x-text="errors.zip_code[0]"></div>
              </template>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex justify-end mt-6 space-x-3">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
              Cancel
            </button>
            <x-primary-button type="submit">{{ __('Add') }}</x-primary-button>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<script>
  function addressComponent() {
    return {
      showModal: false,
      selectedAddress: {},
      errors: {},
      successMessage: '',

      async submitForm() {
        this.errors = {};
        this.successMessage = '';

        try {
          const response = await fetch("{{ route('address.store') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
              'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(this.selectedAddress)
          });

          const contentType = response.headers.get('Content-Type');
          const data = contentType && contentType.includes('application/json') ? await response.json() : {};

          if (response.status === 422) {
            this.errors = data.errors || {};
          } else if (!response.ok) {
            alert(data.message || 'Something went wrong.');
          } else {
            this.successMessage = data.message || 'Address added successfully.';
            this.showModal = false;
            window.location.reload(); // Or update your address list dynamically
          }
        } catch (error) {
          alert('A network error occurred.');
        }
      }
    };
  }
</script>
