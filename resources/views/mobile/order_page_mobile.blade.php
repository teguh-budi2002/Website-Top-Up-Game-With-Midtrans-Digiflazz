  <div class="md:hidden block w-full h-full bg-black pb-10">
      <div class="left_section_mobile">
          <div class="form_wrapper w-full h-fit p-8 md:shadow-lg shadow-slate-800 bg-primary-slate">
              <form @submit.prevent="checkoutOrder" method="POST">
                  <div
                      class="add_player_id bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded">
                      <div class="step_one flex justify-between items-center mb-3">
                          <p>{!! $custom_field->text_title_on_order_page ?? 'Masukkan Player ID Anda' !!}
                          </p>
                          <div class="w-fit bg-primary-slate text-white p-2 rounded-lg">
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
                          <p class="capitalize">Pilih jumlah nominal item.</p>
                          <div class="w-fit bg-primary-slate text-white p-2 rounded-lg">
                              <p>STEP 2</p>
                          </div>
                      </div>
                      <div class="ERR_MESS mb-3 mt-3" x-show="errMess.errorItem">
                          <p x-text="errMess.errorItem" class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                              role="errorItemMessage"></p>
                      </div>
                      <ul class="list-none flex flex-wrap justify-center mx-0 items-center gap-3 mt-3">
                          @foreach ($product->items as $item)
                          <li>
                              <div @click.prevent="activeItem = {{ $item->id }}; data.price = {{ $item->price }}; selectedItemProduct()"
                                  :class="{ 'bg-slate-300/60 border-rose-500': activeItem === {{ $item->id }}, 'bg-slate-500 hover:bg-slate-300/90 border-[1px] border-white text-white': activeItem !== {{ $item->id }} }"
                                  class="items w-[180px] h-[100px] flex flex-col justify-center items-center space-y-2 rounded-md p-2
                                    border border-gray-400 border-solid cursor-pointer" data-item-id="{{ $item->id }}">
                                  <p class="font-semibold capitalize">{{ $item->nominal }} -
                                      {{ $item->item_name }}</p>
                                  <p class="text-xs">Harga</p>
                                  <p class="text-sm text-rose-600">Rp. {{ Cash($item->price, 2) }}</p>
                              </div>
                          </li>
                          @endforeach
                      </ul>
                  </div>
                  <div class="payment__type mt-5 bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded"
                      x-show="activeItem !== null"
                      x-transition:enter="transition-opacity duration-300"
                      x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0"
                      x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100"
                      x-transition:leave-end="opacity-0">
                      <div class="step_three flex items-center justify-between mb-5">
                          <p class="capitalize">Pilih metode pembayaran.</p>
                          <div class="w-fit bg-primary-slate text-white p-2 rounded-lg">
                              <p>STEP 3</p>
                          </div>
                      </div>
                      <div class="ERR_MESS mb-3" x-show="errMess.errorPaymentId">
                          <p x-text="errMess.errorPaymentId"
                              class="w-full bg-red-300 rounded text-red-700 p-1.5 font-normal"
                              role="errorPaymentMessage"></p>
                      </div>
                      @foreach ($product->paymentMethods as $payment)
                      <div class="{{ $payment->payment_name }}__payment mb-3"
                          @click.prevent="paymentSelected = '{{ $payment->payment_name }}'; selectedPaymentId = '{{ $payment->id }}'; selectedPayment()">
                          <div>
                              <label for="{{ $payment->payment_name }}__payment"
                                  class="flex items-center justify-between py-2 px-4 rounded hover:bg-slate-400/60 border border-solid border-slate-500 cursor-pointer "
                                  :class="{'bg-slate-400/60 border-slate-300' : paymentSelected === '{{ $payment->payment_name }}' }">
                                  <input type="radio" x-model="data.payment_id" value="{{ $payment->id }}"
                                      name="payment_id" class="hidden" id="{{ $payment->payment_name }}__payment">
                                  <img src="{{ asset('/img/' . $payment->img_static) }}" class="w-auto h-8"
                                      alt="logo_{{ $payment->payment_name }}">
                              </label>
                          </div>
                      </div>
                      <div x-show="paymentSelected === '{{ $payment->payment_name }}'"
                          x-transition:enter="transition-opacity duration-300"
                          x-transition:leave="transition-opacity duration-300" x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100" x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"
                          class="detail__fee__and__price mb-3 bg-slate-400 rounded-b p-1.5 flex justify-between items-center">
                          <p class="font-extrabold uppercase">Total Harga</p>
                          <p class="font-extrabold uppercase" x-text="priceIncludeFee"></p>
                      </div>
                      @endforeach
                  </div>
                  <div
                      class="additional_input mt-5 bg-primary-slate-light border border-slate-500 text-white border-solid w-full p-4 rounded">
                      <div class="step_three flex items-center justify-between mb-5">
                          <p class="capitalize">Detail Pembeli (Opsional)</p>
                          <div class="w-fit bg-primary-slate text-white p-2 rounded-lg">
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
                          <p class="text-xs mt-3 italic text-gray-300 font-thin">Silahkan masukkan email
                              anda jika ingin menerima bukti pembelian Anda</p>
                      </div>
                  </div>
                  <div class="btn_checkout mt-5">
                      <button type="submit" class="py-2.5 px-6 rounded-md bg-teal-500 text-white cursor-pointer">Bayar
                          Sekarang</button>
                  </div>
              </form>
          </div>
      </div>
      <div class="right_section_mobile mx-3">
          <div class="wrapper">
              <div class="top_seaction md:block hidden border-0 border-b border-solid border-slate-500 pb-4 mr-20">
                  <img src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}"
                      class="w-28 h-28 rounded-full border border-solid border-slate-400"
                      alt="logo {{ $product->product_name }}">
                  <p class="mt-5 font-bold text-2xl text-white">Top Up
                      Game [{{ $product->product_name }}]</p>
              </div>
              <div class="badge md:visible invisible flex flex-wrap items-center space-x-3 mt-5">
                  <div
                      class="badge_support flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                      </svg>
                      <span class="font-semibold">Layanan 24 Jam</span>
                  </div>
                  <div
                      class="badge_fast_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                      </svg>
                      <span class="font-semibold">Proses Transaksi Cepat</span>
                  </div>
                  <div
                      class="badge_secure_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-xs transition-colors duration-150">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                      </svg>
                      <span class="font-semibold">Pembayaran Aman</span>
                  </div>
              </div>
              <div class="guide_topup mt-5">
                  <p class="text-white">Cara Top Up <span class="font-semibold underline">{{ $product->product_name }}
                          :</span></p>
                  <ol class="list-decimal text-white text-sm space-y-2 ml-5 mt-2">
                      <li>Masukkan ID.</li>
                      <li>Pilih Nominal Item.</li>
                      <li>Pilih Metode Pembayran.</li>
                      <li>Klik Beli Sekarang dan Lakukan Pembayaran.</li>
                      <li>Tunggu Beberapa Menit, Maka Item Yang Dibeli Akan Otomatis Masuk Di Akun Anda
                      </li>
                  </ol>
              </div>
              <div class="describe_about_{{ $product->product_name }} mt-5">
                  <p class="text-slate-400 font-semibold text-4xl">{{ $product->product_name }}</p>
                  <p class="text-slate-300 pr-20 text-sm leading-normal pt-3">{!!
                      $custom_field->detail_for_product ?? '' !!}</p>
              </div>
          </div>
      </div>
  </div>
