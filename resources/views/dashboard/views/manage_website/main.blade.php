@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Page Of Website
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-x-hidden">
    {{-- Alert Notif --}}
    @error('bg_img_on_order_page')
    <div class="p-2 px-16 mt-2">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-3xl uppercase text-red-600">error!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                <p class="capitalize">{{ $message }}</p>
            </x-slot:textMess>
        </x-alert>
    </div>
    @enderror
    @if ($mess = Session::get('success-custom-field'))
    <div class="p-2 px-16 mt-5">
        <x-alert bg-color="bg-green-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-green-600">success!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @endif
    <div class="w-full h-full">
        <div class="w-full h-full flex justify-center">
            <div class="h-fit grid grid-cols-2 gap-5">
                <div class="w-[600px] h-auto rounded bg-white shadow-md p-4 mt-5 mb-5">
                     @include('dashboard.views.manage_website.custom_page')
                </div>
                <div class="w-full h-fit mt-5">
                    <div class="list_page w-full h-fit rounded bg-white shadow-md p-4">
                        <div class="overflow-x-auto p-3">
                            <table class="w-full">
                                <thead
                                    class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                                    <tr>
                                        <th></th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Order Page Name</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Action</div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="text-sm text-primary dark:text-primary-light divide-y divide-primary-100">
                                    @if (count($products))
                                    @foreach ($products as $product)
                                    <tr id="{{ $product->id }}">
                                        <td class="p-2">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="p-2">
                                            <p>{{ $product->product_name }}</p>
                                        </td>
                                        <td class="p-2 flex justify-start">
                                            <a href="?slug={{ $product->slug }}"
                                                class="block p-1 bg-primary-100 rounded hover:bg-primary hover:text-white transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <div class="text-center">
                                        <p class="capitalize text-xl">Please create a product first before placing a
                                            custom order page.</p>
                                        <a href="{{ URL('dashboard/products') }}"
                                            class="text-blue-300 hover:text-blue-500">Click here!</a>
                                    </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-2 p-4">
                        {{ $products->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
