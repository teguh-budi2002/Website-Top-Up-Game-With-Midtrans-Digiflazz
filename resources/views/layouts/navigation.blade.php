<nav x-data="{ isOpen: false }"
    class="border-primary-cyan-light bg-primary-slate flex justify-between items-center w-full border-0 border-b-2 border-solid md:py-6 py-[9px] md:px-12 px-5 text-white">
    <div class="logo">
        <a href="{{ URL('/') }}">
            @if (app('seo_data')->logo_website)
                <img src="{{ asset('/storage/seo/logo/website/' . app('seo_data')->logo_website) }}" class="w-16 h-16" alt="logo_website">
            @else
                <img src="{{ asset('/img/logo_with_bg.png') }}" class="w-16 h-16" alt="logo_website">    
            @endif
        </a>
    </div>

    <div class="w-full flex items-center justify-between md:px-5 px-0">
        <div class="text__nav md:block hidden">
            <p class="text-3xl font-semibold italic">{{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}</p>
        </div>
        <div class="md:w-auto w-full flex justify-end items-center">
            {{-- Search Box Main Page --}}
            @include('partials.search-box')
    
            <div class="right_menu">
                <div class="flex items-center space-x-3">
                    <x-bell-notification />
                </div>
            </div>
        </div>
    </div>
</nav>
