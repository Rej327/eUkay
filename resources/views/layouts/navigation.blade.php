<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
          <a href="{{ route('home') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
          </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link ink :href="route('home')" :active="request()->routeIs('home') && !request('category')">
            {{ __('Home') }}
          </x-nav-link>

          <x-nav-link :href="route('home', ['category' => 't-shirts'])" :active="request('category') === 't-shirts'">
            T-shirts
          </x-nav-link>

          <x-nav-link :href="route('home', ['category' => 'jackets'])" :active="request('category') === 'jackets'">
            {{ __('Jackets') }}
          </x-nav-link>

          <x-nav-link :href="route('home', ['category' => 'shorts'])" :active="request('category') === 'shorts'">
            {{ __('Shorts') }}
          </x-nav-link>

          <x-nav-link :href="route('home', ['category' => 'jeans'])" :active="request('category') === 'jeans'">
            {{ __('Pants') }}
          </x-nav-link>

          <x-nav-link :href="route('home', ['category' => 'shoes'])" :active="request('category') === 'shoes'">
            {{ __('Shoes') }}
          </x-nav-link>
        </div>
      </div>

      <!-- Settings Dropdown -->
      <div class="hidden sm:flex sm:items-center sm:ms-6">
        <div x-data="{ showSearch: false }" class="flex items-center space-x-4 relative">
          <!-- Search Icon (toggle search input) -->
          <button type="button" @click="showSearch = !showSearch">
            <x-css-search class="w-5 h-5 text-gray-500" />
          </button>

          <!-- Shopping Bag Icon with Count -->
          <a href="{{ route('cart.index') }}" class="relative inline-block">
            <x-tni-bag class="w-5 h-5 text-gray-500" />

            @if ($cartItemCount > 0)
              <span class="absolute -top-2 -right-2 z-50 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5">
                {{ $cartItemCount }}
              </span>
            @endif
          </a>

          <!-- Search Input (use x-show instead of x-if) -->
          <div x-show="showSearch" @click.outside="showSearch = false" x-transition
            class="absolute md:right-16 md:-top-[3.2rem] mt-10 w-64">
            <input type="text" placeholder="Search..."
              class="w-full px-3 py-2 border border-gray-300 rounded shadow focus:outline-none focus:ring-2 focus:ring-[#F5DDBA50] focus:border-[#D4C4B2]"
              x-ref="searchInput" x-init="$nextTick(() => $refs.searchInput.focus())" />
          </div>
        </div>

        <x-dropdown x-align="right" width="48">
          <x-slot name="trigger">
            <button
              class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
              <div>{{ Auth::user()->username }}</div>

              <div class="ms-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </div>
            </button>
          </x-slot>

          <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
              {{ __('Profile') }}
            </x-dropdown-link>
            <x-dropdown-link :href="route('wishlist.index')">
              {{ __('My Wishlist') }}
            </x-dropdown-link>
            @auth
              @if (auth()->user()->isAdmin())
                <x-dropdown-link :href="route('manage-products.index')">
                  {{ __('My Products') }}
                </x-dropdown-link>
              @endif
            @endauth
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
              @csrf

              <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                {{ __('Log Out') }}
              </x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>
      </div>

      <!-- Hamburger -->
      <div class="-me-2 flex items-center sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{ 'block': open, 'hidden': !open }"
    class="hidden sm:hidden absolute h-full inset-x-0 top-16 bg-white transition transform origin-top-right z-50">
    <div class="pt-2 pb-3 space-y-1">
      <!-- Search Input -->
      <div class="px-4">
        <input type="text" placeholder="Search..."
          class="w-full px-3 py-2 border border-gray-300 rounded shadow focus:outline-none focus:ring-2 focus:ring-[#F5DDBA50] focus:border-[#D4C4B2]"
          x-ref="searchInput" x-init="$nextTick(() => $refs.searchInput.focus())" />
      </div>
      <!-- Responsive Navigation Links -->
      <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home') && !request('category')">
        {{ __('Home') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('home', ['category' => 't-shirts'])" :active="request('category') === 't-shirts'">
        T-shirts
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('home', ['category' => 'jackets'])" :active="request('category') === 'jackets'">
        {{ __('Jackets') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('home', ['category' => 'shorts'])" :active="request('category') === 'shorts'">
        {{ __('Shorts') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('home', ['category' => 'jeans'])" :active="request('category') === 'jeans'">
        {{ __('Pants') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('home', ['category' => 'shoes'])" :active="request('category') === 'shoes'">
        {{ __('Shoes') }}
      </x-responsive-nav-link>

    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">
      <div class="px-4">
        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
      </div>

      <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')">
          {{ __('Profile') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('wishlist.index')">
          {{ __('My Wishlist') }}
        </x-responsive-nav-link>
        @auth
          @if (auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('manage-products.index')">
              {{ __('My Products') }}
            </x-responsive-nav-link>
          @endif
        @endauth
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                                        this.closest('form').submit();">
            {{ __('Log Out') }}
          </x-responsive-nav-link>
        </form>
      </div>
    </div>
  </div>
</nav>
