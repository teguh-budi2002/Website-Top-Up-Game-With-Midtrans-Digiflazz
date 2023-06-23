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
        <header class="h-full w-full rounded p-2 pt-8">
            {{-- Banner Website --}}
            <div class="flex justify-center">
                <x-header-banner />
            </div>
        </header>
        <main class="mt-5 pb-10">
            <div class="flex justify-center">
                <div class="w-3/4">
                    <div class="text__heading w-fit">
                        <p class="text-3xl text-primary-cyan-light underline__magical font-semibold">GAME TERFAVORIT</p>
                    </div>
                    {{-- Item Box --}}
                    <x-item-product-box />
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
