<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lapak Murah | @yield('title', 'Home')</title>
  @vite('resources/css/app.css')
</head>
<body>

  <x-navbar.main />
    <main>
      @yield('main-content')
    </main>
  <x-footer/>

  @stack('nav-style')
  @stack('js-custom')
</body>
</html>