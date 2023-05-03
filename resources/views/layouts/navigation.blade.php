<nav x-data="{ isOpen: false }"
  class="border-primary-light bg-primary flex w-full flex-row items-center justify-between border-0 border-b-2 border-solid py-6 px-12 text-white">
  <div class="flex items-center">
    <div class="hamburger">
      <span>=</span>
    </div>
    <div class="logo">logo</div>
  </div>
  {{-- Search Box Main Page --}}
  @include('partials.search-box')

  <div class="right_menu">right menu</div>
</nav>
