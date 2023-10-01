<x-app-layout>
  <div class="bg-primary-slate-light h-full min-h-screen w-full">
        <div class="md:block hidden">
            <div class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate border-0 border-solid border-b border-r border-primary-cyan-light">
                <ul class="list-none flex items-center space-x-2 text-sm font-semibold">
                     <li class="flex items-center space-x-2">
                        <a href="{{ Route('home') }}"
                            class="text-gray-200 hover:text-gray-400 transition-colors duration-150 no-underline">Home</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                    <li class="flex items-center space-x-2">
                        <a href="{{ Route('notification', ['slug' => $notif->notif_slug]) }}"
                            class="text-gray-200 hover:text-gray-400 transition-colors duration-150 no-underline">Notifikasi</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                </ul>
            </div>
        </div>
        <main class="mt-20">
            <div class="flex justify-center">
                <div class="w-3/4 bg-white rounded-md p-4">
                    <p class="title font-extrabold text-xl text-slate-600">{{ $notif->notif_title }}</p>
                    <p class="description text-sm mt-5 indent-5">{{ $notif->notif_description }}</p>
                    <p class="created_at mt-5 text-xs">Published : <span class="font-semibold">{{ $notif->created_at->diffForHumans() }}</span></p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>