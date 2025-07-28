<x-app-layout>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold text-green-600 mb-4">Payment Successful!</h1>

    <p class="mb-4 text-gray-700">Thank you for your purchase.</p>

    <p class="text-gray-600">
      Your payment has been processed, and the product has been marked as <strong>sold</strong>.
    </p>

    <div class="mt-6">
      <a href="{{ route('home') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        Go back to shop
      </a>
    </div>
  </div>
</x-app-layout>
