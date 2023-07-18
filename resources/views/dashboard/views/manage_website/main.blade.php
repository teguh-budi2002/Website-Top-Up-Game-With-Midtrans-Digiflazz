@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Page Of Website
@endsection
@section('dashboard_main')
<main class="w-full h-full">
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
    <div class="flex justify-center">
        <div class="w-10/12 rounded bg-gray-50 dark:bg-darker shadow-md p-8 mt-5 mb-24">
            <div class="manage_page">
                @include('dashboard.views.manage_website.custom_page')
            </div>
        </div>
    </div>
</main>
@endsection
