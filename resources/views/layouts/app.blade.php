<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ app('seo_data')->name_of_the_company }} | @yield('title', 'Home')</title>
    <meta name="description" content="{{ app('seo_data')->description }}">
    <meta name="keywords" content="{{ app('seo_data')->keyword }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/storage/seo/logo/favicon/' . app('seo_data')->logo_favicon) }}">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/custom_class.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
         .breadcrumbs {
            clip-path: polygon(0% 0%, 100% 0%, 88% 100%, 0% 100%);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        [x-cloak]{
            display: none;
        }
    </style>
    @stack('css-custom')
</head>

<body>
    @if (!Request::is('checkout/*'))
    <div x-data="{ loading: true }" x-show="loading"
        class="loading fixed inset-0 z-[99999] flex items-center justify-center bg-primary-slate-light">
        <div class="custom_loader"></div>
    </div>      
    @endif

    <div class="min-h-max max-w-full">
        @include('layouts.navigation')


        {{-- Page Container --}}
        <main>
            @if (isset($breadcrumbs))
            {{ $breadcrumbs }}
            @endif
            {{ $slot }}
        </main>
    </div>
    {{-- 26.4.2.1:1080 --}}
    @stack('nav-style')
    @stack('js-custom')
    <script>
        // Loading Init Page
        window.addEventListener('load', function () {
            setTimeout(() => {
                const loader = document.querySelector('.loading');
                loader ? loader.classList.add('hidden') : null;
            }, 500);
        });

    </script>
</body>
</html>
