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
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" as="style" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;500;600;700;800&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('styles/custom_class.css') }}">
    <script defer src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
         .breadcrumbs {
            clip-path: polygon(0% 0%, 100% 0%, 88% 100%, 0% 100%);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none; 
            scrollbar-width: none;
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
        class="loading fixed inset-0 z-[99999] flex items-center justify-center bg-white dark:bg-primary-slate-light">
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
    <footer class="{{ (Request::is('order/*') ? 'bg-gradient-to-r from-violet-50 via-violet-100 to-violet-100 dark:bg-gradient-to-r dark:from-[#0F0F0F] dark:to-[#0F0F0F]' : (Request::is('checkout/*') ? 'bg-white' : 'bg-gradient-to-tr from-white via-violet-100 via-50% to-white dark:bg-gradient-t dark:from-primary-slate dark:to-primary-slate')) }} -mt-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="fill-violet-400 dark:fill-[#353349]" viewBox="0 0 1440 320"><path fill-opacity="1" d="M0,128L48,128C96,128,192,128,288,112C384,96,480,64,576,80C672,96,768,160,864,186.7C960,213,1056,203,1152,186.7C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
        <div class="w-full h-auto bg-violet-400 dark:bg-primary-slate-light lg:-mt-20 md:-mt-15 -mt-2">
            <div class="footer_content flex justify-center">
                <div class="w-11/12 p-4 mb-10">
                    <div class="grid sm:grid-cols-3 grid-cols-1 gap-3">
                        <div class="md:w-3/4 w-full flex flex-col items-start justify-between space-y-10">
                           <img src="{{ asset('/img/logo_with_bg.png') }}" class="w-16 h-16 rounded-md" alt="logo_website">
                           <p class="text-white capitalize">Layanan Website Top Up Game,Voucher, Dll Termurah Se Indonesia legal 100% aman & terpercaya</p>
                           <div class="social_media flex items-center space-x-5">
                                <a href="">
                                    <i class="fa-brands fa-instagram fa-xl dark:text-violet-400 text-violet-800 hover:text-violet-500 transition-colors duration-150"></i>
                                </a>
                                <a href="">
                                    <i class="fa-brands fa-facebook fa-xl dark:text-blue-400 text-blue-800 hover:text-blue-500 transition-colors duration-150"></i>
                                </a>
                                <a href="">
                                    <i class="fa-regular fa-envelope fa-xl dark:text-rose-400 text-rose-800 hover:text-rose-500 transition-colors duration-150"></i>
                                </a>
                           </div>
                           <div class="copyright">
                            <p class="dark:text-slate-400 text-violet-100 md:text-base text-sm">&#169; {{ Carbon\Carbon::now()->format('Y') }} - {{ app('seo_data')->name_of_the_company }}. All Rights Reserved.</p>
                           </div>
                        </div>
                        <div class="col-span-2 grid md:grid-cols-3 grid-cols-2 gap-5">
                            <div>
                                <p class="dark:text-primary-cyan-light text-violet-800">Sitemap</p>
                                <div class="mt-5 flex flex-col space-y-3">
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Beranda</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Customer Support</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Ulasan</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">FAQ</a>
                                </div>
                            </div>
                            <div>
                                <p class="dark:text-primary-cyan-light text-violet-800">Hubungi Kami</p>
                                <div class="mt-5 flex flex-col space-y-3">
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">WhatsApp</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Email</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Telegram</a>
                                </div>
                            </div>
                            <div>
                                <p class="dark:text-primary-cyan-light text-violet-800">Legalitas</p>
                                <div class="mt-5 flex flex-col space-y-3">
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Privacy & Policy</a>
                                    <a class="text-white dark:hover:text-cyan-300 hover:text-violet-600 transition-colors duration-150" href="{{ URL('/') }}">Terms & Condition</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @stack('nav-style')
    @stack('js-custom')
    <script>
        if(localStorage.getItem('darkmode') === 'true') {
            let html = document.documentElement
            window.onpaint = html.classList.add("dark")
        } else {
            localStorage.setItem('darkmode', false)
        }
        // Loading Init Page
        window.addEventListener('load', function () {
            const loader = document.querySelector('.loading');
            loader ? loader.classList.add('hidden') : null;
        });

    </script>
</body>
</html>
