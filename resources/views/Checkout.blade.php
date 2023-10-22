<x-app-layout>
    <div class="bg-primary-slate h-full w-full" x-data="handlePurchaseOrder()">
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
                <div x-show="isLoading" class="loading__animation w-fit h-auto p-6 rounded-md mt-20 bg-primary-slate-light/80">
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
                    <p class="font-semibold text-slate-500 sm:text-xl text-sm text-center">Mohon Tunggu Sebentar, Kami Sedang Memproses Pesanan
                        Kamu.</p>
                </div>
                <div x-show="!isLoading" x-cloak
                    class="box__invoice mt-10 mb-10 sm:w-5/6 md:w-3/4 w-11/12 h-auto p-6 bg-primary-slate-light/80 border border-solid border-black rounded-lg">
                    <div class="header_inv flex items-center justify-between md:flex-row flex-col">
                        <div class="left_section flex items-start space-x-2">
                            @if (app('seo_data')->logo_website)
                            <img src="{{ asset('/storage/seo/logo/website/' . app('seo_data')->logo_website) }}"
                                class="w-20 h-20 rounded md:block hidden" alt="logo_website">
                            @else
                            <img src="{{ asset('/img/logo_with_bg.png') }}" class="w-20 h-20 rounded md:block hidden"
                                alt="logo_website">
                            @endif
                            <div class="store_name_and_logo md:text-start text-center">
                                <p class="text-2xl font-bold text-slate-300">{{ app('seo_data')->name_of_the_company }}</p>
                                <p class="text-xs text-slate-100">{{ app('seo_data')->description }}</p>
                            </div>
                        </div>
                        <p class="font-extrabold text-slate-300 text-4xl md:mt-0 mt-4">INVOICE</p>
                    </div>
                    <p class="font-extrabold text-xl md:mt-10 mt-8 text-slate-100">DETAIL PESANAN</p>
                    <hr class="dashed_border mt-5 mb-1">
                    <div class="detail_invoice grid md:grid-cols-2 grid-cols-7 gap-2">
                        <div class="title_inv text-slate-300 md:col-span-1 col-span-2">
                            <p>Invoice</p>
                        </div>
                        <div class="description_inv text-slate-100 md:text-base text-sm md:col-span-1 col-span-5">
                            <div class="flex items-center space-x-1">
                                <p class="font-semibold">:</p>
                                <p id="invoice-order" class="font-semibold" x-text="detail_order.invoice"></p>
                                <i @click="copyToClipboardInvoice()" class="fa-solid fa-copy cursor-pointer ml-2 text-yellow-400 click_to_copy"></i>
                                <span x-show="copiedInvoice" x-transition.duration.300ms class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2 rounded ml-2 sm:block hidden">Invoice Copied</span>
                                <i x-show="copiedInvoice" x-transition.duration.300ms class="fa-solid fa-check sm:hidden block p-0.5 bg-green-100 border-solid border-[1px] border-green-500 text-green-600 rounded text-center"></i>
                            </div>
                        </div>
                    </div>
                    <hr class="dashed_border mt-1 mb-1">
                    <div class="detail_create_trx grid md:grid-cols-2 grid-cols-7 gap-2">
                        <div class="title_inv text-slate-300 md:col-span-1 col-span-2">
                            <p>Tanggal</p>
                        </div>
                        <div class="description_create_inv text-slate-100 md:text-base text-sm md:col-span-1 col-span-5">
                            <p class="font-semibold">: <span x-text="detail_order.created_at"></span></p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_customer grid md:grid-cols-2 grid-cols-7 gap-2">
                        <div class="title_inv text-slate-300 md:col-span-1 col-span-2">
                            <p>No. HP</p>
                        </div>
                        <div class="description_inv md:col-span-1 col-span-5">
                            <p class="text-slate-100 md:text-base text-sm font-semibold ">:
                                <span x-text="detail_order.number_phone ? detail_order.number_phone : 'Keterangan No HP Tidak Dicantumkan'"></span>
                            </p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_customer_order mt-4 overflow-x-scroll no-scrollbar">
                        <table class="sm:w-full w-[500px]">
                            <thead class="bg-slate-600 text-slate-400 border-0 border-b border-solid border-slate-400">
                                <th class="p-1.5 md:text-base text-sm">#</th>
                                <th class="p-1.5 md:text-base text-sm">Nama Produk</th>
                                <th class="p-1.5 md:text-base text-sm">Jumlah Pembelian</th>
                                <th class="p-1.5 md:text-base text-sm">Total Harga</th>
                            </thead>
                            <tr>
                                <tbody class="bg-slate-400 md:w-full w-72">
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold">1</p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold md:text-base text-sm">
                                              <span x-text="detail_order && detail_order.product ? detail_order.product.product_name : ''"></span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold md:text-base text-sm">
                                              <span x-text="detail_order && detail_order.item ? detail_order.item.nominal : ''"></span>
                                              <span>-</span>
                                              <span x-text="detail_order && detail_order.item ? detail_order.item.item_name : ''"></span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-1.5">
                                        <div class="text-center">
                                            <p class="text-white font-semibold md:text-base text-sm">
                                              Rp. <span x-text="detail_order.price ? detail_order.price.toLocaleString('id-ID', {'currency' : 'IDR'}) : ''"></span>
                                            </p>
                                        </div>
                                    </td>
                                </tbody>
                            </tr>
                        </table>
                    </div>
                    <hr class="dashed_border mt-3 mb-1">
                    <div class="detail_player_id grid md:grid-cols-2 grid-cols-7 gap-2">
                        <div class="title_player_id text-slate-300 md:col-span-1 col-span-2">
                            <p>Game ID</p>
                        </div>
                        <div class="description_player_id md:col-span-1 col-span-5">
                            <p class="text-slate-100 md:text-base text-sm font-semibold">: <span x-text="detail_order.player_id && detail_order.zone_id ? `${detail_order.player_id} - (${detail_order.zone_id})` : `${detail_order.player_id}`"></span></p>
                        </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-3">
                    <div class="detail_payment grid md:grid-cols-2 grid-cols-7 gap-2">
                        <div class="title_payment text-slate-300 md:col-span-1 col-span-3">
                            <p>Pembayaran</p>
                        </div>
                        <div class="description_payment bg-white w-fit rounded p-1 md:col-span-1 col-span-4">
                            <img :src="`/img/${detail_order && detail_order.payment ? detail_order.payment.img_static : ''}`" class="w-20 h-auto"
                                alt="detail payment">
                        </div>
                    </div>
                    <hr class="dashed_border mt-3 mb-1">
                    <div class="detail_status_payment_transaction grid md:grid-cols-2 grid-cols-7 gap-2 mt-2">
                        <div class="title_player_id text-slate-300 md:col-span-1 col-span-3">
                            <p>Status Pembayaran</p>
                        </div>
                        <div class="status_payment md:text-base text-sm md:col-span-1 col-span-4">
                            <button type="button" class="text-white md:py-1 md:px-2 px-1 rounded font-semibold" 
                            :class="{
                                'bg-yellow-100 border-solid border-2 border-yellow-500 text-yellow-600':  detail_trx.transaction_payment_status   === 'Pending',
                                'bg-rose-100 border-solid border-2 border-rose-500 text-rose-600':    detail_trx.transaction_payment_status   === 'Expired',
                                'bg-rose-100 border-solid border-2 border-rose-500 text-rose-600':    detail_trx.transaction_payment_status   === 'Failure',
                                'bg-green-100 border-solid border-2 border-green-500 text-green-600':   detail_trx.transaction_payment_status   === 'Success',
                            }">
                            <p
                             :class="{
                                'text-yellow-600':  detail_trx.transaction_payment_status   === 'Pending',
                                'text-rose-600':    detail_trx.transaction_payment_status   === 'Expired',
                                'text-rose-600':    detail_trx.transaction_payment_status   === 'Failure',
                                'text-green-600':   detail_trx.transaction_payment_status   === 'Success',
                            }"
                             x-text="detail_trx.transaction_payment_status === 'Pending' ? 'Menunggu Pembayaran' : (detail_trx.transaction_payment_status === 'Expired' ? 'Kadaluarsa' : (detail_trx.transaction_payment_status === 'Failure') ? 'Pembayaran Gagal' : 'Pembayaran Berhasil')"></p>
                            </button>
                        </div>
                    </div>
                    <hr class="dashed_border mt-3 mb-1">
                    <div class="detail_status_order_transaction grid md:grid-cols-2 grid-cols-7 gap-2 mt-2">
                        <div class="title_player_id text-slate-300 md:col-span-1 col-span-3">
                            <p>Status Pesanan</p>
                        </div>
                        <div class="status_order md:text-base text-sm md:col-span-1 col-span-4">
                            <button type="button" class="text-white md:py-1 md:px-2 px-1 rounded font-semibold" 
                            :class="{
                                'bg-yellow-100 border-solid border-2 border-yellow-500 text-yellow-600':  detail_trx.transaction_order_status   === 'Waiting',
                                'bg-rose-100 border-solid border-2 border-rose-500 text-rose-600':    detail_trx.transaction_order_status   === 'Failure',
                                'bg-green-100 border-solid border-2 border-green-500 text-green-600':   detail_trx.transaction_order_status   === 'Success',
                                'bg-blue-100 border-solid border-2 border-blue-500 text-blue-600':   detail_trx.transaction_order_status   === 'Process',
                            }">
                            <p
                             :class="{
                                'text-yellow-600':  detail_trx.transaction_order_status   === 'Waiting',
                                'text-rose-600':    detail_trx.transaction_order_status   === 'Failure',
                                'text-green-600':   detail_trx.transaction_order_status   === 'Success',
                                'text-blue-600':   detail_trx.transaction_order_status    === 'Process',
                            }"
                             x-text="detail_trx.transaction_order_status === 'Waiting' ? 'Menunggu Pembayaran Berhasil' : (detail_trx.transaction_order_status === 'Process' ? 'Pesanan Sedang Diproses' : (detail_trx.transaction_order_status === 'Failure') ? 'Pesanan Gagal Di Proses' : 'Pesanan Berhasil Di Proses')"></p>
                            </button>
                        </div>
                    </div>
                    <hr class="dashed_border mt-3 mb-3">
                    <div class="expired_order grid md:grid-cols-2 grid-cols-7 gap-2 mt-2">
                        <div class="text_expirder_order text-slate-300 md:col-span-1 col-span-3">
                            <p>Bayar Sebelum</p>
                        </div>
                        <div class="description_expired_order md:col-span-1 col-span-4">
                            <div class="right_item flex items-center sm:space-x-2 space-x-1">
                                <div
                                    class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
                                    <p class="text-rose-400 font-semibold" x-text="countdown.minutes"></p>
                                    <p class="text-slate-500 font-semibold">Menit</p>
                                </div>
                                <p class="font-extrabold text-primary-slate-light">:</p>
                                <div
                                    class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
                                    <p class="text-rose-400 font-semibold" x-text="countdown.seconds"></p>
                                    <p class="text-slate-500 font-semibold">Detik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="dashed_border mt-3 mb-1">
                    <div class="barcode mt-5">
                        <p class="font-extrabold text-xl text-slate-300">PEMBAYARAN</p>
                        <p class="md:text-sm text-xs text-slate-300">Silahkan scan QR Code berikut untuk melanjutkan pembayaran</p>
                        <img :src="`${detail_trx.qr_code_url}`" class="object-cover w-48 h-48 rounded-md mt-3 md:mx-0 mx-auto"
                            alt="QR Code">
                    </div>
                    <div class="intruction_payment mt-5">
                        <p class="font-extrabold text-xl text-slate-300">INTRUKSI PEMBAYARAN</p>
                        <div class="mt-5 mb-3 text-white">
                            <div class="accordion-1 md:w-2/3 w-full text-left">
                                <button
                                    class="w-full flex items-center justify-between bg-primary-slate-light p-4 px-4 rounded-t-md"
                                    @click="selectedAccordion = (selectedAccordion === 1) ? null : 1">
                                    <span class=" font-bold capitalize">cara bayar aplikasi dengan Go-jek</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6"
                                        :class="{'rotate-180 transition-transform transform origin-center duration-150' : selectedAccordion === 1}">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="selectedAccordion === 1" x-transition:enter="transition duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition duration-150"
                                    x-transition:leave="opacity-20 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-4" x-cloak
                                    class=" bg-primary-slate-light p-3 px-6 h-auto">
                                    <ul class="list-disc mx-6 font-semibold">
                                        <li>Download atau Screenshot foto GoPay QRIS diatas</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="accordion-2 md:w-2/3 w-full mt-4 text-left">
                                <button
                                    class="w-full flex items-center justify-between bg-primary-slate-light p-4 px-4 rounded-t-md"
                                    @click="selectedAccordion = (selectedAccordion === 2) ? null : 2">
                                    <span class=" font-bold capitalize">cara bayar aplikasi dengan Gopay</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6"
                                        :class="{'rotate-180 transition duration-150' : selectedAccordion === 2}">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="selectedAccordion === 2" x-transition:enter="transition duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition duration-150"
                                    x-transition:leave="opacity-20 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-4" x-cloak
                                    class=" bg-primary-slate-light p-3 px-6 h-auto">
                                    <ul class="list-disc mx-6 font-semibold">
                                        <li>Download atau Screesnhot Barcode GoPay QRIS diatas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @push('js-custom')
    <script>
      
      function handlePurchaseOrder() {
            return {
                detail_order: [],
                detail_trx: [],
                transaction_status: '',
                isLoading: false,
                end: null,
                countdown: {
                    minutes: 0,
                    seconds: 0,
                },
                selectedAccordion: null,
                copiedInvoice: false,

                init() {
                  this.getStatusOrder('{{ $invoice }}')
                },

                initializeCountdownOrder(detail_trx) {
                    const orderStart = new Date(detail_trx.transaction_time)
                    const orderEnd = new Date(detail_trx.transaction_expired)
                    this.end = orderEnd.getTime();

                    const intervalCheckExpiredOrder = setInterval(() => {
                        const now = Date.now();
                        if (now <= this.end) {
                            this.calculateCountdown(this.end);
                        } else {
                            clearInterval(intervalCheckExpiredOrder);
                        }
                    }, 1000);
                },

                getStatusOrder(invoice) {
                  this.isLoading = true
                  axios.get('/api/get-token').then(res => {
                        const token = res.data.data
                        axios.get(`/api/order/detail-order/${invoice}`, {
                            headers: {
                                'X-Custom-Token' : `${token}`
                            }
                        }).then(res => {
                            const response = res.data.data
                            this.detail_order = response.detail_order
                            this.detail_trx = response.detail_trx
                            this.initializeCountdownOrder(this.detail_trx)

                            this.isLoading = false
                        }).catch(err => {
                            this.isLoading = false
                            console.log("DETAIL ORDER ERROR", err)
                        })
                    })
                },

                calculateCountdown(targetTime) {
                    const timeDiff = targetTime - Date.now();
                    this.countdown.minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60)).toString()
                        .padStart(2, '0');
                    this.countdown.seconds = Math.floor((timeDiff % (1000 * 60)) / 1000).toString().padStart(2, '0');
                },

                copyToClipboardInvoice() {
                    this.copiedInvoice = false

                    const textToCopy = document.getElementById('invoice-order').textContent;
                    const targetElement = document.createElement('textarea');
                    targetElement.value = textToCopy;
                    document.body.appendChild(targetElement);
                    targetElement.select();
                    
                    try {
                        document.execCommand('copy');
                        this.copiedInvoice = true
                    } catch (err) {
                        console.error('Gagal menyalin teks ke clipboard:', err);
                        this.copiedInvoice = false
                    } finally {
                        document.body.removeChild(targetElement);
                    }

                    setTimeout(() => {
                        this.copiedInvoice = false;
                    }, 3000);
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
