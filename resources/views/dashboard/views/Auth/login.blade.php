<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   @vite('resources/css/app.css')
   <style>
    *,html,body {
      padding: 0px;
      margin: 0px;
      box-sizing: border-box;
      font-family: 'Roboto Condensed', sans-serif;
    }

    body {
      width: 100%;
      height: 100%;
      background-image: url('{{ asset('img/bg_login.webp') }}');
      background-repeat: no-repeat;
      background-size: 'cover';
      background-position: top;
    }

    input:focus {
      border: none;
      outline: none;
    }
   </style>
</head>
<body>
  <div class="w-full h-screen">
    <div class="custom_bg bg-gradient-to-b from-transparent via-[#1D1B1B] to-[#0F0F0F] w-full h-40 fixed bottom-0">.</div>
    <div class="w-full h-screen flex md:justify-start justify-center items-center">
      <div class="lg:w-2/5 md:w-10/12 w-11/12 h-fit p-4 md:ml-20 bg-rose-700/70 rounded-md">
        @if( $message = Session::get('invalid-login') )
        <div class="w-full h-fit bg-rose-500/80  py-1 px-2 rounded mb-4 flex items-center justify-between" id="alert" role="alert">
          <p class="text-white capitalize">{{ $message }}</p>
          <svg xmlns="http://www.w3.org/2000/svg" id="closeAlert" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-rose-100 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        @enderror
        <p class="text-white text-4xl font-semibold">LOGIN</p>
        <p class="text-rose-100 mt-2">Masuk dengan akun yang telah di daftarkan oleh admin.</p>
        <form action="{{ Route('login.dashboard.main.process') }}" method="POST" class="mt-8">
          @csrf
          <div class="username">
            <label for="username" class="block text-white text-sm mb-2">Username</label>
            @error('username')
            <div class="mb-1" role="alert">
              <p class="text-sm text-rose-300 capitalize">{{ $message }}</p>
            </div>
            @enderror
            <input type="text" name="username" placeholder="Masukkan username anda" class="rounded-md w-full bg-slate-300 focus:bg-white border-none py-1 px-2">
          </div>
          <div class="Password mt-5">
            <label for="Password" class="block text-white text-sm mb-2">Password</label>
            @error('password')
            <div class="mb-1" role="alert">
              <p class="text-sm text-rose-300 capitalize">{{ $message }}</p>
            </div>
            @enderror
            <input type="password" name="password" placeholder="Masukkan password anda" class="rounded-md w-full bg-slate-300 focus:bg-white border-none py-1 px-2">
          </div>
          <div class="additional flex items-center justify-between mt-5">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember_me" class="w-3 h-3 text-rose-600 bg-gray-100 border-gray-300 rounded focus:ring-rose-500 dark:focus:ring-rose-600 focus:ring-2">
                <label for="remember_me" class="ml-2 text-sm font-medium text-white cursor-pointer">Ingat saya?</label>
            </div>
            <div>
              <a href="" class="text-md text-rose-50 hover:text-white">Lupa kata sandi?</a>
            </div>
          </div>
          <div class="btn_submit_login mt-5">
            <button class="w-full h-auto p-1 rounded-md bg-rose-700 hover:bg-rose-500 text-white">LOGIN</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    const alert = document.getElementById('alert')
    const btnCloseAlert = document.getElementById('closeAlert')

    btnCloseAlert.addEventListener('click', () => {
      alert.classList.add('hidden')
    })
  </script>
</body>
</html>