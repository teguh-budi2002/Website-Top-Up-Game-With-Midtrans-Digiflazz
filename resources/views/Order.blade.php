<x-app-layout>
    <div class="w-full h-full overflow-x-hidden bg-gradient-to-r from-violet-50 via-violet-100 to-violet-100 dark:bg-gradient-to-r dark:from-[#0F0F0F] dark:to-[#0F0F0F]" x-data="handleOrder()">
        <div class="relative z-[99] md:block hidden">
            <div class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-violet-100 shadow-md dark:bg-primary-slate-light border-0 border-solid border-b-2 border-r dark:border-primary-cyan-light border-violet-500 absolute">
                <ul class="list-none flex items-center space-x-2 text-sm font-semibold">
                    <li class="flex items-center space-x-2">
                        <a href="{{ Route('home') }}"
                            class="dark:text-slate-200 text-slate-800 hover:text-slate-500 dark:hover:text-slate-400 transition-colors duration-150 no-underline">Home</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                    <li class="flex items-center space-x-2">
                        <a href="{{ Route('order', ['slug' => $product->slug]) }}"
                            class="dark:text-slate-200 text-slate-800 hover:text-slate-500 dark:hover:text-slate-400 transition-colors duration-150 no-underline">Order</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                </ul>
            </div>
        </div>
        @if (!is_null($custom_field) && !is_null($custom_field->bg_img_on_order_page))
        <img src="{{ asset('/storage/' . $custom_field->bg_img_on_order_page) }}"
            class="custom__bg__img w-full md:h-[700px] h-[300px] object-cover bg-no-repeat bg-top z-10 absolute lg:top-[114px] md:top-[90px] top-[85px]"
            alt="{{ asset('/storage/' . $custom_field->bg_img_on_order_page) }}">
        @else
        <img src="https://source.unsplash.com/random/1920x800"
            class="w-full md:h-[700px] h-[300px] object-cover bg-no-repeat bg-top z-10 absolute lg:top-[114px] md:top-[90px] top-[85px]"
            alt="random_img">
        @endif
        <div class="bg-gradient-to-b from-transparent via-violet-300 to-violet-100 dark:bg-gradient-to-b dark:from-transparent dark:via-[#1D1B1B] dark:to-[#0F0F0F] bg-cover from- w-full md:h-[900px] h-[400px] absolute overflow-x-hidden z-20"></div>
        <section class="content w-full h-full z-50 relative">
        {{-- Custom Modal Invalid user ID --}}
        <div @keydown.escape="showInvalidUserIDModal = false">
            <div class="fixed inset-0 z-[9999999] flex items-center justify-center bg-primary-slate/80 overflow-auto" x-show="showInvalidUserIDModal"
                    x-transition:enter="motion-safe:ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="motion-safe:ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90">
                <div class="sm:w-3/4 w-11/12 max-w-3xl sm:px-4 px-1 py-4 sm:mx-auto mx-4 text-left bg-gradient-to-br from-violet-100 via-violet-200 to-white dark:bg-primary-slate-light border-2 border-solid border-violet-500 dark:border-primary-cyan-light rounded-lg" @click.away="showInvalidUserIDModal = false">
                    <div class="title">
                        <h5 class="text-center text-3xl text-rose-500 max-w-none">PERHATIAN</h5>
                    </div>
                    <div class="text-center mt-5 mb-5">
                      <template x-if="errMessTooManyAttemptReq">
                          <p class="text-lg text-slate-600 dark:text-slate-300" x-text="errMessTooManyAttemptReq"></p>
                      </template>
                      <template x-if="!errMessTooManyAttemptReq">
                          <p class="sm:text-lg text-sm text-slate-600 dark:text-slate-300">User ID Dengan <span class="text-violet-500 dark:text-primary-cyan-light" x-text="data.player_id && data.zone_id ? `${data.player_id} - (${data.zone_id})` : data.player_id === '' ? '??????' : `${data.player_id}`"></span> Tidak Ditemukan!</p>
                      </template>
                    </div>
                </div>
            </div>
        </div>
            @include('mobile.header_order_mobile')
            <div class="wrapper_grid">
                <div class="grid lg:grid-cols-2 grid-cols-1 lg:gap-5 gap-1 md:mx-10 mx-0">
                    <div class="left_section lg:mt-52 md:mt-20 mt-5 md:mb-10 mb-0">
                        {{-- #1a1919 --}}
                        {{-- #222224 --}}
                        {{-- bg-[#25262b] --}}
                        {{-- #222121 RECEMMENDED!!! --}}
                        <div class="form_wrapper w-full h-fit sm:p-8 p-4 rounded-xl shadow-lg md:dark:shadow-2xl dark:shadow-slate-200 bg-white dark:bg-[#1b1d1beb]">
                            <form @submit.prevent="checkingValidationForm" method="POST">
                                <div class="add_player_id bg-gradient-to-l from-violet-100 via-violet-200 to-white dark:bg-gradient-to-l dark:from-primary-slate-light/70 dark:to-primary-slate-light/70  border-2 border-violet-500 dark:border-primary-cyan-light text-white border-solid w-full p-4 rounded-lg">
                                    <div class="step_one flex justify-between items-center mb-3">
                                        <p class="font-semibold text-violet-800 dark:text-slate-300 capitalize">{!!
                                            $custom_field->text_title_on_order_page ?? 'Masukkan Player ID Anda'
                                            !!}
                                        </p>
                                        <div class="w-fit bg-violet-400 dark:bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 1</p>
                                        </div>
                                    </div>
                                    <div class="ERR_MESS" x-show="errMess.errorPlayerId">
                                        <p x-text="errMess.errorPlayerId"
                                            class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                                            role="errorPLayerIDMessage"></p>
                                    </div>
                                    <div class="grid {{ isset($custom_field) && $custom_field->has_zone_id ? 'grid-cols-2' : 'grid-cols-1' }} gap-3">
                                        <x-form.input type="text" label="" modelBinding="data.player_id" name="player_id"
                                            inputClass="bg-slate-100 dark:bg-primary-slate-light text-center text-slate-700 dark:text-white p-4 border-2 dark:border-slate-400 border-violet-300 rounded-lg focus:ring-0 focus:border-violet-400 dark:focus:border-slate-400"
                                            inputName="player_id" placeholder="Masukkan Player ID" />
                                        @if (isset($custom_field) && $custom_field->has_zone_id)
                                        <x-form.input type="text" label="" modelBinding="data.zone_id" name="zone_id" maxInput="4"
                                            inputClass="bg-slate-100 dark:bg-primary-slate-light text-center text-slate-700 dark:text-white p-4 border-2 dark:border-slate-400 border-violet-300 rounded-lg focus:ring-0 focus:border-violet-400 dark:focus:border-slate-400"
                                            inputName="zone_id" placeholder="(2179)" />
                                        @endif
                                    </div>
                                    <p class="text-xs mt-3 italic text-gray-300 font-thin">{!! $custom_field->description_on_order_page ?? '' !!}</p>
                                </div>
                                <div class="item_product mt-5 bg-gradient-to-l from-violet-100 via-violet-200 to-white dark:bg-gradient-to-l dark:from-primary-slate-light/70 dark:to-primary-slate-light/70  border-2 border-violet-500 dark:border-primary-cyan-light text-white border-solid w-full p-4 rounded-lg">
                                    <div class="step_two flex items-center justify-between">
                                        <p class="capitalize font-semibold text-violet-800 dark:text-slate-300">Pilih jumlah nominal item.
                                        </p>
                                        <div class="w-fit bg-violet-400 dark:bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 2</p>
                                        </div>
                                    </div>
                                    <div class="ERR_MESS mb-3 mt-3" x-show="errMess.errorItem">
                                        <p x-text="errMess.errorItem"
                                            class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                                            role="errorItemMessage"></p>
                                    </div>
                                    @if ($product->items->contains('discount', '>', '0'))
                                    <div class="special_offer mt-2 pb-4 border-b border-solid border-violet-500 dark:border-primary-cyan-light/80">
                                        <p class="uppercase mb-3 font-semibold text-rose-400 dark:text-yellow-300">Penawaran Special &#128293;</p>
                                        <div class="grid 2xl:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                                        @foreach ($product->items as $itemDiscount)
                                            @if ($itemDiscount->discount)
                                            @php
                                                $initialPrice = $itemDiscount->discount->price_after_discount * 0.007 + $itemDiscount->discount->price_after_discount;
                                                $roundedPrice = ceil($initialPrice / 500) * 500;
                                            @endphp
                                            <div @click.prevent="activeItem = {{ $itemDiscount->id }}; data.itemSelected = '{{ $itemDiscount->item_name }}'; data.itemNominal = '{{ $itemDiscount->nominal }}'; initialPrice = {{ $itemDiscount->discount->price_after_discount }}; selectedItemProduct()"  :class="{ 'dark:bg-slate-600 bg-violet-500 border-2 border-solid border-violet-500 dark:border-primary-cyan-light': activeItem === {{ $itemDiscount->id }}, 'bg-violet-300 hover:bg-violet-500 dark:bg-primary-slate dark:hover:bg-slate-500/90 border-2 border-solid border-violet-500 dark:border-slate-50 text-white': activeItem !== {{ $itemDiscount->id }} }" class="w-full sm:h-[120px] h-[135px] p-2.5 cursor-pointer rounded-md relative group">
                                                <div class="relative -top-6">
                                                    <img src="{{ asset('/img/special_offer.webp') }}" :class="{ 'grayscale-0' : activeItem === {{ $itemDiscount->id }} }" class="absolute w-full h-16 grayscale group-hover:grayscale-0 transition duration-150" alt="special_offer">
                                                    <p :class="{ 'text-yellow-400' : activeItem === {{ $itemDiscount->id }} }" class="text-slate-400 group-hover:text-yellow-400 absolute top-8 text-xs font-semibold transition duration-150" style="transform: translate(-50%, -50%); left: 50%">
                                                    {{ $itemDiscount->discount->type_discount === 'discount_flat' ? 
                                                            (
                                                            $itemDiscount->discount->discount_flat >= 1000000 ? 
                                                                (strval(floor($itemDiscount->discount->discount_flat / 1000000)) . "JT") :
                                                                (
                                                                $itemDiscount->discount->discount_flat >= 1000 ?
                                                                    (strval(floor($itemDiscount->discount->discount_flat / 1000)) . "K") :
                                                                    strval($itemDiscount->discount->discount_flat)
                                                                )
                                                            ) :
                                                            ($itemDiscount->discount->discount_fixed . "%")
                                                    }} OFF</p>
                                                </div>
                                                <div class="flex items-center justify-between mt-8">
                                                    <div class="left_item space-y-1">
                                                        <p class="text-sm text-violet-800 group-hover:text-white dark:text-white" :class="{'text-white' : activeItem === {{ $itemDiscount->id }}}">{{ $itemDiscount->nominal }} - {{ $itemDiscount->item_name }}</p>
                                                        <p class="text-sm text-violet-100 dark:text-teal-400">Rp. {{ Cash($itemDiscount->discount->price_after_discount, 2) }}</p>
                                                        <p class="text-[10px] line-through" :class="{'text-rose-400 dark:text-rose-500' : activeItem === {{ $itemDiscount->id }}, 'text-violet-900 group-hover:text-violet-200 dark:text-rose-500 dark:group-hover:text-rose-500' : activeItem !== {{ $itemDiscount->id }} }">Rp. {{ Cash($itemDiscount->price, 2) }}</p>
                                                    </div>
                                                    @if ($itemDiscount->product->item_img)
                                                    <div class="right_item">
                                                        <img src="{{ asset('/storage/item/' . $itemDiscount->product->product_name . "/" . $itemDiscount->product->item_img) }}" :class="{ 'grayscale-0' : activeItem === {{ $itemDiscount->id }} }"  class="w-auto h-8 grayscale contrast-200 group-hover:grayscale-0  transition duration-150" alt="logo_img_item">
                                                    </div> 
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="list_normal_item mt-3">
                                        <p class="uppercase mb-3 font-semibold text-slate-600 dark:text-white">harga normal</p>
                                        <div class="grid sm:grid-cols-3 grid-cols-2 gap-3">
                                        @foreach ($product->items as $item)
                                            @if (!$item->discount)                                                
                                                @php
                                                    $initialPrice = $item->price * 0.007 + $item->price;
                                                    $roundedPrice = ceil($initialPrice / 500) * 500;
                                                @endphp
                                                <div @click.prevent="activeItem = {{ $item->id }}; data.itemSelected = '{{ $item->item_name }}'; data.itemNominal = '{{ $item->nominal }}'; initialPrice = {{ $item->price }}; selectedItemProduct()"
                                                    :class="{ 'dark:bg-slate-600 bg-violet-500 border-2 border-solid border-violet-500 dark:border-primary-cyan-light': activeItem === {{ $item->id }}, 'bg-violet-300 hover:bg-violet-500 dark:bg-primary-slate dark:hover:bg-slate-500/90 border-2 border-solid border-violet-500 dark:border-slate-50 text-white': activeItem !== {{ $item->id }} }"
                                                    class="items sw-full {{ $item->product->item_img ? 'sm:h-[130px] h-[120px]' : 'sm:h-[100px] h-[100px]' }} grid auto-rows-fr gap-4 rounded-lg sm:p-2 p-1 cursor-pointer group"
                                                    data-item-id="{{ $item->id }}">
                                                    <p class="font-semibold capitalize text-violet-800 group-hover:text-white dark:text-white sm:text-base text-sm text-center" :class="{'text-white' : activeItem === {{ $item->id }} }">{{ $item->nominal }} - {{ $item->item_name }}</p>
                                                    @if ($item->product->item_img)
                                                    <img src="{{ asset('/storage/item/' . $item->product->product_name . "/" . $item->product->item_img) }}" :class="{ 'grayscale-0' : activeItem === {{ $item->id }} }" class="w-auto h-8 mx-auto grayscale contrast-200 group-hover:grayscale-0 transition duration-150" alt="logo_img_item">
                                                    @endif
                                                    <p class="text-sm text-violet-100 dark:text-teal-400 text-center">Rp. {{ Cash($roundedPrice, 2) }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="payment__type mt-5 bg-gradient-to-l from-violet-100 via-violet-200 to-white dark:bg-gradient-to-l dark:from-primary-slate-light/70 dark:to-primary-slate-light/70  border-2 border-violet-500 dark:border-primary-cyan-light text-white border-solid w-full p-4 rounded-lg"
                                    x-show="activeItem !== null" x-transition:enter="transition duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition duration-300"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-4">
                                    <div class="step_three flex items-center justify-between mb-5">
                                        <p class="capitalize font-semibold text-violet-800 dark:text-slate-300">Pilih metode pembayaran.</p>
                                        <div class="w-fit bg-violet-400 dark:bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 3</p>
                                        </div>
                                    </div>
                                    <div class="ERR_MESS mb-3" x-show="errMess.errorPaymentId">
                                        <p x-text="errMess.errorPaymentId"
                                            class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                                            role="errorPaymentMessage"></p>
                                    </div>
                                    @foreach ($product->paymentMethods as $payment)
                                    <div class="{{ $payment->payment_name }}__payment mb-3" @click.prevent="
                                            paymentSelected = '{{ $payment->payment_name }}'; 
                                            selectedPaymentId = '{{ $payment->id }}'; 
                                            feeType = '{{ $payment->fee ? $payment->fee->type_fee : null }}'; 
                                            fee_flat = '{{ isset($payment->fee->fee_flat) ? $payment->fee->fee_flat : 0 }}'; 
                                            fee_fixed = '{{ isset($payment->fee->fee_fixed) ? $payment->fee->fee_fixed : 0 }}'; 
                                            selectedPayment()">
                                        <div class="relative cursor-pointer group">
                                            @if ($payment->is_recommendation)
                                            <div class="best_deal_payment absolute top-2.5 right-2">
                                                <img src="{{ asset('/img/StaticImage/best_deal.png') }}"
                                                    class="w-auto h-10 grayscale group-hover:grayscale-0 filter transition duration-150"
                                                    :class="{'grayscale-0' : paymentSelected === '{{ $payment->payment_name }}' }"
                                                    alt="best_deal_logo">
                                            </div>
                                            @endif
                                            <div class="flex items-center justify-between py-2 px-4 rounded-md cursor-pointer"
                                                :class="{'dark:bg-primary-slate bg-violet-500 border-2 border-solid border-violet-500 dark:border-primary-cyan-light' : paymentSelected === '{{ $payment->payment_name }}', 'dark:bg-slate-700 bg-violet-300 border-2 border-solid hover:bg-violet-500 dark:hover:bg-slate-500 border-violet-300 dark:border-slate-300' : paymentSelected !== '{{ $payment->payment_name }}' }">
                                                <div class="sm:w-24 w-20 bg-white p-1">
                                                    <img src="{{ asset('/img/' . $payment->img_static) }}"
                                                        class="w-auto h-8 mx-auto filter transition duration-150" :class="{'grayscale-0 contrast-200' : paymentSelected === '{{ $payment->payment_name }}', 'grayscale group-hover:grayscale-0' : paymentSelected !== '{{ $payment->payment_name }}'}" alt="logo_{{ $payment->payment_name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="!handleDisblePaymentMethod() && paymentSelected === '{{ $payment->payment_name }}'"
                                        x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="detail__fee__and__price mb-3 bg-violet-300 dark:bg-slate-300 rounded-b p-1.5 flex justify-between items-center"
                                        :class="{'hidden' : isDisablePaymentMethod === true}">
                                        <p class="font-extrabold uppercase text-violet-500 dark:text-slate-600">Total Harga</p>
                                        <p class="font-extrabold uppercase text-violet-600 dark:text-slate-600" x-text="priceIncludeFee"></p>
                                    </div>
                                    <div x-show="handleDisblePaymentMethod() && paymentSelected === '{{ $payment->payment_name }}'"
                                        x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="disable__alert mb-3 bg-violet-300 dark:bg-slate-300 rounded-b p-1.5">
                                        <p class="font-extrabold uppercase text-rose-400 dark:text-rose-300">MOHON MAAF METODE
                                            pembayaran TIDAK TERSEDIA UNTUK ITEM YANG DIPILIH</p>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="additional_input mt-5 bg-gradient-to-l from-violet-100 via-violet-200 to-white dark:bg-gradient-to-l dark:from-primary-slate-light/70 dark:to-primary-slate-light/70  border-2 border-violet-500 dark:border-primary-cyan-light text-white border-solid w-full p-4 rounded-lg">
                                    <div class="step_four flex items-center justify-between mb-5">
                                        <p class="capitalize font-semibold text-violet-800 dark:text-slate-300">Detail Pembeli</p>
                                        <div class="w-fit bg-violet-400 dark:bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 4</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ERR_MESS mb-3" x-show="Object.keys(errMess).length > 0">
                                            <ul>
                                                <template x-for="errNumbPhone in errMess.errorNumberPhone" :key="errNumbPhone">
                                                    <li class="list-none mb-2 w-full bg-red-300 rounded p-1.5">
                                                        <p x-text="errNumbPhone" class="text-red-700 font-normal"
                                                            role="errNumbPhone"></p>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                        <x-form.input type="text" label="No. HP (Whatsapp)" labelClass="text-white" name="number_phone"
                                            inputClass="bg-slate-100 dark:bg-primary-slate-light text-center text-slate-700 dark:text-white p-4 border-2 dark:border-slate-400 border-violet-300 rounded-lg focus:ring-0 focus:border-violet-400 dark:focus:border-slate-400" labelClass="font-semibold text-slate-600 dark:text-white"
                                            inputName="number_phone" placeholder="Masukkan Nomor Yang Terdaftar Pada Nomor Whatsapp"
                                            modelBinding="data.number_phone" />
                                        <p class="text-xs mt-3 italic text-slate-600 dark:text-slate-300 font-thin">Silahkan masukkan No HP (Whatsapp) untuk menerima bukti pembelian Anda</p>
                                    </div>
                                </div>
                                <div class="btn_checkout md:block hidden mt-5">
                                    <button type="submit" :disabled="isButtonSubmitDisabled"
                                        class="py-3 px-6 w-full rounded-md bg-violet-500 hover:bg-violet-300 disabled:bg-violet-400 dark:bg-teal-500 dark:hover:bg-teal-300 dark:disabled:bg-teal-400 text-white disabled:text-violet-100 dark:disabled:text-teal-100 cursor-pointer disabled:cursor-not-allowed border-0">
                                        <template x-if="isButtonSubmitDisabled">
                                            <span>Pesanan Di Proses</span>
                                        </template>
                                        <template x-if="!isButtonSubmitDisabled">
                                            <div class="flex justify-center items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                                <p>Bayar Sekarang</p>
                                            </div>
                                        </template>
                                    </button>
                                </div>
                                {{-- #95D6B5 --}}
                                <div class="btn_checkout_mobile md:hidden block">
                                    <div x-show="paymentSelected && activeItem"
                                        x-transition:enter="transition-transform ease-in duration-300 transform"
                                        x-transition:enter-start="translate-y-full"
                                        x-transition:enter-end="translate-y-0"
                                        class="fixed left-0 bottom-0 w-full h-28 rounded-t-lg bg-violet-400 dark:bg-[#68D9A1] p-3">
                                        <div class="w-full h-full flex items-center justify-between">
                                            <div class="detail_order">
                                                <div class="flex items-center space-x-1 mb-1">
                                                    <p class="text-white dark:text-slate-400" x-text="data.itemNominal"></p>
                                                    <p class="text-white dark:text-slate-400">-</p>
                                                    <p class="text-sm text-white dark:text-teal-900" x-text="data.itemSelected"></p>
                                                </div>
                                                <p x-text="paymentSelected" class="font-semibold text-xs text-slate-200 dark:text-slate-700 uppercase"></p>
                                                <template x-if="priceIncludeFee && !handleDisblePaymentMethod()">
                                                    <p x-text="priceIncludeFee"
                                                        class="text-xl text-violet-700 dark:text-green-700 font-semibold"></p>
                                                </template>
                                                <template x-if="priceIncludeFee && handleDisblePaymentMethod()">
                                                    <p class="text-sm text-rose-300 dark:text-rose-400 font-extrabold">Metode Pembayaran
                                                        Invalid</p>
                                                </template>
                                            </div>
                                            <div class="btn_checkout_submit_mobile">
                                                <button type="submit" :disabled="isButtonSubmitDisabled"
                                                    class="py-3 px-10 rounded-lg bg-violet-500 hover:bg-violet-300 disabled:bg-violet-300 dark:bg-teal-500 dark:hover:bg-teal-300 dark:disabled:bg-teal-400 text-white disabled:text-violet-100 dark:disabled:text-teal-100 cursor-pointer disabled:cursor-not-allowed border-0">
                                                    <template x-if="isButtonSubmitDisabled">
                                                        <span>Pesanan Di Proses</span>
                                                    </template>
                                                    <template x-if="!isButtonSubmitDisabled">
                                                        <div class="flex justify-center items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                            </svg>
                                                            <p>Bayar Sekarang</p>
                                                        </div>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right_section lg:mt-52 mt-0 md:mx-0 mx-2 sm:mb-20 mb-10">
                        <div class="wrapper">
                            <div
                                class="top_section md:block hidden border-0 border-b border-solid border-violet-500 dark:border-slate-500 pb-4 mr-20">
                                @if (!$product->is_testing)
                                    <img src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}"
                                        class="w-28 h-28 rounded-full border-2 border-solid border-violet-500 dark:border-primary-cyan-light"
                                        alt="logo {{ $product->product_name }}">
                                @else
                                    <img src="{{ asset($product->img_url) }}" class="w-28 h-28 rounded-full border-2 border-solid border-violet-500 dark:border-primary-cyan-light" alt="Logo Product [DEV]">
                                @endif
                                <p class="mt-5 font-bold text-2xl dark:text-slate-50 text-violet-800">Top Up {{ $product->product_name }}</p>
                            </div>
                            <div class="badge md:visible invisible flex flex-wrap items-center space-x-3 mt-5">
                                <div
                                    class="badge_support flex items-center space-x-2 bg-violet-500 hover:bg-violet-400 dark:bg-slate-400 dark:hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-50 dark:text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                    <span class="font-semibold text-slate-50 dark:text-slate-600">Layanan 24 Jam</span>
                                </div>
                                <div
                                    class="badge_fast_transaction flex items-center space-x-2 bg-violet-500 hover:bg-violet-400 dark:bg-slate-400 dark:hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-50 dark:text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                    <span class="font-semibold text-slate-50 dark:text-slate-600">Proses Transaksi Cepat</span>
                                </div>
                                <div
                                    class="badge_secure_transaction flex items-center space-x-2 bg-violet-500 hover:bg-violet-400 dark:bg-slate-400 dark:hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-50 dark:text-slate-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                    <span class="font-semibold text-slate-50 dark:text-slate-600">Pembayaran Aman</span>
                                </div>
                            </div>
                            <div class="guide_topup md:mt-5 mt-0 bg-slate-50 dark:bg-primary-slate-light shadow-lg p-4 rounded-md border-2 border-solid border-violet-500 dark:border-primary-cyan-light">
                                <p class="text-slate-600 dark:text-white">Cara Top Up <span class="font-semibold text-violet-500 dark:text-primary-cyan-light">{{ $product->product_name }} :</span></p>
                                <ol class="list-decimal text-slate-600 dark:text-white text-sm space-y-2 ml-5 mt-2">
                                    <li>Masukkan ID.</li>
                                    <li>Pilih Nominal Item.</li>
                                    <li>Pilih Metode Pembayran.</li>
                                    <li>Klik Beli Sekarang dan Lakukan Pembayaran.</li>
                                    <li>Tunggu Beberapa Menit, Maka Item Yang Dibeli Akan Otomatis Masuk Di Akun
                                        Anda
                                    </li>
                                </ol>
                            </div>
                            @if (isset($custom_field) && $custom_field->detail_for_product)
                                <div class="describe_about_{{ $product->product_name }} mt-5">
                                    <p class="text-slate-400 text-4xl font-extrabold ">{{ $product->product_name }}</p>
                                    <p class="text-slate-300 pr-20 text-sm leading-normal pt-3">{!! $custom_field->detail_for_product !!}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('js-custom')
    <script>
        function handleOrder() {
            return {
                accessApiToken: '{{ $token }}',
                data: {
                    player_id: '',
                    product_id: '',
                    code_game: '',
                    zone_id: '',
                    itemSelected: '',
                    itemNominal: '',
                    number_phone: '',
                    qty: 1,
                },
                fee_flat: 0,
                fee_fixed: 0,
                feeType: '',
                initialPrice: 0,
                priceIncludeFee: 0,
                selectedPaymentId: '',
                activeItem: null,
                paymentSelected: '',
                isDisablePaymentMethod: false,
                showBestDealBanner: false,
                isButtonSubmitDisabled: false,
                errMess: {},
                showInvalidUserIDModal: false,
                errMessTooManyAttemptReq: '',

                init() {
                    this.data.product_id = '{{ $product->id }}'
                    this.data.code_game = '{{ $product->code_product }}'
                },

                // Immediately Update Price When Item Clicked
                selectedItemProduct() {
                    this.handlePaymentFee()
                    this.priceIncludeFee = this.formatPriceToRupiah(this.priceIncludeFee)
                },

                // Immediately Update Price When Payment Clicked
                selectedPayment() {
                    this.handlePaymentFee()
                    this.priceIncludeFee = this.formatPriceToRupiah(this.priceIncludeFee)
                },

                checkingValidationForm() {
                  this.isButtonSubmitDisabled = true
                  this.errMessTooManyAttemptReq = ''
                  let dataValidationUsername = 
                  {
                      code_game: this.data.code_game,
                      player_id: this.data.player_id,
                      zone_id: this.data.zone_id
                  }
                  axios.post('/api/validation-id', dataValidationUsername, {
                      headers: {
                          'X-Custom-Token': this.accessApiToken
                      }
                  }).then(res => {
                          // IF USERNAME VALID
                          if(res.data.code == 200) {
                            if (res.data.data.IS_USER_VALID) {
                                this.checkoutOrder()
                                this.isButtonSubmitDisabled = false
                              } 
                          }

                          if(res.data.code == 400) {
                              // IF USERNAME INVALID
                              this.showInvalidUserIDModal = true
                              this.isButtonSubmitDisabled = false
                          }

                          if (res.data.code == 429) {
                              this.errMessTooManyAttemptReq = res.data.message
                              this.showInvalidUserIDModal = true
                              this.isButtonSubmitDisabled = false
                          }
                  }).catch(err => { 
                    console.log("ERROR SERVERSIDE VALIDATION USER-ID")
                    this.isButtonSubmitDisabled = false
                  })
                },

                checkoutOrder() {
                    let productName = '{{ $product->slug }}'
                    let dataOrder = 
                    {
                        player_id: this.data.player_id,
                        zone_id: this.data.zone_id,
                        product_id: this.data.product_id,
                        item_id: this.activeItem,
                        payment_id: this.handleDisblePaymentMethod() ? '' : this.selectedPaymentId,
                        number_phone: this.data.number_phone,
                        price: this.convertPriceIntoInteger(),
                        before_amount: this.initialPrice,
                        qty: this.data.qty
                    }
                    
                    axios.post(`/api/order/${productName}`, dataOrder, {
                        headers: {
                            'X-Custom-Token': this.accessApiToken
                        }
                    }).then(res => {
                        if (res.data.code == 201) {
                            const invoice = res.data.data
                            window.location.replace(`/checkout/${invoice}`)
                        }
                    }).catch(err => {
                        if (err.response.status == 500) {
                            console.log(err.response.data.message)
                        }

                        if (err.response.status == 422) {
                            const resErrMess = err.response.data.errors
                            this.errMess = {
                                errorPlayerId: resErrMess.player_id,
                                errorItem: resErrMess.price,
                                errorPaymentId: resErrMess.payment_id,
                                errorNumberPhone: resErrMess.number_phone
                            }
                        }
                    })
                },

                handlePaymentFee() {
                    const normalPrice = this.initialPrice

                    if (this.feeType === 'fee_fixed') {
                        let feeFixed = this.fee_fixed
                        let calculatingFixedFee = feeFixed * 0.01 * normalPrice
                        let fee = calculatingFixedFee + normalPrice
                        this.priceIncludeFee = Math.ceil(fee / 500) * 500
                    } else if (this.feeType === 'fee_flat') {
                        let feeFlat = parseInt(this.fee_flat)
                        let calculatingFlatFee = feeFlat + normalPrice
                        this.priceIncludeFee = calculatingFlatFee
                    }
                },

                formatPriceToRupiah(price) {
                    return price.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                },

                convertPriceIntoInteger() {
                    const strPrice = this.priceIncludeFee
                    const replaceStr = strPrice ? strPrice.replace(/[^0-9]/g, "") : null
                    const priceIncludeFee = parseInt(replaceStr)
                    return priceIncludeFee / 100
                },

                handleDisblePaymentMethod() {
                    let normalPrice = this.initialPrice
                    let feeType = this.feeType

                    return normalPrice < 25000 && feeType === 'fee_flat';
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
