@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#4b433c] focus:ring-[#4b433c] rounded-md shadow-sm']) }}>
