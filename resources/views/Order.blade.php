<x-app-layout>
@push('css-custom')
    <style>
        .container__shadaow {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background: -webkit-linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgb(29, 27, 27) 50%, rgb(15, 15, 15) 100%, rgba(0, 0, 0, 0) 0%);
            background: -moz-linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgb(29, 27, 27) 50%, rgb(15, 15, 15) 100%, rgba(0, 0, 0, 0) 0%);
            background: -ms-linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgb(29, 27, 27) 50%, rgb(15, 15, 15) 100%, rgba(0, 0, 0, 0) 0%);
            background: -o-linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgb(29, 27, 27) 50%, rgb(15, 15, 15) 100%, rgba(0, 0, 0, 0) 0%);
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgb(29, 27, 27) 50%, rgb(15, 15, 15) 100%, rgba(0, 0, 0, 0) 0%);
        }
    </style>        
@endpush
    <div class="w-full h-full overflow-x-hidden bg-[#0F0F0F]" x-data="handleOrder()">
        <div class="relative z-[9999] md:block hidden">
            <div
                class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate-light/90 border-0 border-solid border-b border-r border-primary-cyan-light absolute">
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
                        <a href="{{ Route('order', ['slug' => $product->slug]) }}"
                            class="text-gray-200 hover:text-gray-400 transition-colors duration-150 no-underline">Order</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                </ul>
            </div>
        </div>
        @if (!is_null($custom_field))
        <img src="{{ asset('/storage/' . $custom_field->bg_img_on_order_page) }}"
            class="custom__bg__img w-full md:h-[700px] h-[300px] object-cover bg-no-repeat bg-top z-10 absolute md:top-[114px] top-[85px]"
            alt="{{ asset('/storage/' . $custom_field->bg_img_on_order_page) }}">
        @else
        <img src="https://source.unsplash.com/random/1920x800"
            class="w-full md:h-[700px] h-[300px] object-cover bg-no-repeat bg-top z-10 absolute md:top-[114px] top-[85px]"
            alt="random_img">
        @endif
        <div class="container__shadaow w-full md:h-[900px] h-[400px] absolute overflow-x-hidden z-20 bg-white"></div>
        <section class="content w-full h-full md:mx-10 mx-0 z-50 relative">

            @include('mobile.header_order_mobile')
            <div class="wrapper_grid">
                <div class="grid md:grid-cols-2 grid-cols-1 gap-5">
                    <div class="left_section md:mt-52 mt-5 md:mb-10 mb-0">
                        {{-- #1a1919 --}}
                        {{-- #222224 --}}
                        <div
                            class="form_wrapper w-full h-fit p-8 rounded-lg md:shadow-lg shadow-slate-800 bg-[#25262b]">
                            <form @submit.prevent="checkoutOrder" method="POST">
                                <div
                                    class="add_player_id bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded">
                                    <div class="step_one flex justify-between items-center mb-3">
                                        <p class="font-semibold text-slate-300 capitalize">{!!
                                            $custom_field->text_title_on_order_page ?? 'Masukkan Player ID Anda'
                                            !!}
                                        </p>
                                        <div class="w-fit bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 1</p>
                                        </div>
                                    </div>
                                    <div class="ERR_MESS" x-show="errMess.errorPlayerId">
                                        <p x-text="errMess.errorPlayerId"
                                            class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                                            role="errorPLayerIDMessage"></p>
                                    </div>
                                    <x-form.input type="text" label="" modelBinding="data.player_id" name="player_id"
                                        inputClass="bg-primary-slate text-white p-4 border-slate-500 rounded-md focus:ring-0 focus:border-slate-400"
                                        inputName="player_id" placeholder="Player ID ex: '45878782'" />
                                    <p class="text-xs mt-3 italic text-gray-300 font-thin">
                                        {!! $custom_field->description_on_order_page ?? '' !!}</p>
                                </div>
                                <div
                                    class="item_product mt-5 bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded">
                                    <div class="step_two flex items-center justify-between">
                                        <p class="capitalize font-semibold text-slate-300">Pilih jumlah nominal item.
                                        </p>
                                        <div class="w-fit bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 2</p>
                                        </div>
                                    </div>
                                    <div class="ERR_MESS mb-3 mt-3" x-show="errMess.errorItem">
                                        <p x-text="errMess.errorItem"
                                            class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                                            role="errorItemMessage"></p>
                                    </div>
                                    <ul class="list-none flex flex-wrap justify-center mx-0 items-center gap-3 mt-3">
                                        @foreach ($product->items as $item)
                                        <li>
                                            @if ($item->discount)
                                                @php
                                                    $initialPrice = $item->discount->price_after_discount * 0.007 + $item->discount->price_after_discount;
                                                    $roundedPrice = ceil($initialPrice / 500) * 500;
                                                @endphp
                                                <div @click.prevent="activeItem = {{ $item->id }}; data.itemSelected = '{{ $item->item_name }}'; data.itemNominal = '{{ $item->nominal }}'; initialPrice = {{ $item->discount->price_after_discount }}; selectedItemProduct()"
                                                    :class="{ 'bg-slate-300/60 border-rose-500': activeItem === {{ $item->id }}, 'bg-slate-500 hover:bg-slate-300/90 border-[1px] border-white text-white': activeItem !== {{ $item->id }} }"
                                                    class="items w-[180px] h-[100px] flex flex-col justify-center items-center space-y-1 rounded-md p-2
                                                border border-gray-400 border-solid cursor-pointer"
                                                    data-item-id="{{ $item->id }}">
                                                    <p class="font-semibold capitalize">{{ $item->nominal }} -
                                                        {{ $item->item_name }}</p>
                                                    <p class="text-xs">Harga</p>
                                                    <p class="text-xs text-rose-500 line-through">Rp. {{ Cash($item->price, 2) }}</p>
                                                    <p class="text-sm text-teal-400">Rp. {{ Cash($item->discount->price_after_discount, 2) }}</p>
                                                </div>
                                            @else
                                                @php
                                                    $initialPrice = $item->price * 0.007 + $item->price;
                                                    $roundedPrice = ceil($initialPrice / 500) * 500;
                                                @endphp
                                                <div @click.prevent="activeItem = {{ $item->id }}; data.itemSelected = '{{ $item->item_name }}'; data.itemNominal = '{{ $item->nominal }}'; initialPrice = {{ $item->price }}; selectedItemProduct()"
                                                    :class="{ 'bg-slate-300/60 border-rose-500': activeItem === {{ $item->id }}, 'bg-slate-500 hover:bg-slate-300/90 border-[1px] border-white text-white': activeItem !== {{ $item->id }} }"
                                                    class="items w-[180px] h-[100px] flex flex-col justify-center items-center space-y-2 rounded-md p-2
                                                    border border-gray-400 border-solid cursor-pointer"
                                                    data-item-id="{{ $item->id }}">
                                                    <p class="font-semibold capitalize">{{ $item->nominal }} -
                                                        {{ $item->item_name }}</p>
                                                    <p class="text-xs">Harga</p>
                                                    <p class="text-sm text-teal-400">Rp. {{ Cash($roundedPrice, 2) }}</p>
                                                </div>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="payment__type mt-5 bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded"
                                    x-show="activeItem !== null" x-transition:enter="transition duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition duration-300"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-4">
                                    <div class="step_three flex items-center justify-between mb-5">
                                        <p class="capitalize font-semibold text-slate-300">Pilih metode pembayaran.</p>
                                        <div class="w-fit bg-primary-slate text-white p-2 rounded-lg md:block hidden">
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
                                        <div
                                            class="relative cursor-pointer group hover:bg-slate-400/60 transition duration-300">
                                            @if ($payment->is_recommendation)
                                            <div class="best_deal_payment absolute top-1 right-2">
                                                <img src="{{ asset('/img/StaticImage/best_deal.png') }}"
                                                    class="w-auto h-10 grayscale group-hover:grayscale-0 filter"
                                                    :class="{'grayscale-0' : paymentSelected === '{{ $payment->payment_name }}' }"
                                                    alt="best_deal_logo">
                                            </div>
                                            @endif
                                            <label for="{{ $payment->payment_name }}__payment"
                                                class="flex items-center justify-between py-2 px-4 rounded border border-solid cursor-pointer"
                                                :class="{'bg-slate-300 border-slate-300/60' : paymentSelected === '{{ $payment->payment_name }}', 'bg-slate-400/90 hover:bg-slate-300 border-gray-400' : paymentSelected !== '{{ $payment->payment_name }}' }">
                                                <img src="{{ asset('/img/' . $payment->img_static) }}"
                                                    class="w-auto h-8" alt="logo_{{ $payment->payment_name }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div x-show="!handleDisblePaymentMethod() && paymentSelected === '{{ $payment->payment_name }}'"
                                        x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="detail__fee__and__price mb-3 bg-slate-300 rounded-b p-1.5 flex justify-between items-center"
                                        :class="{'hidden' : isDisablePaymentMethod === true}">
                                        <p class="font-extrabold uppercase text-slate-600">Total Harga</p>
                                        <p class="font-extrabold uppercase text-slate-600" x-text="priceIncludeFee"></p>
                                    </div>
                                    <div x-show="handleDisblePaymentMethod() && paymentSelected === '{{ $payment->payment_name }}'"
                                        x-transition:enter="transition-opacity duration-300"
                                        x-transition:leave="transition-opacity duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        class="disable__alert mb-3 bg-slate-400 rounded-b p-1.5">
                                        <p class="font-extrabold uppercase text-rose-300">MOHON MAAF METODE
                                            pembayaran TIDAK TERSEDIA UNTUK ITEM YANG DIPILIH</p>
                                    </div>
                                    @endforeach
                                </div>
                                <div
                                    class="additional_input mt-5 bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded">
                                    <div class="step_four flex items-center justify-between mb-5">
                                        <p class="capitalize font-semibold text-slate-300">Detail Pembeli (Opsional)</p>
                                        <div class="w-fit bg-primary-slate text-white p-2 rounded-lg md:block hidden">
                                            <p>STEP 4</p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ERR_MESS mb-3" x-show="Object.keys(errMess).length > 0">
                                            <ul>
                                                <template x-for="errEmail in errMess.errorEmail" :key="errEmail">
                                                    <li class="list-none mb-2 w-full bg-red-300 rounded p-1.5">
                                                        <p x-text="errEmail" class="text-red-700 font-normal"
                                                            role="errorEmailMessage"></p>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                        <x-form.input type="text" label="Email" labelClass="text-white" name="email"
                                            inputClass="bg-primary-slate text-white p-4 border-slate-500 rounded-md focus:ring-0 focus:border-slate-400"
                                            inputName="email" placeholder="Masukkan Alamat Email Valid Anda...."
                                            modelBinding="data.email" />
                                        <p class="text-xs mt-3 italic text-gray-300 font-thin">Silahkan masukkan
                                            email
                                            anda jika ingin menerima bukti pembelian Anda</p>
                                    </div>
                                </div>
                                <div class="btn_checkout md:block hidden mt-5">
                                    <button type="submit" :disabled="isButtonSubmitDisabled"
                                        class="py-3 px-6 rounded-md bg-teal-500 disabled:bg-teal-400 text-white disabled:text-teal-100 cursor-pointer disabled:cursor-not-allowed border-0">
                                        <template x-if="isButtonSubmitDisabled">
                                            <span>Pesanan Di Proses</span>
                                        </template>
                                        <template x-if="!isButtonSubmitDisabled">
                                            <span>Bayar Sekarang</span>
                                        </template>
                                    </button>
                                </div>
                                {{-- #95D6B5 --}}
                                <div class="btn_checkout_mobile md:hidden block">
                                    <div x-show="paymentSelected && activeItem"
                                        x-transition:enter="transition-transform ease-in duration-300 transform"
                                        x-transition:enter-start="translate-y-full"
                                        x-transition:enter-end="translate-y-0"
                                        class="fixed left-0 bottom-0 w-full h-28 rounded-t-lg bg-[#68D9A1] p-3">
                                        <div class="w-full h-full flex items-center justify-between">
                                            <div class="detail_order">
                                                <div class="flex items-center space-x-1 mb-1">
                                                    <p x-text="data.itemNominal"></p>
                                                    <p>-</p>
                                                    <p class="text-sm text-teal-900" x-text="data.itemSelected"></p>
                                                </div>
                                                <p x-text="paymentSelected"
                                                    class="font-semibold text-xs text-slate-700 uppercase"></p>
                                                <template x-if="priceIncludeFee && !handleDisblePaymentMethod()">
                                                    <p x-text="priceIncludeFee"
                                                        class="text-xl text-green-700 font-semibold"></p>
                                                </template>
                                                <template x-if="priceIncludeFee && handleDisblePaymentMethod()">
                                                    <p class="text-sm text-rose-400 font-extrabold">Metode Pembayaran
                                                        Invalid</p>
                                                </template>
                                            </div>
                                            <div class="btn_checkout_submit">
                                                <button type="submit" :disabled="isButtonSubmitDisabled"
                                                    class="py-3 px-10 rounded-lg bg-teal-600 disabled:bg-teal-400 text-white cursor-pointer disabled:cursor-not-allowed border-0">
                                                    <template x-if="isButtonSubmitDisabled">
                                                        <span>Pesanan Di Proses</span>
                                                    </template>
                                                    <template x-if="!isButtonSubmitDisabled">
                                                        <span>Bayar Sekarang</span>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right_section md:mt-52 mt-5 md:mx-0 mx-4 mb-10">
                        <div class="wrapper">
                            <div
                                class="top_section md:block hidden border-0 border-b border-solid border-slate-500 pb-4 mr-20">
                                <img src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}"
                                    class="w-28 h-28 rounded-full border border-solid border-slate-400"
                                    alt="logo {{ $product->product_name }}">
                                <p class="mt-5 font-bold text-2xl text-white">Top Up
                                    Game [{{ $product->product_name }}]</p>
                            </div>
                            <div class="badge md:visible invisible flex flex-wrap items-center space-x-3 mt-5">
                                <div
                                    class="badge_support flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                    <span class="font-semibold">Layanan 24 Jam</span>
                                </div>
                                <div
                                    class="badge_fast_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                    <span class="font-semibold">Proses Transaksi Cepat</span>
                                </div>
                                <div
                                    class="badge_secure_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                    <span class="font-semibold">Pembayaran Aman</span>
                                </div>
                            </div>
                            <div class="guide_topup md:mt-5 mt-0">
                                <p class="text-white">Cara Top Up <span
                                        class="font-semibold underline">{{ $product->product_name }} :</span></p>
                                <ol class="list-decimal text-white text-sm space-y-2 ml-5 mt-2">
                                    <li>Masukkan ID.</li>
                                    <li>Pilih Nominal Item.</li>
                                    <li>Pilih Metode Pembayran.</li>
                                    <li>Klik Beli Sekarang dan Lakukan Pembayaran.</li>
                                    <li>Tunggu Beberapa Menit, Maka Item Yang Dibeli Akan Otomatis Masuk Di Akun
                                        Anda
                                    </li>
                                </ol>
                            </div>
                            <div class="describe_about_{{ $product->product_name }} mt-5">
                                <p class="text-slate-400 text-4xl font-extrabold">{{ $product->product_name }}</p>
                                <p class="text-slate-300 pr-20 text-sm leading-normal pt-3">{!!
                                    $custom_field->detail_for_product ?? '' !!}</p>
                            </div>
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
                data: {
                    player_id: '',
                    product_id: '',
                    itemSelected: '',
                    itemNominal: '',
                    email: '',
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

                init() {
                    this.data.product_id = '{{ $product->id }}'
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

                checkoutOrder() {
                    let productName = '{{ $product->slug }}'
                    let dataOrder = {
                        player_id: this.data.player_id,
                        product_id: this.data.product_id,
                        item_id: this.activeItem,
                        payment_id: this.handleDisblePaymentMethod() ? '' : this.selectedPaymentId,
                        email: this.data.email,
                        price: this.convertPriceIntoInteger(),
                        before_amount: this.initialPrice,
                        qty: this.data.qty
                    }
                    this.isButtonSubmitDisabled = true
                    try {
                        axios.get('/api/get-token').then(res => {
                            const token = res.data.data
                            axios.post(`/api/order/${productName}`, dataOrder, {
                                headers: {
                                    'X-Custom-Token': `${token}`
                                }
                            }).then(res => {
                                if (res.data.code == 201) {
                                    const invoice = res.data.data
                                    window.location.replace(`/checkout/${invoice}`)
                                }
                                this.isButtonSubmitDisabled = false
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
                                        errorEmail: resErrMess.email
                                    }
                                }
                                this.isButtonSubmitDisabled = false
                            })
                        })
                    } catch (error) {
                        console.log("ERROR STATUS CODE 500")
                    }
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

                    return normalPrice < 11000 && feeType === 'fee_flat';
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
