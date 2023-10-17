<x-app-layout>
<div class="bg-primary-slate h-full w-full">
    <div class="md:block hidden">
        <div
            class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate-light border-0 border-solid border-b border-r border-primary-cyan-light">
            <ul class="list-none flex items-center space-x-2 text-sm font-semibold">
                <li class="flex items-center space-x-2">
                    <a href="{{ Route('home') }}"
                        class="text-gray-200 hover:text-gray-400 transition-colors duration-150 no-underline">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </li>
            </ul>
        </div>
    </div>
    <header class="h-full w-full rounded p-2 pt-8">
        {{-- Banner Website --}}
        <div class="flex justify-center">
            <x-header-banner access-api-token="{{ $token }}"/>
        </div>
    </header>
    <section class="w-full mt-5 mb-5 flex justify-center">
        <div class="sm:w-3/5 w-11/12">
            @if (count($flash_sales))
                @push('css-custom')
                    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
                @endpush
                @push('js-custom')
                    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
                @endpush
                    <x-flash-sale-box :flash_sales="$flash_sales" />
            @endif
        </div>
    </section>
    <main class="mt-5 pb-10">
        <section class="favorite_game flex justify-center">
            <div class="md:w-3/4 w-11/12">
                <div class="text__heading w-fit">
                    <p class="md:text-3xl text-xl text-primary-cyan-light underline__magical font-semibold">GAME
                        TERFAVORIT</p>
                </div>

                {{-- Item Box --}}
                <x-item-product-box access-api-token="{{ $token }}"/>
            </div>
        </section>

        @if (count($product_categories))
        <section class="tab__panel w-full h-auto min-h-[350px] mt-10" x-data="handleProductByCategory()">
          <x-item-product-tab-panel :categories="$product_categories" :token="$token"/>
        </section>
        @endif
    </main>
</div>
</x-app-layout>
