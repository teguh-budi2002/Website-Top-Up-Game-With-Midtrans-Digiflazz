@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Notification
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-x-hidden">
     @if ($mess = Session::get('notification'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('notification-failed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
    </div>
    @endif
    @if ($errors->any())
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $errors->first() }}</div>
    </div>
    @endif
    <div class="w-full h-full">
        <div class="w-full h-full flex justify-center">
            <div class="w-full h-fit grid md:grid-cols-2 grid-cols-1 gap-2 md:mx-16 mx-3">
                <div class="w-full h-auto rounded bg-white shadow-md p-4 mt-5 mb-5">
                    @include('dashboard.views.manage_notification.custom_notification')
                </div>
                <div class="w-full h-fit mt-5">
                  <div class="list_notification w-full h-fit rounded bg-white shadow-md p-4">
                      <p class="font-extrabold uppercase text-slate-600">List Notification</p>
                      @foreach ($notifications as $notif)
                      <a href="?notif_slug={{ $notif->notif_slug }}" class="w-full flex justify-between items-center space-x-6 mt-2 p-4 mb-2 no-underline rounded bg-primary-100 hover:bg-primary group">
                          <div>
                              <img src="{{ asset('/storage/page/notification/' . $notif->notif_img) }}"
                                  class="w-28 h-auto object-cover rounded-sm" alt="">
                          </div>
                          <div class="space-y-1.5 flex-1">
                              <p class="uppercase text-slate-800 group-hover:text-teal-300 font-extrabold">{{ $notif->notif_title }}</p>
                              <p class="notif_desc text-xs text-slate-400 group-hover:text-teal-300">{{ Illuminate\Support\Str::limit($notif->notif_description, 300, '....') }}</p>
                          </div>
                      </a>
                      @endforeach
                    </div>
                    <div class="mb-2 p-4">
                        {{ $notifications->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
