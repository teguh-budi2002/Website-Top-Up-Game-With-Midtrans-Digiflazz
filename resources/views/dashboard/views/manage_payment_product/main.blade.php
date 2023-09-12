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
    <div class="w-full h-full box__container mt-5">
        <div class="w-10/12 h-auto p-1.5 bg-white shadow-md rounded mx-auto">
            <div class="available_payment_method border-2 border-white dark:border-primary-100 border-solid py-2 px-2">
                <p
                    class="uppercase bg-primary-100 dark:bg-primary-darker text-gray-400 dark:text-white w-fit p-1 px-3 rounded-md font-semibold">
                    Available Payment Methods</p>
                <div class="space-y-2 mt-4" x-data="handleRecommendationPayment">
                    <form action="{{ URL('dashboard/add-recommendation-payment-method') }}" method="POST">
                        @csrf
                        @foreach ($payment_methods as $payment)
                        <img src="{{ asset('/img/' . $payment->img_static) }}" class="w-auto h-6"
                            alt="{{ $payment->payment_name }}">
                        <div class="flex items-center space-x-2 mt-2 mb-1">
                            <div class="wrapper">
                                <div class="flex items-center space-x-2">
                                    <label for="is_recommendation_{{ $payment->id }}"
                                        class="text-xs dark:text-gray-900">Recommendation
                                        Payment
                                        Method?</label>
                                    @if ($payment->is_recommendation)

                                    <div @click="alreadyRecommended = true; paymentId = '{{ $payment->id }}'">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 text-green-500 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                        </svg>
                                    </div>

                                    <div data-modal-target="remove_recommendation_{{ $payment->id }}"
                                        data-modal-toggle="remove_recommendation_{{ $payment->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 text-red-500 cursor-pointer">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div x-show="alreadyRecommended && parseInt(paymentId) === {{ $payment->id }}"
                                    class="w-fit p-1 rounded-md px-4 bg-teal-500 text-white mt-2 mb-1">
                                    <p class="text-xs">Already Recommended Payment Method</p>
                                </div>
                            </div>
                            <input type="checkbox" name="payment_ids[]" value="{{ $payment->id }}"
                                @click="isOpen = true" id="is_recommendation_{{ $payment->id }}"
                                class="cursor-pointer rounded w-3 h-3 {{ $payment->is_recommendation ? 'hidden' : '' }}">
                        </div>
                        @endforeach
                        <button type="submit" x-show="isOpen" x-transition
                            class="py-1.5 px-4 rounded bg-primary text-sm dark:bg-primary-dark text-white mt-2">Add
                            Recommendation Payment</button>
                    </form>
                    @foreach ($payment_methods as $paymentModal)
                    <div class="modal__remove__recommendation">
                        <x-dashboard.info-modal modalId="remove_recommendation_{{ $paymentModal->id }}"
                            modalToggle="remove_recommendation_{{ $paymentModal->id }}">
                            <x-slot:titleModal>
                                Remove Recommendation Payment
                            </x-slot:titleModal>
                            <x-slot:info>
                                <div>
                                    <p class="text-lg text-slate-600 dark:text-slate-400">Are You Sure Want To Inactive
                                        Recommendation
                                        Payment For <span
                                            class="text-red-500 uppercase">{{ $paymentModal->payment_name }}</span>
                                    </p>
                                </div>
                            </x-slot:info>
                            <x-slot:footer>
                                <form
                                    action="{{ URL('dashboard/remove-recommendation-payment-method/' . $paymentModal->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="py-2.5 px-8 bg-red-400 text-white rounded-md">Yes,
                                        Inactive</button>
                                </form>
                            </x-slot:footer>
                        </x-dashboard.info-modal>
                    </div>
                    @endforeach
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
                                                    <p class=" text-rose-400 uppercase">{{ $product->product_name }}</p>
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
