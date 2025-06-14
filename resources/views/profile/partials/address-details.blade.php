<section x-data="addressComponent()">
  <header>
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Address Information') }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
      {{ __('Keep your profile accurate by adding or updating your address information.') }}
    </p>
  </header>

  <div class="mt-6 space-y-4">
    @forelse ($addresses as $address)
      <div class="p-4 border rounded-md bg-white shadow-sm">
        <div class="text-sm text-gray-700">
          <p><strong>Name:</strong> {{ $address->first_name }} {{ $address->last_name }}</p>
          <p><strong>Contact:</strong> {{ $address->contact_number }}</p>
          <p><strong>Address:</strong>
            {{ $address->street_address }}, Brgy. {{ $address->barangay }},
            {{ $address->city }}, {{ $address->province }} {{ $address->zip_code }}
          </p>
        </div>

        <div class="mt-2 flex items-center gap-2">
          <a href="#" @click.prevent="showModal = true; selectedAddress = {{ json_encode($address) }}"
            class="text-blue-600 hover:underline text-sm">
            Edit
          </a>

          <form action="{{ route('address.destroy', $address->id) }}" method="POST"
            onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-sm text-gray-600">No address records found.</p>
    @endforelse
  </div>

  <!-- Modal -->
  <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;">
    <div @click.away="showModal = false"
      class="bg-white w-full max-w-4xl mx-4 p-6 rounded-lg shadow-lg overflow-y-auto max-h-[90vh]">

      <h2 class="text-lg font-medium text-gray-900">
        {{ __('Edit Address') }}
      </h2>
      <p class="mt-1 text-sm text-gray-600">
        {{ __('Modify your address information') }}
      </p>
      </header>

      <form @submit.prevent="submitForm" x-bind:action="'/address/' + selectedAddress.id" method="POST"
        class="space-y-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <!-- Name -->
        <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
          <div class="w-full">
            <x-input-label for="first_name">First Name</x-input-label>
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.first_name" />
            <template x-if="errors.first_name">
              <p class="text-sm text-red-600" x-text="errors.first_name[0]"></p>
            </template>
          </div>
          <div class="w-full">
            <x-input-label for="last_name">Last Name</x-input-label>
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.last_name" />
          </div>
        </div>

        <!-- Contact & Street -->
        <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
          <div class="w-full">
            <x-input-label for="contact_number">Contact Number</x-input-label>
            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.contact_number" />
          </div>
          <div class="w-full">
            <x-input-label for="street_address">Street Address</x-input-label>
            <x-text-input id="street_address" name="street_address" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.street_address" />
          </div>
        </div>

        <!-- Barangay & City -->
        <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
          <div class="w-full">
            <x-input-label for="barangay">Barangay</x-input-label>
            <x-text-input id="barangay" name="barangay" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.barangay" />
          </div>
          <div class="w-full">
            <x-input-label for="city">City</x-input-label>
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.city" />
          </div>
        </div>

        <!-- Province & ZIP -->
        <div class="space-y-6 md:space-y-0 md:flex md:gap-4">
          <div class="w-full">
            <x-input-label for="province">Province</x-input-label>
            <x-text-input id="province" name="province" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.province" />
          </div>
          <div class="w-full">
            <x-input-label for="zip_code">ZIP Code</x-input-label>
            <x-text-input id="zip_code" name="zip_code" type="text" class="mt-1 block w-full"
              x-model="selectedAddress.zip_code" />
          </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end mt-6 space-x-3">
          <button type="button" @click="showModal = false"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            Cancel
          </button>
          <x-primary-button type="submit">Update</x-primary-button>
        </div>
      </form>

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

      async submitForm(event) {
        event.preventDefault();
        this.errors = {};
        this.successMessage = '';

        try {
          const response = await fetch(`/address/${this.selectedAddress.id}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
              ...this.selectedAddress,
              _method: 'PUT'
            })
          });

          const contentType = response.headers.get('Content-Type');

          // Try to parse response if it's JSON
          const data = contentType && contentType.includes('application/json') ?
            await response.json() :
            {};

          if (response.status === 422) {
            this.errors = data.errors || {};
          } else if (!response.ok) {
            alert(data.message || 'Something went wrong.');
          } else {
            this.successMessage = data.message || 'Address updated successfully.';
            this.showModal = false;
            window.location.reload(); // Optional
          }
        } catch (error) {
          console.error(error);
          alert('A network error occurred. Please try again.');
        }
      }
    };
  }
</script>
