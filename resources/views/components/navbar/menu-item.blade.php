@push('nav-style')
<link rel="stylesheet" href="{{ asset('/styles/navbar/menu_nav.css') }}">
@endpush

<div class="menu_nav relative cursor-pointer">
  <div class="menu_item flex flex-row items-center space-x-2 border-[1px] p-1.5 px-2 rounded-full">
    <img src="{{ asset('/img/blank_profile.webp') }}" class="w-8 h-8 rounded-full" alt="Dummy Profile">
    <i class="fa-solid fa-gear text-white gear__icon"></i>
  </div>
  <div class="menu_nav_dropdown hidden">
    <div class="dropdown_menu w-fit flex flex-row items-center space-x-3 absolute -right-6 top-14 bg-slate-700 p-2 rounded-b-md shadow-md">
      <a href="" class="w-24 py-1.5 px-1 rounded bg-yellow-400 text-yellow-800 hover:text-yellow-600 transition text-center">Register</a>
      <a href="" class="w-24 py-1.5 px-1 rounded bg-slate-400 text-slate-800 hover:text-slate-600 transition text-center">Login</a>
    </div>
  </div>
</div>

@push('js-custom')
 <script src="{{ asset('/js/navbar/menu_nav.js') }}"></script>
@endpush