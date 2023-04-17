@push('nav-style')
<link rel="stylesheet" href="{{ asset('/styles/navbar/search_box.css') }}">
@endpush
<div class="max-w-md relative">
    <div class="search__icon cursor-pointer">
        <button class=" w-9 h-9 rounded-full bg-slate-400">
            <i class="fa-solid fa-magnifying-glass fa-beat-fade text-white"></i>
        </button>
    </div>
    <div class="x_button cursor-pointer hidden">
      <button class="w-9 h-9 rounded-full bg-red-400"><i class="fa-regular fa-x text-white"></i></button>
    </div>
    <div class="input__search absolute right-12 top-0 bottom-0 shadow-md hidden">
        <form action="">
            <input type="text" class="p-2 md:w-64 w-48 h-auto bg-white rounded-md focus:outline-none form__input"
                placeholder="Mau cari game apa?">
        </form>
    </div>
</div>
@push('js-custom')
<script src="{{ asset('/js/navbar/search_box.js') }}"></script>
@endpush
