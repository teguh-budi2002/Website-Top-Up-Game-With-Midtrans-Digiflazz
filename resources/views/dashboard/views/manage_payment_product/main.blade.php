@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Payment Product
@endsection
@section('dashboard_main')
<main class="w-full h-full">
    @if ($mess = Session::get('success-add-payment-method'))
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
    @elseif ($mess = Session::get('error-add-payment-method'))
    <div class="p-2 px-16 mt-5">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-red-600">error!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @endif
    <div class="box__container mt-5">
        <div class="">
            <div class="w-10/12 h-auto p-1.5 bg-white dark:bg-primary shadow-md rounded mx-auto">
                <div
                    class="available_payment_method border-2 border-white dark:border-primary-100 border-solid py-2 px-2">
                    <p
                        class="uppercase bg-primary-100 dark:bg-primary-darker text-gray-400 dark:text-white w-fit p-1 px-3 rounded-md font-semibold">
                        Available Payment Methods</p>
                    <div class="flex flex-wrap items-center space-x-2 mt-4">
                        @foreach ($payment_methods as $payment)
                        <img src="{{ asset('/img/' . $payment->img_static) }}" class="w-auto h-6"
                            alt="{{ $payment->payment_name }}">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-10/12 h-auto p-3 bg-white dark:bg-primary shadow-md rounded mx-auto mt-5">
                @include('dashboard.views.manage_payment_product.add_payment_method')
            </div>
        </div>
    </div>
</main>
@endsection
