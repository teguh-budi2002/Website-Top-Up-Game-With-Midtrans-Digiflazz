<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lapak Murah | @yield('title', 'Home')</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/custom_class.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
    <div x-data="{ loading: true }" x-show="loading"
        class="loading fixed inset-0 z-[99999] flex items-center justify-center bg-primary-slate-light">
        <div class="custom_loader"></div>
    </div>

    <div class="min-h-max max-w-full">
        @include('layouts.navigation')

        {{-- Page Heading  --}}
        @if (isset($header))
        <header class="bg-white shadow dark:bg-gray-800">
            <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        {{-- Page Content --}}
        <main>
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
                loader.classList.add('hidden');
            }, 500);
        });

    </script>
</body>

</html>
