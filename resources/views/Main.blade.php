<x-app-layout>
    <style>
        .underline__magical {
            background-image: linear-gradient(120deg, #42e2eb 0%, #0c85c2 100%);
            background-repeat: no-repeat;
            background-size: 100% 0.2em;
            background-position: 0 88%;
            transition: background-size 0.25s ease-in;
            padding: 8px;
        }

        .underline__magical:hover {
            color: white;
            background-size: 100% 88%;
        }

    </style>
    <div class="bg-primary-slate-light h-full w-full">
        <div class="md:block hidden">
            <div class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate border-0 border-solid border-b border-r border-primary-cyan-light">
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
                <x-header-banner />
            </div>
        </header>
        <section class="w-full mt-5 mb-5 flex justify-center">
            <div class="w-3/5">
                @if (count($flash_sales))
                <x-flash-sale-box  :flash_sales="$flash_sales" />
                @endif
            </div>
        </section>
        <main class="mt-5 pb-10">
            <div class="flex justify-center">
                <div class="w-3/4">
                    <div class="text__heading w-fit">
                        <p class="text-3xl text-primary-cyan-light underline__magical font-semibold">GAME TERFAVORIT</p>
                    </div>
                    {{-- Item Box --}}
                    <x-item-product-box/>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
