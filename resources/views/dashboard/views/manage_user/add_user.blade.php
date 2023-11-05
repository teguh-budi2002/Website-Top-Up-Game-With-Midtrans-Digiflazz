@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Manual Add User
@endsection
@section('dashboard_main')
<main class="w-full h-full">
    @if ($mess = Session::get('user'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('user-failed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
    </div>
    @endif
    @if ($errors->any())
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $errors->first() }}</div>
    </div>
    @endif
    <div class="w-full h-full flex justify-center mt-5 mb-5">
        <div class="w-11/12 bg-white rounded p-4">
            <form action="{{ URL('dashboard/settings/add-or-update-seo') }}" method="POST">
                @csrf
                <div class="fullname">
                    <x-form.input inputName="fullname" name="fullname" label="Fullname of User"
                        value="{{ old('fullname') }}"
                        placeholder="Insert Fullname..." />
                </div>
                <div class="username mt-3">
                    <x-form.input inputName="username" name="username" label="Username of User"
                        value="{{ old('username') }}"
                        placeholder="Insert Username..." />
                </div>
                <div class="email mt-3">
                    <x-form.input inputName="email" name="email" label="Email of User"
                        value="{{ old('email') }}"
                        placeholder="Insert Email..." />
                </div>
                <div class="phone_number mt-3">
                    <x-form.input inputName="phone_number" name="phone_number" label="Phone Number(Whatsapp) of User"
                        value="{{ old('phone_number') }}"
                        placeholder="Insert Phone Number..." />
                </div>
                <div class="password mt-3 flex justify-between items-center space-x-3" x-data="generateRandomPass">
                  <div class="w-full">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-800 dark:text-primary-darker">Password of User</label>
                    <input type="text" readonly name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-500 placeholder-violet-700 dark:placeholder-gray-400 read-only:bg-gray-400 read-only:cursor-not-allowed read-only:text-white" :value="randPass" id="password">
                  </div>
                  <button type="button" class="bg-yellow-500 rounded p-2 mt-6 cursor-pointer" @click="generateNow()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                  </button>
                </div>
                <div class="w-72 mt-3">
                  <select name="role_id" id="role">
                    <option selected disabled value="">Role of User</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_name }} - {{ $role->task_role }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="btn_submit mt-4">
                    <button class="py-2 px-24 rounded bg-primary text-white">Save</button>
                </div>
            </form>
        </div>
    </div>
</main>
@push('dashboard-js')
<script>
  new SlimSelect({
        select: '#role',
         settings: {
          showSearch: false,
        }
  })
  function generateRandomPass() {
    return {
      randPass: '',

      generateNow() {
          const randChars = 'abcdefhijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
          const specialChars = '!@#$%^_-'
          const passwordLength = 12

          let password = '';

          for (let i = 0; i < passwordLength; i++) {
              const charSet = i % 2 === 0 ? randChars : specialChars;
              const randomIndex = Math.floor(Math.random() * charSet.length);
              const randomChar = charSet[randomIndex];
              password += randomChar;
          }

          this.randPass = password
      }
    }
  }
</script>
@endpush
@endsection