@props(['active'])

@php
  $classes =
      $active ?? false
          ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#1E1E1F] text-sm font-medium leading-5 text-[#1E1E1F] focus:outline-none focus:border-[#4b433c] transition duration-150 ease-in-out'
          : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>
