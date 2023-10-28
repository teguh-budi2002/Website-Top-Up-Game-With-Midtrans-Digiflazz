<nav x-data="{ isOpen: false }"
    class="border-violet-500 dark:border-primary-cyan-light bg-white/90 dark:bg-primary-slate-light flex justify-between items-center w-full border-0 border-b-2 border-solid lg:py-6 md:py-3 py-[9px] lg:px-12 md:px-5 px-5 text-white">
    <div class="logo">
        <a href="{{ URL('/') }}">
            @if (app('seo_data')->logo_website)
                <img src="{{ asset('/storage/seo/logo/website/' . app('seo_data')->logo_website) }}" class="w-16 h-16 rounded-md" alt="logo_website">
            @else
                <img src="{{ asset('/img/logo_with_bg.png') }}" class="w-16 h-16 rounded-md" alt="logo_website">    
            @endif
        </a>
    </div>

    <div class="w-full flex items-center lg:justify-between sm:justify-around md:px-5 px-0">
        <div class="text__nav lg:block hidden">
            <p class="text-3xl font-semibold italic dark:text-slate-300 text-slate-600">{{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}</p>
        </div>
        <div class="md:w-auto w-full flex justify-end items-center space-x-2">
            {{-- Search Box Main Page --}}
            @include('partials.search-box')
    
            <div class="right_menu">
                <div class="flex items-center space-x-3 mt-2">
                    <x-bell-notification />
                    <x-dark-mode-switcher />
                </div>
            </div>
        </div>
    </div>
</nav>
