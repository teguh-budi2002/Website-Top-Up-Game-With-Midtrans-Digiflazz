<x-app-layout>
    <div class="bg-primary-slate-light h-full w-full" x-data="handlePurchaseOrder()">
        <div class="md:block hidden">
            <div
                class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate border-0 border-solid border-b border-r border-primary-cyan-light">
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
                        <span
                            class="text-gray-200 hover:text-gray-400 transition-colors duration-150 no-underline cursor-pointer">Checkout</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                </ul>
            </div>
        </div>
        <main class="w-full h-full min-h-screen">
            <div class="w-full flex justify-center items-center">
                <div x-show="isLoading" class="loading__animation w-fit h-auto p-6 rounded-md mt-20 bg-primary-slate">
                    <svg class="cart" role="img" aria-label="Shopping cart line animation" viewBox="0 0 128 128"
                        width="128px" height="128px" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8">
                            <g class="cart__track" stroke="hsla(0,10%,10%,0.1)">
                                <polyline points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" />
                                <circle cx="43" cy="111" r="13" />
                                <circle cx="102" cy="111" r="13" />
                            </g>
                            <g class="cart__lines" stroke="currentColor">
                                <polyline class="cart__top" points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80"
                                    stroke-dasharray="338 338" stroke-dashoffset="-338" />
                                <g class="cart__wheel1" transform="rotate(-90,43,111)">
                                    <circle class="cart__wheel-stroke" cx="43" cy="111" r="13"
                                        stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                                </g>
                                <g class="cart__wheel2" transform="rotate(90,102,111)">
                                    <circle class="cart__wheel-stroke" cx="102" cy="111" r="13"
                                        stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                                </g>
                            </g>
                        </g>
                    </svg>
                    <p class="font-semibold text-slate-500 text-xl">Mohon Tunggu Sebentar, Kami Sedang Memproses Pesanan
                        Kamu.</p>
                </div>
                <div x-show="!isLoading" class="box__invoice mt-10 mb-10 w-3/4 h-auto p-2 bg-white border border-solid border-black">
                    <div class="header_inv flex items-center justify-between">
                        <p class="text-start font-extrabold text-slate-600 text-2xl">INVOICE</p>
                        <div class="right_section flex items-center space-x-2">
                            <div class="store_name_and_logo">
                                <p class="text-xl font-bold text-end">{{ env('APP_NAME') }}</p>
                                <p class="text-xs">{{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}
                                </p>
                            </div>
                            <img src="{{ asset('/img/logo_with_bg.png') }}" class="w-20 h-20" alt="logo_website">
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_invoice grid grid-cols-2 gap-2">
                        <div class="title_inv">
                            <p>Nomor Invoice</p>
                            <p>Tanggal</p>
                        </div>
                        <div class="description_inv">
                            <p class="text-slate-600 font-semibold">: {{ $detail_order->invoice }}</p>
                            <p class="text-slate-600 font-semibold">: {{ $detail_order->created_at->format('d F y') }}
                            </p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_customer grid grid-cols-2 gap-2">
                        <div class="title_inv">
                            <p>Email</p>
                        </div>
                        <div class="description_inv">
                            <p class="text-slate-600 font-semibold">:
                                {{ $detail_order->email ? $detail_order->email : "XXXXXX@gmail.com" }}</p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_customer_order mt-4">
                        <table class="table-auto w-full">
                            <thead class="bg-slate-600 text-slate-400 border-0 border-b border-solid border-slate-400">
                                <th class="p-1.5">No</th>
                                <th class="p-1.5">Nama Produk</th>
                                <th class="p-1.5">Jumlah Pembelian</th>
                                <th class="p-1.5">Total Harga</th>
                            </thead>
                            <tr>
                                <tbody class="bg-slate-400">
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold">1</p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold">
                                                {{ $detail_order->product->product_name }}</p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold">{{ $detail_order->qty }}</p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold">Rp. {{ Cash($detail_order->price, 2) }}
                                            </p>
                                        </div>
                                    </td>
                                </tbody>
                            </tr>
                        </table>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_payment grid grid-cols-2 gap-2">
                        <div class="title_payment">
                            <p>Pembayaran</p>
                        </div>
                        <div class="description_payment">
                            <img src="{{ asset('/img/' . $detail_order->payment->img_static) }}" class="w-20 h-auto"
                                alt="detail payment">
                        </div>
                    </div>
                    <hr class="dashed_border mt-1 mb-1">
                    <div class="detail_player_id grid grid-cols-2 gap-2">
                        <div class="title_player_id">
                            <p>Game ID</p>
                        </div>
                        <div class="description_player_id">
                            <p class="text-slate-600 font-semibold">: {{ $detail_order->player_id }}</p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-1 mb-1">
                    <div class="detail_status_transaction grid grid-cols-2 gap-2 mt-2">
                        <div class="title_player_id">
                            <p>Status Transaksi</p>
                        </div>
                        <div class="description_player_id">
                            <button type="button" class="text-white py-1.5 px-6 rounded font-semibold"
                             :class="{
                                'bg-yellow-400': transaction_status === 'pending',
                                'bg-rose-400': transaction_status === 'expire',
                                'bg-green-400': transaction_status === 'settlement'
                            }">
                                <p x-text="transaction_status === 'pending' ? 'Belum Dibayar' : (transaction_status === 'expire' ? 'Kadaluarsa' : 'Sudah Dibayar')"></p>
                            </button>
                        </div>
                    </div>
                    <hr class="dashed_border mt-1 mb-1">
                    <div class="expired_order grid grid-cols-2 gap-2 mt-2">
                        <div class="text_expirder_order">
                            <p>Bayar Sebelum</p>
                        </div>
                        <div class="description_expired_order">
                          <div class="right_item flex items-center space-x-2">
                            <div class="minutes w-fit text-center p-1 px-2 bg-primary-slate flex items-center space-x-2 rounded">
                              <p class="text-rose-400 font-semibold" x-text="countdown.minutes"></p>
                              <p class="text-slate-500 font-semibold">Menit</p>
                            </div>
                            <p class="font-extrabold text-primary-slate">:</p>
                            <div class="minutes w-fit text-center p-1 px-2 bg-primary-slate flex items-center space-x-2 rounded">
                              <p class="text-rose-400 font-semibold" x-text="countdown.seconds"></p>
                              <p class="text-slate-500 font-semibold">Detik</p>
                            </div>
                          </div>
                        </div>
                    </div>
                    <img src="{{ $detail_trx->qr_code_url }}" alt="QR Code">
                </div>
            </div>
        </main>
    </div>
    @push('js-custom')
    <script>
        const orderStart = "{{ date('Y-m-d\\TH:i:s', strtotime($detail_trx->transaction_time)) }}"
        const orderEnd = "{{ date('Y-m-d\\TH:i:s', strtotime($detail_trx->transaction_expired)) }}"
        const getEndTime = new Date(orderEnd).getTime(); 
        function handlePurchaseOrder() {
            return {
                transaction_status: '',
                isLoading: null,
                end: getEndTime,
                countdown: {
                    minutes: 0,
                    seconds: 0,
                },

                init() {
                  this.initializeStaturOrder()

                  this.isLoading = true
                  this.getStatusOrder('{{ $detail_order->trx_id }}')
                },

                initializeStaturOrder() {
                  const intervalCheckStatusOrder = setInterval(() => {
                      const now = Date.now();
                      if (now <= this.end) {
                          this.calculateCountdown(this.end);
                        } else {
                          clearInterval(intervalCheckStatusOrder);
                        }
                    }, 1000);
                },

                getStatusOrder(trx_id) {
                    axios.get(`/api/order/purchase/status/${trx_id}`)
                        .then(res => {
                            this.isLoading = false
                            const response = res.data.data
                            this.transaction_status = response.transaction_status
                        }).catch(err => {
                           this.isLoading = false
                          console.log("STATUS ORDER ERROR")
                        })
                },

                calculateCountdown(targetTime) {
                    const timeDiff = targetTime - Date.now();
                    this.countdown.minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    this.countdown.seconds = Math.floor((timeDiff % (1000 * 60)) / 1000).toString().padStart(2, '0');
                },
            }
        }

    </script>
    @endpush
</x-app-layout>
