<nav x-data="{ isOpen: false }"
    class="border-primary-cyan-light bg-primary-slate flex justify-between  w-full  border-0 border-b-2 border-solid py-6 px-12 text-white">
    {{-- LOGO --}}
    <div class="logo">logo</div>

    <div class="w-full flex items-center justify-between px-5">
        <div class="text__nav">
            <p class="text-3xl font-semibold italic">{{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}</p>
        </div>
        {{-- Search Box Main Page --}}
        @include('partials.search-box')

        <div class="right_menu">
            <div class="flex items-center space-x-3">
                <x-bell-notification />
            </div>
        </div>
    </div>
</nav>
