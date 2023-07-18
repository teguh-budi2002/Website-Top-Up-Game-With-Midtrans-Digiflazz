<style>
    .custom__bg__img {
        background-repeat: no-repeat;
        background-position: bottom;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
    }

    .custom__shadow {
        filter: blur(4px);
        box-shadow: inset 0 30px 9px -7px #1d1c1c7f;
    }
</style>
<x-app-layout>
    <x-slot:header>

    </x-slot:header>
    {{-- bg-primary-slate/90 --}}
    <div class="bg-primary-slate/90 h-full w-full relative">
        <img src="{{ asset('/storage/' . $custom_field->bg_img_on_order_page) }}"
            class="custom__bg__img w-full h-[783px] absolute top-0 object-cover z-10" alt="">
        <div class="custom__shadow w-full h-full bg-primary-slate absolute left-0 top-80 z-20"></div>
        <div class="w-10/12 mx-auto">
            <div class="grid grid-cols-2 gap-5">
                <div class="left_section mt-96 mb-5 z-20">
                    <form action="" x-data="handleOrder()">
                        <div
                            class="add_player_id bg-slate-500 border border-white text-white border-solid w-full p-4 rounded">
                            <div class="step_one flex justify-between">
                                <p>{{ $custom_field->text_title_on_order_page ?? 'Masukkan Player ID Anda' }}</p>
                                <div class="w-fit bg-primary-slate-light text-white p-2 rounded-lg">
                                    <p>STEP 1</p>
                                </div>
                            </div>
                            <x-form.input type="text" label="" name="player_id" inputName="player_id"
                                placeholder="Player ID ex: '45878782'" />
                            <p class="text-xs mt-3 italic text-gray-300 font-thin">
                                {{ $custom_field->description_on_order_page ?? '' }}</p>
                        </div>
                        <div
                            class="item_product mt-5 bg-slate-500 border border-white text-white border-solid w-full p-4 rounded">
                            <div class="step_two flex items-center justify-between">
                                <p class="capitalize">Pilih jumlah nominal item.</p>
                                <div class="w-fit bg-primary-slate-light text-white p-2 rounded-lg">
                                    <p>STEP 2</p>
                                </div>
                            </div>
                            <ul class="list-none flex flex-wrap items-center gap-3 mt-3" x-data="{activeItem : null}">
                                @foreach ($product->items as $item)
                                <li>
                                    <div @click="activeItem = {{ $item->id }}"
                                        :class="{ 'bg-slate-300/60 border-blue-600': activeItem === {{ $item->id }}, 'bg-slate-500 border-[1px] border-white text-white': activeItem !== {{ $item->id }} }"
                                        class="items w-[200px] h-[100px] flex flex-col justify-center items-center space-y-2 rounded-md p-2 border border-gray-400 border-solid cursor-pointer"
                                        data-item-id="{{ $item->id }}">
                                        <p class="font-semibold capitalize">{{ $item->nominal }} -
                                            {{ $item->item_name }}</p>
                                        <p class="text-xs">Harga</p>
                                        <p class="text-sm text-rose-600">Rp. {{ Cash($item->price, 2) }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="payment__type mt-5 bg-slate-500 border border-white text-white border-solid w-full p-4 rounded"
                            x-data="{ paymentSelected: '' }">
                            <div class="step_two flex items-center justify-between mb-5">
                                <p class="capitalize">Pilih metode pembayaran.</p>
                                <div class="w-fit bg-primary-slate-light text-white p-2 rounded-lg">
                                    <p>STEP 3</p>
                                </div>
                            </div>
                            <div class="gopay__payment mb-3" @click="paymentSelected = 'gopay__payment'">
                                <label for="gopay__payment"
                                    class="flex items-center justify-between py-2 px-4 rounded border-2 border-solid border-white cursor-pointer "
                                    :class="{'bg-slate-300/60 border-blue-500' : paymentSelected === 'gopay__payment' }">
                                    <input type="radio" name="payment" class="hidden" id="gopay__payment">
                                    <img src="{{ asset('/img/PaymentLogo/gopay.png') }}" class="w-auto h-8"
                                        alt="logo_gopay">
                                </label>
                            </div>
                            <div class="dana__payment" @click="paymentSelected = 'dana__payment'">
                                <label for="dana__payment"
                                    class="flex items-center justify-between py-2 px-4 rounded border border-solid border-white cursor-pointer "
                                    :class="{'bg-slate-300/60 border-blue-500' : paymentSelected === 'dana__payment' }">
                                    <input type="radio" name="payment" class="hidden" id="dana__payment">
                                    <img src="{{ asset('/img/PaymentLogo/dana.webp') }}" class="w-auto h-8"
                                        alt="logo_gopay">
                                </label>
                            </div>
                        </div>
                        <div class="btn_checkout mt-5">
                            <button class="py-2.5 px-6 rounded-md bg-teal-500 text-white">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
                <div class="right_section">
                    <p class="text-white">INI NANTI CONTENT</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function handleOrder() {
            return {

            }
        }

    </script>
</x-app-layout>
