<section class="relative mt-20 mb-20">
  <!-- Background Image -->
  <div class="w-full h-[50vh] md:h-[60vh] bg-cover bg-center"
    style="background-image: url('{{ asset('images/banner-mid.jpg') }}');">
    <div class="bg-[#DDD2CB]/80 w-full h-full flex items-center justify-center">
      <div class="text-center px-6">
        <h2 class="text-4xl md:text-6xl font-bold uppercase text-[#4B433C] tracking-wide">Elevate Your Style</h2>
        <p class="mt-4 text-md md:text-lg text-[#4B433C]">Discover curated pieces handpicked for you.</p>
        <a href="{{ route('home', ['collection' => 'new']) }}"
          class="mt-6 inline-block px-6 py-2 border-2 border-[#4B433C] text-[#4B433C] hover:bg-[#4B433C] hover:text-white transition rounded">
          Shop New Arrivals
        </a>
      </div>
    </div>
  </div>
</section>
