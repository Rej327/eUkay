<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#4B433C] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#38312b] focus:bg-[#38312b] active:bg-[#38312b] focus:outline-none focus:ring-2 focus:ring-[#38312b] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
