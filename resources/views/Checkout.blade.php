<x-app-layout>
  <style>
    .dashed_border {
      border-top: 1px dashed rgb(100 116 139);
    }
  </style>
  <div class="bg-primary-slate-light h-full w-full">
        <div class="md:block hidden">
            <div class="breadcrumbs w-80 h-auto p-1 pb-2 px-3 bg-primary-slate border-0 border-solid border-b border-r border-primary-cyan-light">
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
        <main class="w-full h-full">
            <div class="w-full flex justify-center items-center">
                <div class="box__invoice mt-10 mb-56 w-3/4 h-auto p-2 bg-white border border-solid border-black">
                  <div class="header_inv flex items-center justify-between">
                    <p class="text-start font-extrabold text-slate-600 text-2xl">INVOICE</p>
                    <div class="right_section flex items-center space-x-2">
                      <div class="store_name_and_logo">
                        <p class="text-xl font-bold text-end">{{ env('APP_NAME') }}</p>
                        <p class="text-xs">{{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}</p>
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
                        <p class="text-slate-600 font-semibold">: {{ $detail_order->created_at->format('d F y') }}</p>
                      </div>
                    </div>
                    <hr class="dashed_border mt-2 mb-1">
                    <div class="detail_customer grid grid-cols-2 gap-2">
                      <div class="title_inv">
                        <p>Email</p>
                      </div>
                      <div class="description_inv">
                        <p class="text-slate-600 font-semibold">: {{ $detail_order->email ? $detail_order->email : "XXXXXX@gmail.com" }}</p>
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
                              <div class="">
                                <p class="text-white font-semibold">1</p>
                              </div>
                            </td>
                            <td class="p-1.5">
                              <div class="">
                                <p class="text-white font-semibold">{{ $detail_order->product->product_name }}</p>
                              </div>
                            </td>
                            <td class="p-1.5">
                              <div class="">
                                <p class="text-white font-semibold">{{ $detail_order->qty }}</p>
                              </div>
                            </td>
                            <td class="p-1.5">
                              <div class="">
                                <p class="text-white font-semibold">Rp. {{ Cash($detail_order->price, 2) }}</p>
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
                        <img src="{{ asset('/img/' . $detail_order->payment->img_static) }}" class="w-20 h-auto" alt="detail payment">
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
                </div>
            </div>
        </main>
    </div>
</x-app-layout>