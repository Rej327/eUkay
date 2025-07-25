<x-app-layout>
  <div class="max-w-xl mx-auto mt-10 text-center">
    <h2 class="text-2xl font-bold mb-4 text-green-600">Payment Successful!</h2>
    <p class="text-gray-700">{{ session('message') }}</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block px-4 py-2 bg-green-600 text-white rounded">Back to Home</a>
  </div>
</x-app-layout>
