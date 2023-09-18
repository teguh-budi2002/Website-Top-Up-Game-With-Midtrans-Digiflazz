@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Payment Product
@endsection
@section('dashboard_main')
<main class="w-full h-full md:mb-1 mb-5">
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
    <div class="w-full h-full box__container mt-5 mb-5">
        @if (!empty($payment_methods))
            <div class="w-10/12 h-auto p-1.5 bg-white shadow-md rounded mx-auto">
                <div class="available_payment_method border-2 border-white dark:border-primary-100 border-solid py-2 px-2">
                    <p
                        class="uppercase bg-primary-100 dark:bg-primary-darker text-gray-400 dark:text-white w-fit p-1 px-3 rounded-md font-semibold">
                        Available Payment Methods</p>
                    <div class="space-y-2 mt-4" x-data="handleRecommendationPayment">
                        <div id="accordion-open" data-accordion="collapse">
                            <h2 id="accordion-open-heading-1">
                                <button type="button"
                                    class="flex items-center justify-between w-full bg-primary-light p-5 font-medium text-left text-white rounded-t-md hover:bg-primary-100 transition-colors duration-150"
                                    data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                                    aria-controls="accordion-open-body-1">
                                    <span class="flex items-center capitalize">{{ $provider_name }}</span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
                                <div
                                    class="p-5 border border-b-0 border-gray-200 dark:bg-primary-50 flex flex-wrap items-center space-x-4">
                                    @foreach ($payment_methods as $payment)
                                    <img src="{{ asset('/img/' . $payment->img_static) }}" class="w-auto h-8"
                                        alt="{{ $payment->payment_name }}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mx-3">
                <div class="w-full h-auto p-3 bg-white shadow-md rounded mx-auto mt-5">
                    @include('dashboard.views.manage_payment_product.add_payment_method')
                </div>
                <div class="w-full h-auto p-3 bg-white shadow-md rounded mx-auto mt-5">
                    <div class="list_product">
                        <div class="overflow-x-auto p-3">
                            <table class="w-full">
                                <thead
                                    class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                                    <tr>
                                        <th></th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Product</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Supported Payment Methods</div>
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
                                        <td class="p-2">
                                            <button data-modal-target="showInfoPayment{{ $product->id }}" type="button"
                                                data-modal-toggle="showInfoPayment{{ $product->id }}"
                                                class="border-[1px] border-primary-dark p-2 rounded hover:bg-primary-dark hover:text-white transition">Supported
                                                Payment Methods</button>
                                            {{-- Info Payment Method Modal Component --}}
                                            <x-dashboard.info-modal modalId="showInfoPayment{{ $product->id }}"
                                                titleModal="PAYMENT METHOD SUPPORTED ON PRODUCT">
                                                <x-slot:info>
                                                    @if ($product->paymentMethods->count())
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        @foreach ($product->paymentMethods as $payment)
                                                        <img src="{{ asset("/img/" . $payment->img_static) }}"
                                                            class="w-auto h-5" alt="{{ $payment->payment_name }}">
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <div class="text-2xl text-center capitalize dark:text-primary-light">
                                                        <p class=" text-rose-400 uppercase">{{ $product->product_name }}
                                                        </p>
                                                        <p>doesn't have any supported payment methods</p>
                                                    </div>
                                                    @endif
                                                </x-slot:info>
                                                <x-slot name="footer">
                                                    <div class="flex items-center space-x-2 rounded-b">
                                                        <button data-modal-hide="showInfoPayment{{ $product->id }}"
                                                            type="button"
                                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-primary-dark dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-primary dark:focus:ring-gray-600 transition">Close</button>
                                                    </div>
                                                </x-slot>
                                            </x-dashboard.info-modal>
                                        </td>
                                    </tr>
                                    @endforeach
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
        @else
            <div class="w-10/12 h-auto p-4 bg-white shadow-md rounded mx-auto">
                <div class="text__alert text-center">
                    <p class="text-2xl text-rose-400 uppercase">You have not set up the payment gateway provider. please set it up first.</p>
                    <a href="{{ URL("dashboard/settings/payment-gateway") }}" class="text-blue-400 hover:text-blue-300 mt-2 block">Click here!</a>
                </div>
            </div>
        @endif
    </div>
</main>
@push('dashboard-js')
<script>
    function handleRecommendationPayment() {
        return {
            isOpen: false,
            alreadyRecommended: false,
            paymentId: 0
        }
    }

</script>
@endpush
@endsection
