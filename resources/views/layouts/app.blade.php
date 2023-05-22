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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('styles/custom_class.css') }}">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
  <div x-data="{ loading: true }" x-show="loading"
    class="loading fixed inset-0 z-50 flex items-center justify-center bg-cyan-900">
    <div class="custom__loader"></div>
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
    window.addEventListener('load', function() {
      setTimeout(() => {
        const loader = document.querySelector('.loading');
        loader.classList.add('hidden');
      }, 500);
    });

  // INIT LOCALSTORAGE KEY
  // Get the value from localStorage
  let recentSearchArr = JSON.parse(localStorage.getItem('__SEARCH__'));

  // Check if the value exists and if it is an array
  if (!recentSearchArr || !Array.isArray(recentSearchArr)) {
    // If it doesn't exist or is not an array, set an empty array as the default value
    recentSearchArr = [];

    // Save the default array to localStorage
    localStorage.setItem('__SEARCH__', JSON.stringify(recentSearchArr));
  }
  </script>
</body>

</html>
